from flask import Flask, request, jsonify
from flask_cors import CORS
from tensorflow.keras.models import load_model
from tensorflow.keras.preprocessing.image import img_to_array
from tensorflow.keras.applications.mobilenet_v2 import preprocess_input
from PIL import Image
import numpy as np
import cv2
from ultralytics import YOLO
import os
import time
import logging
from datetime import datetime

# Configure logging
logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

app = Flask(__name__)
CORS(app)  # Enable CORS for all routes

# Global variables for models
species_model = None
yolo_model = None

# Fish species database
FISH_SPECIES = {
    "Tilapia": {
        "scientific_name": "Oreochromis niloticus",
        "common_names": ["Nile Tilapia", "Tilapia"],
        "weight_formula": "W = 0.0001 * L^3.2",  # Weight in grams, Length in cm
        "legal_size_cm": 10.0
    },
    "Bangus": {
        "scientific_name": "Chanos chanos",
        "common_names": ["Milkfish", "Bangus"],
        "weight_formula": "W = 0.00008 * L^3.1",
        "legal_size_cm": 15.0
    },
    "Tuna": {
        "scientific_name": "Thunnus albacares",
        "common_names": ["Yellowfin Tuna", "Tuna"],
        "weight_formula": "W = 0.00012 * L^3.0",
        "legal_size_cm": 20.0
    },
    "Galunggong": {
        "scientific_name": "Decapterus macarellus",
        "common_names": ["Mackerel Scad", "Galunggong"],
        "weight_formula": "W = 0.00009 * L^3.1",
        "legal_size_cm": 12.0
    },
    "Tamban": {
        "scientific_name": "Sardinella spp.",
        "common_names": ["Sardine", "Tamban"],
        "weight_formula": "W = 0.00007 * L^3.0",
        "legal_size_cm": 8.0
    },
    "Lapu-lapu": {
        "scientific_name": "Epinephelus spp.",
        "common_names": ["Grouper", "Lapu-lapu"],
        "weight_formula": "W = 0.00015 * L^3.3",
        "legal_size_cm": 18.0
    },
    "Maya-maya": {
        "scientific_name": "Lutjanus spp.",
        "common_names": ["Red Snapper", "Maya-maya"],
        "weight_formula": "W = 0.00011 * L^3.2",
        "legal_size_cm": 15.0
    }
}

def load_models():
    """Load ML models with error handling"""
    global species_model, yolo_model
    
    try:
        # Load CNN + MobileNetV2 model for species recognition
        model_path = os.path.join(os.path.dirname(__file__), 'models', 'fish_species_model.h5')
        if os.path.exists(model_path):
            species_model = load_model(model_path)
            logger.info("✅ Species recognition model (CNN + MobileNetV2) loaded successfully")
        else:
            logger.warning("⚠️ Species model not found, using fallback")
            species_model = None
        
        # Load YOLOv8 model for fish detection
        yolo_path = os.path.join(os.path.dirname(__file__), 'models', 'yolov8_fish.pt')
        if os.path.exists(yolo_path):
            yolo_model = YOLO(yolo_path)
            logger.info("✅ YOLOv8 fish detection model loaded successfully")
        else:
            logger.warning("⚠️ YOLOv8 model not found, using fallback")
            yolo_model = None
            
    except Exception as e:
        logger.error(f"❌ Error loading models: {str(e)}")
        species_model = None
        yolo_model = None

def calculate_weight_from_length(species, length_cm):
    """Calculate estimated weight from length using species-specific formulas"""
    if species not in FISH_SPECIES:
        return None
    
    formula = FISH_SPECIES[species]["weight_formula"]
    
    # Extract coefficients from formula: W = a * L^b
    if "L^3.2" in formula:
        a, b = 0.0001, 3.2
    elif "L^3.1" in formula:
        a, b = 0.00008, 3.1
    elif "L^3.0" in formula:
        a, b = 0.00012, 3.0
    elif "L^3.3" in formula:
        a, b = 0.00015, 3.3
    else:
        # Default formula
        a, b = 0.0001, 3.0
    
    weight_g = a * (length_cm ** b)
    return round(weight_g, 2)

