@extends('layouts.users.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title">
                                <i class="bx bx-file me-2"></i>Fish Catch Report #{{ $catch->id }}
                            </h4>
                            <p class="card-subtitle">BFAR Fish Catch Monitoring Form - {{ \Carbon\Carbon::parse($catch->date_sampling)->format('F d, Y') }}</p>
                        </div>
                        <div class="btn-group">
                            <a href="{{ route('catches.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-arrow-back me-1"></i>Back to List
                            </a>
                            <a href="{{ route('catches.pdf', $catch) }}" class="btn btn-success">
                                <i class="bx bx-download me-1"></i>Download PDF
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- General Information -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 mb-3">
                                <i class="bx bx-info-circle me-2"></i>General Information
                            </h5>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Region:</label>
                            <p class="form-control-plaintext">{{ $catch->region }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Landing Center:</label>
                            <p class="form-control-plaintext">{{ $catch->landing_center }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Date of Sampling:</label>
                            <p class="form-control-plaintext">{{ \Carbon\Carbon::parse($catch->date_sampling)->format('F d, Y') }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Time of Landing:</label>
                            <p class="form-control-plaintext">{{ $catch->time_landing }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Enumerator(s):</label>
                            <p class="form-control-plaintext">{{ $catch->enumerators }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Fishing Ground:</label>
                            <p class="form-control-plaintext">{{ $catch->fishing_ground }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Weather Conditions:</label>
                            <p class="form-control-plaintext">{{ $catch->weather_conditions }}</p>
                        </div>
                    </div>

                    <!-- Boat Information -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 mb-3">
                                <i class="bx bx-ship me-2"></i>Boat Information
                            </h5>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Boat Name (F/B):</label>
                            <p class="form-control-plaintext">{{ $catch->boat_name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Boat Type:</label>
                            <p class="form-control-plaintext">{{ $catch->boat_type }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Length (m):</label>
                            <p class="form-control-plaintext">{{ number_format($catch->boat_length, 2) }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Width (m):</label>
                            <p class="form-control-plaintext">{{ number_format($catch->boat_width, 2) }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Depth (m):</label>
                            <p class="form-control-plaintext">{{ number_format($catch->boat_depth, 2) }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Gross Tonnage (GT):</label>
                            <p class="form-control-plaintext">{{ $catch->gross_tonnage ? number_format($catch->gross_tonnage, 2) : 'N/A' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Horsepower (HP):</label>
                            <p class="form-control-plaintext">{{ $catch->horsepower ?: 'N/A' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Engine Type:</label>
                            <p class="form-control-plaintext">{{ $catch->engine_type ?: 'N/A' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Number of Fishermen:</label>
                            <p class="form-control-plaintext">{{ $catch->fishermen_count }}</p>
                        </div>
                    </div>

                    <!-- Fishing Operation Details -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 mb-3">
                                <i class="bx bx-anchor me-2"></i>Fishing Operation Details
                            </h5>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Fishing Gear Type:</label>
                            <p class="form-control-plaintext">{{ $catch->fishing_gear_type }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Days Fished:</label>
                            <p class="form-control-plaintext">{{ $catch->days_fished }}</p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Gear Specifications:</label>
                            <p class="form-control-plaintext">{{ $catch->gear_specifications ?: 'N/A' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Hooks/Hauls:</label>
                            <p class="form-control-plaintext">{{ $catch->hooks_hauls ?: 'N/A' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Net/Line Length (m):</label>
                            <p class="form-control-plaintext">{{ $catch->net_line_length ? number_format($catch->net_line_length, 2) : 'N/A' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Soaking Time (hrs):</label>
                            <p class="form-control-plaintext">{{ $catch->soaking_time ? number_format($catch->soaking_time, 2) : 'N/A' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Mesh Size (cm):</label>
                            <p class="form-control-plaintext">{{ $catch->mesh_size ? number_format($catch->mesh_size, 2) : 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Fishing Location:</label>
                            <p class="form-control-plaintext">{{ $catch->fishing_location ?: 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Payao Used:</label>
                            <p class="form-control-plaintext">{{ $catch->payao_used ?: 'N/A' }}</p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Fishing Effort Notes:</label>
                            <p class="form-control-plaintext">{{ $catch->fishing_effort_notes ?: 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- Catch Information -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 mb-3">
                                <i class="bx bx-weight me-2"></i>Catch Information
                            </h5>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Catch Type:</label>
                            <p class="form-control-plaintext">{{ $catch->catch_type }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Total Catch (kg):</label>
                            <p class="form-control-plaintext">{{ number_format($catch->total_catch_kg, 2) }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Sub-sample Taken:</label>
                            <p class="form-control-plaintext">{{ $catch->subsample_taken ?: 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Sub-sample Weight (kg):</label>
                            <p class="form-control-plaintext">{{ $catch->subsample_weight ? number_format($catch->subsample_weight, 2) : 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Below Legal Size:</label>
                            <p class="form-control-plaintext">{{ $catch->below_legal_size ?: 'N/A' }}</p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Below Legal Species:</label>
                            <p class="form-control-plaintext">{{ $catch->below_legal_species ?: 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- AI Species Recognition & Size Estimation -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 mb-3">
                                <i class="bx bx-brain me-2"></i>AI Species Recognition & Size Estimation
                            </h5>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Species:</label>
                            <p class="form-control-plaintext">{{ $catch->species }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Scientific Name:</label>
                            <p class="form-control-plaintext">{{ $catch->scientific_name ?: 'N/A' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Length (cm):</label>
                            <p class="form-control-plaintext">{{ number_format($catch->length_cm, 1) }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Weight (g):</label>
                            <p class="form-control-plaintext">{{ number_format($catch->weight_g, 1) }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Species Recognition Confidence:</label>
                            <p class="form-control-plaintext">{{ $catch->confidence_score ?: 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Fish Detection Confidence:</label>
                            <p class="form-control-plaintext">{{ $catch->detection_confidence ?: 'N/A' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Bounding Box Width (px):</label>
                            <p class="form-control-plaintext">{{ $catch->bbox_width ?: 'N/A' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Bounding Box Height (px):</label>
                            <p class="form-control-plaintext">{{ $catch->bbox_height ?: 'N/A' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Pixels per cm:</label>
                            <p class="form-control-plaintext">{{ $catch->pixels_per_cm ? number_format($catch->pixels_per_cm, 4) : 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- Fish Photo -->
                    @if($catch->image_path)
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 mb-3">
                                <i class="bx bx-image me-2"></i>Fish Photo
                            </h5>
                            <div class="text-center">
                                <img src="{{ asset('storage/' . $catch->image_path) }}" 
                                     alt="Fish Photo" 
                                     class="img-fluid rounded" 
                                     style="max-height: 400px;">
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Report Metadata -->
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Report ID:</strong> #{{ $catch->id }}<br>
                                        <strong>Submitted by:</strong> {{ $catch->user->name }}<br>
                                        <strong>Submitted on:</strong> {{ $catch->created_at->format('F d, Y \a\t g:i A') }}
                                    </div>
                                    <div class="col-md-6 text-md-end">
                                        <strong>Last updated:</strong> {{ $catch->updated_at->format('F d, Y \a\t g:i A') }}<br>
                                        <strong>Processing mode:</strong> 
                                        @if($catch->image_path)
                                            <span class="badge bg-success">AI Processing</span>
                                        @else
                                            <span class="badge bg-warning">Manual Entry</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-control-plaintext {
    padding: 0.375rem 0;
    margin-bottom: 0;
    color: #212529;
    background-color: transparent;
    border: solid transparent;
    border-width: 1px 0;
}

.border-bottom {
    border-bottom: 2px solid #dee2e6 !important;
}

.alert-info {
    background-color: #d1ecf1;
    border-color: #bee5eb;
    color: #0c5460;
}
</style>
@endsection 