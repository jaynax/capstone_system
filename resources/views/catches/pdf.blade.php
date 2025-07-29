<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BFAR Fish Catch Report #{{ $catch->id }}</title>
    <style>
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
            .page-break { page-break-before: always; }
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
            color: #333;
            background: white;
        }
        
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        
        .header p {
            margin: 5px 0;
            font-size: 12px;
        }
        
        .section {
            margin-bottom: 20px;
        }
        
        .section-title {
            font-size: 14px;
            font-weight: bold;
            background-color: #f0f0f0;
            padding: 5px 10px;
            margin-bottom: 10px;
            border-left: 4px solid #333;
        }
        
        .row {
            display: flex;
            margin-bottom: 8px;
            flex-wrap: wrap;
        }
        
        .col-6 {
            width: 50%;
            padding-right: 10px;
            box-sizing: border-box;
        }
        
        .col-4 {
            width: 33.33%;
            padding-right: 10px;
            box-sizing: border-box;
        }
        
        .col-3 {
            width: 25%;
            padding-right: 10px;
            box-sizing: border-box;
        }
        
        .col-12 {
            width: 100%;
            margin-bottom: 8px;
        }
        
        .label {
            font-weight: bold;
            margin-bottom: 2px;
        }
        
        .value {
            border-bottom: 1px solid #ccc;
            padding: 2px 0;
            min-height: 16px;
        }
        
        .photo-section {
            text-align: center;
            margin: 20px 0;
        }
        
        .photo-section img {
            max-width: 300px;
            max-height: 200px;
            border: 1px solid #ccc;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #ccc;
            font-size: 10px;
            text-align: center;
        }
        
        .metadata {
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
        }
        
        .metadata table {
            width: 100%;
            font-size: 10px;
        }
        
        .metadata td {
            padding: 2px 5px;
        }
        
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .print-button:hover {
            background: #0056b3;
        }
        
        @media print {
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <button class="print-button no-print" onclick="window.print()">
        🖨️ Print Report
    </button>

    <div class="header">
        <h1>BFAR FISH CATCH MONITORING FORM</h1>
        <p>National Stock Assessment Program (NSAP)</p>
        <p>Report ID: #{{ $catch->id }} | Date: {{ \Carbon\Carbon::parse($catch->date_sampling)->format('F d, Y') }}</p>
    </div>

    <!-- General Information -->
    <div class="section">
        <div class="section-title">✨ GENERAL INFORMATION</div>
        <div class="row">
            <div class="col-6">
                <div class="label">Region:</div>
                <div class="value">{{ $catch->region }}</div>
            </div>
            <div class="col-6">
                <div class="label">Landing Center:</div>
                <div class="value">{{ $catch->landing_center }}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="label">Date of Sampling:</div>
                <div class="value">{{ \Carbon\Carbon::parse($catch->date_sampling)->format('F d, Y') }}</div>
            </div>
            <div class="col-6">
                <div class="label">Time of Landing:</div>
                <div class="value">{{ $catch->time_landing }}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="label">Enumerator(s):</div>
                <div class="value">{{ $catch->enumerators }}</div>
            </div>
            <div class="col-6">
                <div class="label">Fishing Ground:</div>
                <div class="value">{{ $catch->fishing_ground }}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="label">Weather Conditions:</div>
                <div class="value">{{ $catch->weather_conditions }}</div>
            </div>
        </div>
    </div>

    <!-- Boat Information -->
    <div class="section">
        <div class="section-title">🚢 BOAT INFORMATION</div>
        <div class="row">
            <div class="col-6">
                <div class="label">Boat Name (F/B):</div>
                <div class="value">{{ $catch->boat_name }}</div>
            </div>
            <div class="col-6">
                <div class="label">Boat Type:</div>
                <div class="value">{{ $catch->boat_type }}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="label">Length (m):</div>
                <div class="value">{{ number_format($catch->boat_length, 2) }}</div>
            </div>
            <div class="col-3">
                <div class="label">Width (m):</div>
                <div class="value">{{ number_format($catch->boat_width, 2) }}</div>
            </div>
            <div class="col-3">
                <div class="label">Depth (m):</div>
                <div class="value">{{ number_format($catch->boat_depth, 2) }}</div>
            </div>
            <div class="col-3">
                <div class="label">Gross Tonnage (GT):</div>
                <div class="value">{{ $catch->gross_tonnage ? number_format($catch->gross_tonnage, 2) : 'N/A' }}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <div class="label">Horsepower (HP):</div>
                <div class="value">{{ $catch->horsepower ?: 'N/A' }}</div>
            </div>
            <div class="col-4">
                <div class="label">Engine Type:</div>
                <div class="value">{{ $catch->engine_type ?: 'N/A' }}</div>
            </div>
            <div class="col-4">
                <div class="label">Number of Fishermen:</div>
                <div class="value">{{ $catch->fishermen_count }}</div>
            </div>
        </div>
    </div>

    <!-- Fishing Operation Details -->
    <div class="section">
        <div class="section-title">🎯 FISHING OPERATION DETAILS</div>
        <div class="row">
            <div class="col-6">
                <div class="label">Fishing Gear Type:</div>
                <div class="value">{{ $catch->fishing_gear_type }}</div>
            </div>
            <div class="col-6">
                <div class="label">Days Fished:</div>
                <div class="value">{{ $catch->days_fished }}</div>
            </div>
        </div>
        <div class="col-12">
            <div class="label">Gear Specifications:</div>
            <div class="value">{{ $catch->gear_specifications ?: 'N/A' }}</div>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="label">Hooks/Hauls:</div>
                <div class="value">{{ $catch->hooks_hauls ?: 'N/A' }}</div>
            </div>
            <div class="col-3">
                <div class="label">Net/Line Length (m):</div>
                <div class="value">{{ $catch->net_line_length ? number_format($catch->net_line_length, 2) : 'N/A' }}</div>
            </div>
            <div class="col-3">
                <div class="label">Soaking Time (hrs):</div>
                <div class="value">{{ $catch->soaking_time ? number_format($catch->soaking_time, 2) : 'N/A' }}</div>
            </div>
            <div class="col-3">
                <div class="label">Mesh Size (cm):</div>
                <div class="value">{{ $catch->mesh_size ? number_format($catch->mesh_size, 2) : 'N/A' }}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="label">Fishing Location:</div>
                <div class="value">{{ $catch->fishing_location ?: 'N/A' }}</div>
            </div>
            <div class="col-6">
                <div class="label">Payao Used:</div>
                <div class="value">{{ $catch->payao_used ?: 'N/A' }}</div>
            </div>
        </div>
        <div class="col-12">
            <div class="label">Fishing Effort Notes:</div>
            <div class="value">{{ $catch->fishing_effort_notes ?: 'N/A' }}</div>
        </div>
    </div>

    <!-- Catch Information -->
    <div class="section">
        <div class="section-title">⚖️ CATCH INFORMATION</div>
        <div class="row">
            <div class="col-4">
                <div class="label">Catch Type:</div>
                <div class="value">{{ $catch->catch_type }}</div>
            </div>
            <div class="col-4">
                <div class="label">Total Catch (kg):</div>
                <div class="value">{{ number_format($catch->total_catch_kg, 2) }}</div>
            </div>
            <div class="col-4">
                <div class="label">Sub-sample Taken:</div>
                <div class="value">{{ $catch->subsample_taken ?: 'N/A' }}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="label">Sub-sample Weight (kg):</div>
                <div class="value">{{ $catch->subsample_weight ? number_format($catch->subsample_weight, 2) : 'N/A' }}</div>
            </div>
            <div class="col-6">
                <div class="label">Below Legal Size:</div>
                <div class="value">{{ $catch->below_legal_size ?: 'N/A' }}</div>
            </div>
        </div>
        <div class="col-12">
            <div class="label">Below Legal Species:</div>
            <div class="value">{{ $catch->below_legal_species ?: 'N/A' }}</div>
        </div>
    </div>

    <!-- AI Species Recognition & Size Estimation -->
    <div class="section">
        <div class="section-title">🤖 AI SPECIES RECOGNITION & SIZE ESTIMATION</div>
        <div class="row">
            <div class="col-3">
                <div class="label">Species:</div>
                <div class="value">{{ $catch->species }}</div>
            </div>
            <div class="col-3">
                <div class="label">Scientific Name:</div>
                <div class="value">{{ $catch->scientific_name ?: 'N/A' }}</div>
            </div>
            <div class="col-3">
                <div class="label">Length (cm):</div>
                <div class="value">{{ number_format($catch->length_cm, 1) }}</div>
            </div>
            <div class="col-3">
                <div class="label">Weight (g):</div>
                <div class="value">{{ number_format($catch->weight_g, 1) }}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="label">Species Recognition Confidence:</div>
                <div class="value">{{ $catch->confidence_score ?: 'N/A' }}</div>
            </div>
            <div class="col-6">
                <div class="label">Fish Detection Confidence:</div>
                <div class="value">{{ $catch->detection_confidence ?: 'N/A' }}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <div class="label">Bounding Box Width (px):</div>
                <div class="value">{{ $catch->bbox_width ?: 'N/A' }}</div>
            </div>
            <div class="col-4">
                <div class="label">Bounding Box Height (px):</div>
                <div class="value">{{ $catch->bbox_height ?: 'N/A' }}</div>
            </div>
            <div class="col-4">
                <div class="label">Pixels per cm:</div>
                <div class="value">{{ $catch->pixels_per_cm ? number_format($catch->pixels_per_cm, 4) : 'N/A' }}</div>
            </div>
        </div>
    </div>

    <!-- Fish Photo -->
    @if($catch->image_path)
    <div class="section">
        <div class="section-title">📸 FISH PHOTO</div>
        <div class="photo-section">
            <img src="{{ asset('storage/' . $catch->image_path) }}" alt="Fish Photo">
        </div>
    </div>
    @endif

    <!-- Report Metadata -->
    <div class="metadata">
        <table>
            <tr>
                <td><strong>Report ID:</strong></td>
                <td>#{{ $catch->id }}</td>
                <td><strong>Submitted by:</strong></td>
                <td>{{ $catch->user->name }}</td>
            </tr>
            <tr>
                <td><strong>Submitted on:</strong></td>
                <td>{{ $catch->created_at->format('F d, Y \a\t g:i A') }}</td>
                <td><strong>Last updated:</strong></td>
                <td>{{ $catch->updated_at->format('F d, Y \a\t g:i A') }}</td>
            </tr>
            <tr>
                <td><strong>Processing mode:</strong></td>
                <td colspan="3">
                    @if($catch->image_path)
                        AI Processing (with photo)
                    @else
                        Manual Entry
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>This is an official BFAR Fish Catch Monitoring Report generated on {{ now()->format('F d, Y \a\t g:i A') }}</p>
        <p>Bureau of Fisheries and Aquatic Resources - National Stock Assessment Program</p>
    </div>
</body>
</html> 