def detect_fish_yolo(image):
    """Detect fish using YOLOv8"""
    if yolo_model is None:
        return None, 0.0, None
    
    try:
        results = yolo_model(image, conf=0.5)  # Confidence threshold
        
        if len(results) == 0 or results[0].boxes is None:
            return None, 0.0, None
        
        # Get the best detection
        boxes = results[0].boxes
        if len(boxes) == 0:
            return None, 0.0, None
        
        # Get the highest confidence detection
        confidences = boxes.conf.cpu().numpy()
        best_idx = np.argmax(confidences)
        
        box = boxes.xyxy[best_idx].cpu().numpy()
        confidence = confidences[best_idx]
        
        x1, y1, x2, y2 = map(int, box)
        bbox = {
            'x1': x1, 'y1': y1, 'x2': x2, 'y2': y2,
            'width': x2 - x1, 'height': y2 - y1
        }
        
        return bbox, confidence, results[0]
        
    except Exception as e:
        logger.error(f"Error in YOLOv8 detection: {str(e)}")
        return None, 0.0, None

def recognize_species(image):
    """Recognize fish species using CNN + MobileNetV2"""
    if species_model is None:
        return "Unknown", 0.0, "Unknown"
    
    try:
        # Preprocess image for MobileNetV2
        img_rgb = cv2.cvtColor(image, cv2.COLOR_BGR2RGB)
        img_resized = cv2.resize(img_rgb, (224, 224))
        img_array = img_to_array(img_resized)
        img_preprocessed = preprocess_input(img_array)
        img_batch = np.expand_dims(img_preprocessed, axis=0)
        
        # Predict species
        predictions = species_model.predict(img_batch, verbose=0)
        confidence = float(np.max(predictions))
        predicted_idx = np.argmax(predictions)
        
        # Map to species names
        species_list = list(FISH_SPECIES.keys())
        if predicted_idx < len(species_list):
            species = species_list[predicted_idx]
            scientific_name = FISH_SPECIES[species]["scientific_name"]
        else:
            species = "Unknown"
            scientific_name = "Unknown"
        
        return species, confidence, scientific_name
        
    except Exception as e:
        logger.error(f"Error in species recognition: {str(e)}")
        return "Unknown", 0.0, "Unknown"

def estimate_size_opencv(image, bbox):
    """Estimate fish size using OpenCV"""
    try:
        # Extract fish region
        x1, y1, x2, y2 = bbox['x1'], bbox['y1'], bbox['x2'], bbox['y2']
        fish_region = image[y1:y2, x1:x2]
        
        if fish_region.size == 0:
            return None, None, None
        
        # Convert to grayscale for edge detection
        gray = cv2.cvtColor(fish_region, cv2.COLOR_BGR2GRAY)
        
        # Apply Gaussian blur
        blurred = cv2.GaussianBlur(gray, (5, 5), 0)
        
        # Edge detection
        edges = cv2.Canny(blurred, 50, 150)
        
        # Find contours
        contours, _ = cv2.findContours(edges, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)
        
        if not contours:
            return None, None, None
        
        # Find the largest contour (assumed to be the fish)
        largest_contour = max(contours, key=cv2.contourArea)
        
        # Get bounding rectangle
        x, y, w, h = cv2.boundingRect(largest_contour)
        
        # Estimate length (assuming fish is horizontal)
        length_pixels = max(w, h)
        
        # Convert pixels to cm (this would need calibration with a reference object)
        # For now, using a rough estimate: 1 pixel ≈ 0.1 cm
        pixels_per_cm = 10.0  # This should be calibrated with a reference object
        length_cm = length_pixels / pixels_per_cm
        
        return length_cm, length_pixels, pixels_per_cm
        
    except Exception as e:
        logger.error(f"Error in size estimation: {str(e)}")
        return None, None, None

