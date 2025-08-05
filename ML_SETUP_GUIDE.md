# Fish Monitoring System - ML Integration Setup Guide

This guide will help you set up the complete Fish Monitoring System with machine learning capabilities for species recognition and size estimation.

## 🎯 System Overview

The system consists of:
1. **Laravel Web Application** - Main fish monitoring system
2. **Python ML API** - Machine learning models for fish analysis
3. **Database** - MySQL/PostgreSQL for data storage
4. **Frontend** - Bootstrap-based responsive interface

## 🧠 ML Models Integrated

### 1. Species Recognition: CNN + MobileNetV2
- **Purpose**: Identify fish species from images
- **Input**: 224x224 RGB images
- **Output**: Species classification with confidence scores
- **Supported Species**: 7 common Philippine fish species

### 2. Fish Detection: YOLOv8
- **Purpose**: Detect and localize fish in images
- **Input**: Full-size images
- **Output**: Bounding boxes with confidence scores

### 3. Size Estimation: OpenCV + Computer Vision
- **Purpose**: Estimate fish length and weight
- **Input**: Cropped fish images from YOLOv8
- **Output**: Length in cm and estimated weight in grams

## 🚀 Quick Start

### Prerequisites
- PHP 8.0+ with Laravel
- Python 3.8+
- MySQL/PostgreSQL
- Composer
- Node.js (for frontend assets)

### Step 1: Laravel Setup

1. **Install Laravel dependencies**
```bash
composer install
```

2. **Configure environment**
```bash
cp .env.example .env
php artisan key:generate
```

3. **Configure database in `.env`**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fishmonitoring
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

4. **Run migrations**
```bash
php artisan migrate
```

5. **Seed database (optional)**
```bash
php artisan db:seed
```

6. **Start Laravel server**
```bash
php artisan serve
```

### Step 2: ML API Setup

1. **Navigate to ML API directory**
```bash
cd ml_api
```

2. **Install Python dependencies**
```bash
pip install -r requirements.txt
```

3. **Create models (first time only)**
```bash
python create_models.py
```

4. **Start ML API server**
```bash
# Windows
start_ml_api.bat

# Linux/Mac
chmod +x start_ml_api.sh
./start_ml_api.sh

# Or directly with Python
python start.py
```

### Step 3: Verify Setup

1. **Check Laravel application**
   - Visit: `http://localhost:8000`
   - Should show the fish monitoring dashboard

2. **Check ML API health**
   - Visit: `http://localhost:5000/health`
   - Should return healthy status

3. **Test ML integration**
   - Go to: `http://localhost:8000/catch/create`
   - Upload a fish image
   - Check if species recognition works

## 📊 System Architecture

```
┌─────────────────┐    HTTP    ┌─────────────────┐
│   Laravel Web   │ ────────── │   Python ML     │
│   Application   │            │     API         │
│                 │            │                 │
│ - User Interface│            │ - CNN + MobileNetV2│
│ - Database      │            │ - YOLOv8        │
│ - Authentication│            │ - OpenCV        │
└─────────────────┘            └─────────────────┘
         │                              │
         │                              │
         ▼                              ▼
┌─────────────────┐            ┌─────────────────┐
│   Database      │            │   Model Files   │
│   (MySQL/PostgreSQL)│            │                 │
│                 │            │ - fish_species_model.h5│
│ - Users         │            │ - yolov8_fish.pt│
│ - Fish Catches  │            └─────────────────┘
│ - Reports       │
└─────────────────┘
```

## 🔧 Configuration

### Laravel Configuration

1. **Database Configuration**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fishmonitoring
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

2. **ML API Configuration**
```env
ML_API_URL=http://localhost:5000
ML_API_TIMEOUT=30
```

### ML API Configuration

1. **Environment Variables**
```env
FLASK_ENV=production
MODEL_PATH=models/
UPLOAD_PATH=uploads/
CROP_PATH=fish_crops/
```

2. **Model Files**
Place your trained models in `ml_api/models/`:
- `fish_species_model.h5` - CNN + MobileNetV2 model
- `yolov8_fish.pt` - YOLOv8 model

## 🧪 Testing the System

### 1. Test Laravel Application
```bash
# Run tests
php artisan test

# Check routes
php artisan route:list
```

### 2. Test ML API
```bash
# Health check
curl http://localhost:5000/health

# Model information
curl http://localhost:5000/models

# Test prediction (replace with actual image)
curl -X POST -F "image=@test_image.jpg" http://localhost:5000/predict
```

