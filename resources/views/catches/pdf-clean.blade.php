<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NATIONAL STOCK ASSESSMENT PROGRAM - {{ $catch->date_landed ?? now()->format('Y-m-d') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.2;
            margin: 0;
            padding: 10px;
        }
        .container {
            max-width: 100%;
            padding: 0;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .text-left {
            text-align: left;
        }
        .font-weight-bold {
            font-weight: bold;
        }
        .mt-1 { margin-top: 0.25rem; }
        .mt-2 { margin-top: 0.5rem; }
        .mt-3 { margin-top: 1rem; }
        .mb-1 { margin-bottom: 0.25rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mb-3 { margin-bottom: 1rem; }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
            font-size: 11px;
        }
        .table, .table th, .table td {
            border: 1px solid #000;
        }
        .table th, .table td {
            padding: 2px 5px;
            vertical-align: top;
        }
        .table th {
            text-align: center;
            background-color: #f0f0f0;
        }
        .border-top {
            border-top: 1px solid #000;
        }
        .border-bottom {
            border-bottom: 1px solid #000;
        }
        .border {
            border: 1px solid #000;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -5px;
            margin-left: -5px;
        }
        .col-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
            padding: 0 5px;
        }
        .col-6 {
            flex: 0 0 50%;
            max-width: 50%;
            padding: 0 5px;
        }
        .col-12 {
            flex: 0 0 100%;
            max-width: 100%;
            padding: 0 5px;
        }
        @page {
            size: A4;
            margin: 1cm;
        }
        @media print {
            body {
                font-size: 10px;
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
            .page-break {
                page-break-before: always;
                margin-top: 1rem;
                padding-top: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="text-center mb-2">
            <h4 class="mb-0">NATIONAL STOCK ASSESSMENT PROGRAM</h4>
            <h5 class="mb-0">REGION VIII</h5>
            <h4 class="mb-1 font-weight-bold">FISH LANDING SURVEY FORM</h4>
            
            <div class="row">
                <div class="col-6 text-left">
                    <strong>Sampling Date:</strong> {{ $catch->date_landed ?? now()->format('F d, Y') }}
                </div>
                <div class="col-6 text-right">
                    <strong>Landing Center:</strong> {{ $catch->landing_site ?? '_________________' }}
                </div>
            </div>
            
            <div class="text-left">
                <strong>Fishing Ground:</strong> {{ $catch->fishing_ground ?? '_________________' }}
            </div>
        </div>
        
        <!-- Fishing Effort Section -->
        <table class="table mb-2">
            <tr>
                <th colspan="6" class="text-center">FISHING EFFORT</th>
            </tr>
            <tr>
                <td><strong>BOAT NAME:</strong> {{ $catch->boat_name ?? '_________________' }}</td>
                <td><strong>FISHING GEAR:</strong> {{ $catch->fishing_gear ?? '_________________' }}</td>
                <td colspan="4"><strong>VESSEL OPERATION PER DAY</strong></td>
            </tr>
            <tr>
                <td><strong>HOOKS:</strong> {{ $catch->hooks ?? '________' }}</td>
                <td><strong>DAYS:</strong> {{ $catch->fishing_days ?? '________' }}</td>
                <td><strong>HAULS:</strong> {{ $catch->hauls ?? '________' }}</td>
                <td><strong>Person:</strong> {{ $catch->crew_count ?? '________' }}</td>
                <td colspan="2"><strong>GEAR CODE:</strong> {{ $catch->gear_code ?? '________' }}</td>
            </tr>
        </table>
        
        <!-- Catch Composition Section -->
        <table class="table mb-2">
            <tr>
                <th colspan="6" class="text-center">CATCH COMPOSITION</th>
            </tr>
            <tr>
                <th rowspan="2">SPECIES</th>
                <th colspan="2" class="text-center">TOTAL BOAT CATCH</th>
                <th colspan="3" class="text-center">TOTAL SAMPLE</th>
            </tr>
            <tr>
                <th class="text-center">No. of Boxes</th>
                <th class="text-center">Weight in Kg.</th>
                <th class="text-center">No. of Samples</th>
                <th class="text-center">Weight in Kg.</th>
                <th class="text-center">No. of Boxes</th>
            </tr>
            
            @php
                $speciesData = [];
                if (!empty($catch->species)) {
                    $speciesData[] = [
                        'species' => $catch->species,
                        'total_boxes' => $catch->total_boxes ?? 1,
                        'total_weight' => $catch->weight_g / 1000, // Convert to kg
                        'sample_count' => $catch->sample_count ?? 1,
                        'sample_weight' => $catch->sample_weight ?? ($catch->weight_g / 1000),
                        'sample_boxes' => $catch->sample_boxes ?? 1
                    ];
                }
                
                // Calculate totals
                $totalBoxes = array_sum(array_column($speciesData, 'total_boxes'));
                $totalWeight = array_sum(array_column($speciesData, 'total_weight'));
                $totalSamples = array_sum(array_column($speciesData, 'sample_count'));
                $totalSampleWeight = array_sum(array_column($speciesData, 'sample_weight'));
                $totalSampleBoxes = array_sum(array_column($speciesData, 'sample_boxes'));
            @endphp
            
            @if(count($speciesData) > 0)
                @foreach($speciesData as $species)
                    <tr>
                        <td>{{ $species['species'] }}</td>
                        <td class="text-right">{{ number_format($species['total_boxes'], 0) }}</td>
                        <td class="text-right">{{ number_format($species['total_weight'], 2) }}</td>
                        <td class="text-right">{{ number_format($species['sample_count'], 0) }}</td>
                        <td class="text-right">{{ number_format($species['sample_weight'], 2) }}</td>
                        <td class="text-right">{{ number_format($species['sample_boxes'], 0) }}</td>
                    </tr>
                @endforeach
                <tr class="font-weight-bold">
                    <td class="text-right">TOTAL</td>
                    <td class="text-right">{{ number_format($totalBoxes, 0) }}</td>
                    <td class="text-right">{{ number_format($totalWeight, 2) }}</td>
                    <td class="text-right">{{ number_format($totalSamples, 0) }}</td>
                    <td class="text-right">{{ number_format($totalSampleWeight, 2) }}</td>
                    <td class="text-right">{{ number_format($totalSampleBoxes, 0) }}</td>
                </tr>
            @else
                <tr>
                    <td colspan="6" class="text-center">No catch data available</td>
                </tr>
            @endif
        </table>
        
        <!-- Fishing Gear Codes Section -->
        <div class="mb-2">
            <strong>Fishing Gear Code:</strong>
            <div class="row mt-1">
                <div class="col-4">
                    <div>1. DGN - Drift Gillnet</div>
                    <div>2. GN - Gillnet</div>
                    <div>3. LL - Longline</div>
                </div>
                <div class="col-4">
                    <div>4. BLL - Bottom Longline</div>
                    <div>5. HLL - Handline</div>
                    <div>6. J - Jigger</div>
                </div>
                <div class="col-4">
                    <div>7. RN - Ring Net</div>
                    <div>8. PS - Purse Seine</div>
                    <div>9. OTH - Others (specify)</div>
                </div>
            </div>
        </div>
        
        <!-- Remarks Section -->
        <div class="mb-2">
            <strong>REMARKS:</strong>
            <div class="border p-1" style="min-height: 60px;">
                {{ $catch->remarks ?? '______________________________________________________________________________________________________________________' }}
            </div>
        </div>
        
        <!-- Signatures Section -->
        <div class="row mt-3">
            <div class="col-4 text-center">
                <div class="border-top pt-1">
                    <strong>ENUMERATOR A</strong><br>
                    {{ $catch->enumerator_a_name ?? '__________________________' }}
                </div>
            </div>
            <div class="col-4 text-center">
                <div class="border-top pt-1">
                    <strong>ENUMERATOR B</strong><br>
                    {{ $catch->enumerator_b_name ?? '__________________________' }}
                </div>
            </div>
            <div class="col-4 text-center">
                <div class="border-top pt-1">
                    <strong>PROJECT LEADER</strong><br>
                    {{ $catch->project_leader_name ?? '__________________________' }}
                </div>
            </div>
        </div>
        
        <div class="text-center mt-3" style="font-size: 10px;">
            BFAR-FS Form No. 1<br>
            Series of 2023
        </div>
    </div>
    
    <script>
        // Auto-print when the page loads
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
