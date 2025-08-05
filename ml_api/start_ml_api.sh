#!/bin/bash

echo "========================================"
echo "   Fish Monitoring ML API Startup"
echo "========================================"
echo

# Check if Python is installed
if ! command -v python3 &> /dev/null; then
    echo "ERROR: Python 3 is not installed"
    echo "Please install Python 3.8+ and try again"
    exit 1
fi

echo "Python found. Checking dependencies..."
echo

# Install dependencies if requirements.txt exists
if [ -f "requirements.txt" ]; then
    echo "Installing Python dependencies..."
    pip3 install -r requirements.txt
    if [ $? -ne 0 ]; then
        echo "ERROR: Failed to install dependencies"
        exit 1
    fi
    echo "Dependencies installed successfully."
else
    echo "WARNING: requirements.txt not found"
fi

echo
echo "Starting ML API server..."
echo
echo "The API will be available at: http://localhost:5000"
echo "Press Ctrl+C to stop the server"
echo

# Start the API server
python3 start.py 