@app.route('/predict', methods=['POST'])
def predict():
    """Main prediction endpoint"""
    try:
        # Check if image is provided
    if 'image' not in request.files:
        return jsonify({'error': 'No image uploaded'}), 400

        image_file = request.files['image']
        if image_file.filename == '':
            return jsonify({'error': 'No image selected'}), 400
        
        # Read image
        file_bytes = np.frombuffer(image_file.read(), np.uint8)
        image = cv2.imdecode(file_bytes, cv2.IMREAD_COLOR)
        
        if image is None:
            return jsonify({'error': 'Invalid image format'}), 400
        
        logger.info(f"Processing image: {image_file.filename}")
        
        # Step 1: YOLOv8 Fish Detection
        bbox, detection_confidence, yolo_results = detect_fish_yolo(image)
        
        if bbox is None:
            return jsonify({
                'error': 'No fish detected in the image',
                'detection_confidence': 0.0
            }), 200
        
        # Step 2: Extract fish region
        x1, y1, x2, y2 = bbox['x1'], bbox['y1'], bbox['x2'], bbox['y2']
        fish_crop = image[y1:y2, x1:x2]
        
        # Step 3: CNN + MobileNetV2 Species Recognition
        species, species_confidence, scientific_name = recognize_species(fish_crop)
        
        # Step 4: OpenCV Size Estimation
        length_cm, length_pixels, pixels_per_cm = estimate_size_opencv(image, bbox)
        
        # Step 5: Calculate weight from length
        weight_g = None
        if length_cm and species in FISH_SPECIES:
            weight_g = calculate_weight_from_length(species, length_cm)
        
        # Step 6: Save cropped fish image
    timestamp = int(time.time())
        fish_crops_dir = os.path.join(os.path.dirname(__file__), 'fish_crops')
        os.makedirs(fish_crops_dir, exist_ok=True)
        crop_filename = f'fish_crop_{timestamp}.jpg'
        crop_path = os.path.join(fish_crops_dir, crop_filename)
        cv2.imwrite(crop_path, fish_crop)
        
        # Prepare response
        response_data = {
            'species': species,
            'scientific_name': scientific_name,
            'confidence_score': round(species_confidence * 100, 2),
            'detection_confidence': round(detection_confidence * 100, 2),
            'length_cm': round(length_cm, 2) if length_cm else None,
            'weight_g': weight_g,
            'bbox_width': bbox['width'],
            'bbox_height': bbox['height'],
            'pixels_per_cm': round(pixels_per_cm, 2) if pixels_per_cm else None,
            'crop_filename': crop_filename,
            'processing_timestamp': datetime.now().isoformat()
        }
        
        # Add species information if available
        if species in FISH_SPECIES:
            response_data['legal_size_cm'] = FISH_SPECIES[species]['legal_size_cm']
            response_data['common_names'] = FISH_SPECIES[species]['common_names']
            response_data['weight_formula'] = FISH_SPECIES[species]['weight_formula']
        
        logger.info(f"Prediction completed: {species} ({species_confidence:.2f})")
        return jsonify(response_data)
        
    except Exception as e:
        logger.error(f"Error in prediction: {str(e)}")
        return jsonify({'error': f'Prediction failed: {str(e)}'}), 500

@app.route('/health', methods=['GET'])
def health_check():
    """Health check endpoint"""
    return jsonify({
        'status': 'healthy',
        'models_loaded': {
            'species_model': species_model is not None,
            'yolo_model': yolo_model is not None
        },
        'timestamp': datetime.now().isoformat()
    })

@app.route('/models', methods=['GET'])
def get_models_info():
    """Get information about loaded models"""
    return jsonify({
        'species_recognition': {
            'model_type': 'CNN + MobileNetV2',
            'loaded': species_model is not None,
            'species_supported': list(FISH_SPECIES.keys())
        },
        'fish_detection': {
            'model_type': 'YOLOv8',
            'loaded': yolo_model is not None
        },
        'size_estimation': {
            'method': 'OpenCV + Computer Vision',
            'available': True
        }
    })

if __name__ == '__main__':
    # Load models on startup
    load_models()
    
    # Create necessary directories
    os.makedirs('fish_crops', exist_ok=True)
    os.makedirs('models', exist_ok=True)
    
    logger.info("🚀 Fish Monitoring ML API starting...")
    logger.info("📊 Models loaded:")
    logger.info(f"   - Species Recognition (CNN + MobileNetV2): {'✅' if species_model else '❌'}")
    logger.info(f"   - Fish Detection (YOLOv8): {'✅' if yolo_model else '❌'}")
    logger.info(f"   - Size Estimation (OpenCV): ✅")
    
    app.run(host='0.0.0.0', port=5000, debug=False) 