### 3. Test Integration
1. Go to `http://localhost:8000/catch/create`
2. Upload a fish image
3. Check if species and size are detected
4. Submit the form

## 📁 File Structure

```
fishmonitoring/
├── app/
│   ├── Http/Controllers/
│   │   └── FishCatchController.php    # ML integration controller
│   └── Models/
│       └── FishCatch.php              # Fish catch model
├── resources/views/
│   └── catch/
│       └── create.blade.php           # ML-enabled form
├── routes/
│   └── web.php                        # ML API routes
├── ml_api/
│   ├── app.py                         # Main ML API
│   ├── create_models.py               # Model creation
│   ├── start.py                       # Startup script
│   ├── requirements.txt               # Python dependencies
│   ├── models/                        # Model files
│   │   ├── fish_species_model.h5
│   │   └── yolov8_fish.pt
│   └── fish_crops/                    # Cropped images
└── README.md
```

## 🔍 Troubleshooting

### Common Issues

1. **ML API not responding**
   - Check if Python dependencies are installed
   - Verify port 5000 is available
   - Check logs for error messages

2. **Models not loading**
   - Ensure model files exist in `ml_api/models/`
   - Check file permissions
   - Verify model file formats

3. **Laravel can't connect to ML API**
   - Check if ML API is running on `localhost:5000`
   - Verify network connectivity
   - Check firewall settings

4. **Image upload issues**
   - Check file size limits
   - Verify image format (JPEG, PNG, JPG, GIF)
   - Check storage permissions

### Debug Commands

```bash
# Check Laravel logs
tail -f storage/logs/laravel.log

# Check ML API logs (in terminal where API is running)
# Look for ✅ success, ❌ error, ⚠️ warning messages

# Test database connection
php artisan tinker
DB::connection()->getPdo();

# Test ML API connection
curl http://localhost:5000/health
```

## 🔄 Development Workflow

### 1. Starting Development Environment
```bash
# Terminal 1: Start Laravel
php artisan serve

# Terminal 2: Start ML API
cd ml_api
python start.py
```

### 2. Making Changes
1. **Laravel changes**: Edit PHP files, refresh browser
2. **ML API changes**: Restart Python server
3. **Database changes**: Run `php artisan migrate`

### 3. Testing Changes
1. Test Laravel routes
2. Test ML API endpoints
3. Test full integration flow

## 📈 Performance Optimization

### Laravel Optimization
```bash
# Cache routes and config
php artisan route:cache
php artisan config:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev
```

### ML API Optimization
1. **GPU Acceleration**: Install CUDA-compatible TensorFlow
2. **Model Quantization**: Use smaller model variants
3. **Batch Processing**: Process multiple images at once

## 🔒 Security Considerations

1. **API Security**
   - Use HTTPS in production
   - Implement API rate limiting
   - Add authentication for ML API

2. **File Upload Security**
   - Validate file types and sizes
   - Scan uploaded images for malware
   - Store files securely

3. **Data Privacy**
   - Encrypt sensitive data
   - Implement data retention policies
   - Follow GDPR compliance

## 🚀 Production Deployment

### 1. Laravel Deployment
```bash
# Set production environment
APP_ENV=production
APP_DEBUG=false

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 2. ML API Deployment
```bash
# Use production WSGI server
pip install gunicorn
gunicorn -w 4 -b 0.0.0.0:5000 app:app

# Or use Docker
docker build -t fish-ml-api .
docker run -p 5000:5000 fish-ml-api
```

### 3. Database Optimization
```sql
-- Add indexes for better performance
CREATE INDEX idx_catches_user_id ON catches(user_id);
CREATE INDEX idx_catches_created_at ON catches(created_at);
```

## 📞 Support

For issues and questions:
1. Check the troubleshooting section
2. Review logs for error messages
3. Test individual components
4. Contact the development team

## 🔮 Future Enhancements

1. **Model Improvements**
   - Retrain with more diverse data
   - Add more fish species
   - Implement ensemble methods

2. **System Enhancements**
   - Real-time processing
   - Mobile app integration
   - Advanced analytics dashboard

3. **Performance Improvements**
   - GPU acceleration
   - Model quantization
   - Caching strategies

---

**Note**: This system uses placeholder models for demonstration. Replace with your actual trained models for production use. 