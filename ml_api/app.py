from flask import Flask, request, jsonify
from tensorflow.keras.models import load_model
from tensorflow.keras.preprocessing.image import img_to_array
from PIL import Image
import numpy as np
import cv2
from ultralytics import YOLO
import os
import time

app = Flask(__name__)

# Load models
species_model = load_model('fish_species_model.h5')
yolo_model = YOLO('yolov8_fish.pt')  # Path to your YOLOv8 weights

label_map = ['Tilapia', 'Bangus', 'Tuna', 'Galunggong', 'Tamban']
scientific_names = {
    "Tilapia": "Oreochromis niloticus",
    "Bangus": "Chanos chanos",
    "Tuna": "Thunnus albacares",
    "Galunggong": "Decapterus macarellus",
    "Tamban": "Sardinella spp."
}

@app.route('/predict', methods=['POST'])
def predict():
    if 'image' not in request.files:
        return jsonify({'error': 'No image uploaded'}), 400

    # Read image as OpenCV array
    file_bytes = np.frombuffer(request.files['image'].read(), np.uint8)
    img_cv = cv2.imdecode(file_bytes, cv2.IMREAD_COLOR)

    # --- YOLOv8: Detect fish ---
    results = yolo_model(img_cv)
    boxes = results[0].boxes.xyxy.cpu().numpy() if results[0].boxes is not None else []

    if len(boxes) == 0:
        return jsonify({'error': 'No fish detected'}), 200

    # Use the first detected fish
    x1, y1, x2, y2 = map(int, boxes[0])
    fish_crop = img_cv[y1:y2, x1:x2]

    # --- OpenCV: Estimate length in pixels ---
    length_px = x2 - x1
    # If you have a reference object, convert px to cm here
    px_to_cm = 0.1  # Example: 1 px = 0.1 cm (adjust as needed)
    length_cm = length_px * px_to_cm

    # --- MobileNetV2: Species recognition ---
    fish_img = cv2.cvtColor(fish_crop, cv2.COLOR_BGR2RGB)
    fish_img = cv2.resize(fish_img, (224, 224))
    fish_img = img_to_array(fish_img) / 255.0
    fish_img = np.expand_dims(fish_img, axis=0)
    prediction = species_model.predict(fish_img)
    idx = np.argmax(prediction)
    predicted_class = label_map[idx]
    scientific_name = scientific_names.get(predicted_class, "")

    # Save the cropped fish image
    timestamp = int(time.time())
    cv2.imwrite(f'fish_crops/{timestamp}.jpg', fish_crop)

    return jsonify({
        'species': predicted_class,
        'scientific_name': scientific_name,
        'length_cm': round(length_cm, 2)
    })

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000) 