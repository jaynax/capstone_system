#!/usr/bin/env python3
"""
Startup script for the Fish Monitoring ML API
This script will:
1. Create placeholder models if they don't exist
2. Start the Flask API server
3. Provide health monitoring
"""

import os
import sys
import subprocess
import time
import requests
from pathlib import Path

def check_dependencies():
    """Check if all required packages are installed"""
    required_packages = [
        'flask', 'tensorflow', 'opencv-python', 'ultralytics',
        'pillow', 'numpy', 'requests'
    ]
    
    missing_packages = []
    
    for package in required_packages:
        try:
            __import__(package.replace('-', '_'))
        except ImportError:
            missing_packages.append(package)
    
    if missing_packages:
        print(f"❌ Missing packages: {', '.join(missing_packages)}")
        print("Please install them using: pip install -r requirements.txt")
        return False
    
    print("✅ All dependencies are installed")
    return True

def create_models():
    """Create placeholder models if they don't exist"""
    models_dir = Path(__file__).parent / 'models'
    models_dir.mkdir(exist_ok=True)
    
    species_model_path = models_dir / 'fish_species_model.h5'
    yolo_model_path = models_dir / 'yolov8_fish.pt'
    
    models_created = 0
    
    # Create species model if it doesn't exist
    if not species_model_path.exists():
        print("🔧 Creating placeholder species recognition model...")
        try:
            from create_models import create_species_model
            if create_species_model():
                models_created += 1
                print("✅ Species model created successfully")
            else:
                print("❌ Failed to create species model")
        except Exception as e:
            print(f"❌ Error creating species model: {e}")
    else:
        print("✅ Species model already exists")
        models_created += 1
    
    # Create YOLO model if it doesn't exist
    if not yolo_model_path.exists():
        print("🔧 Creating placeholder YOLOv8 model...")
        try:
            from create_models import create_yolo_model
            if create_yolo_model():
                models_created += 1
                print("✅ YOLOv8 model created successfully")
            else:
                print("❌ Failed to create YOLOv8 model")
        except Exception as e:
            print(f"❌ Error creating YOLOv8 model: {e}")
    else:
        print("✅ YOLOv8 model already exists")
        models_created += 1
    
    return models_created == 2

def start_api_server():
    """Start the Flask API server"""
    print("\n🚀 Starting Fish Monitoring ML API...")
    print("=" * 50)
    
    # Change to the ml_api directory
    os.chdir(Path(__file__).parent)
    
    # Start the Flask app
    try:
        from app import app
        print("✅ Flask app imported successfully")
        
        # Test the models
        from app import load_models
        load_models()
        
        print("\n📊 ML API Status:")
        print("   - Flask Server: ✅ Ready")
        print("   - Models: Loading...")
        
        # Start the server
        print("\n🌐 Starting server on http://localhost:5000")
        print("📝 API Endpoints:")
        print("   - POST /predict - Fish species recognition and size estimation")
        print("   - GET  /health  - API health check")
        print("   - GET  /models  - Model information")
        print("\nPress Ctrl+C to stop the server")
        
        app.run(host='0.0.0.0', port=5000, debug=False)
        
    except Exception as e:
        print(f"❌ Error starting API server: {e}")
        return False

def health_check():
    """Check if the API is running"""
    try:
        response = requests.get('http://localhost:5000/health', timeout=5)
        if response.status_code == 200:
            data = response.json()
            print("✅ ML API is running")
            print(f"   Status: {data.get('status', 'unknown')}")
            return True
        else:
            print("❌ ML API is not responding properly")
            return False
    except requests.exceptions.RequestException:
        print("❌ ML API is not running")
        return False

if __name__ == "__main__":
    print("🐟 Fish Monitoring ML API Startup")
    print("=" * 40)
    
    # Check dependencies
    if not check_dependencies():
        sys.exit(1)
    
    # Create models
    if not create_models():
        print("⚠️ Some models could not be created. The API will run with limited functionality.")
    
    # Start the server
    start_api_server() 