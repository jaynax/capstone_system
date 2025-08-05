@echo off
echo ========================================
echo    Fish Monitoring ML API Startup
echo ========================================
echo.

REM Check if Python is installed
python --version >nul 2>&1
if errorlevel 1 (
    echo ERROR: Python is not installed or not in PATH
    echo Please install Python 3.8+ and try again
    pause
    exit /b 1
)

echo Python found. Checking dependencies...

REM Install dependencies if requirements.txt exists
if exist requirements.txt (
    echo Installing Python dependencies...
    pip install -r requirements.txt
    if errorlevel 1 (
        echo ERROR: Failed to install dependencies
        pause
        exit /b 1
    )
    echo Dependencies installed successfully.
) else (
    echo WARNING: requirements.txt not found
)

echo.
echo Starting ML API server...
echo.
echo The API will be available at: http://localhost:5000
echo Press Ctrl+C to stop the server
echo.

REM Start the API server
python start.py

pause 