@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $totalCatches }}</h4>
                            <p class="card-text">Total Catches</p>
                        </div>
                        <div class="align-self-center">
                            <i class="bx bx-fish bx-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $totalUsers }}</h4>
                            <p class="card-text">Total Users</p>
                        </div>
                        <div class="align-self-center">
                            <i class="bx bx-user bx-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $recentCatches->count() }}</h4>
                            <p class="card-text">Recent Catches</p>
                        </div>
                        <div class="align-self-center">
                            <i class="bx bx-time bx-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $totalUsers > 0 ? round(($totalCatches / $totalUsers), 1) : 0 }}</h4>
                            <p class="card-text">Avg Catches/User</p>
                        </div>
                        <div class="align-self-center">
                            <i class="bx bx-calculator bx-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Catches Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Recent Fish Catches</h4>
                    <p class="card-subtitle">Latest 10 fish catches recorded</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Species</th>
                                    <th>Length (cm)</th>
                                    <th>Weight (g)</th>
                                    <th>Location</th>
                                    <th>Date & Time</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentCatches as $catch)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $catch->user->profile_image ? asset('storage/profile_images/' . $catch->user->profile_image) : asset('assets/img/avatars/1.png') }}" 
                                                 class="rounded-circle me-2" width="32" height="32" style="object-fit: cover;">
                                            <div>
                                                <div class="fw-semibold">{{ $catch->user->name }}</div>
                                                <small class="text-muted">{{ $catch->user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $catch->species }}</span>
                                    </td>
                                    <td>{{ $catch->length_cm }}</td>
                                    <td>{{ $catch->weight_g }}</td>
                                    <td>
                                        @if($catch->latitude && $catch->longitude)
                                            <a href="https://maps.google.com/?q={{ $catch->latitude }},{{ $catch->longitude }}" target="_blank">
                                                <i class="bx bx-map-pin"></i> View Map
                                            </a>
                                        @else
                                            <span class="text-muted">No location</span>
                                        @endif
                                    </td>
                                    <td>{{ $catch->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="viewCatch({{ $catch->id }})">
                                            <i class="bx bx-show"></i> View
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="bx bx-fish bx-lg mb-2"></i>
                                            <p>No recent catches found.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Quick Actions</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.catches') }}" class="btn btn-primary w-100">
                                <i class="bx bx-list-ul me-2"></i>
                                View All Catches
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.users') }}" class="btn btn-info w-100">
                                <i class="bx bx-user me-2"></i>
                                Manage Users
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="#" class="btn btn-success w-100">
                                <i class="bx bx-download me-2"></i>
                                Export Data
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="#" class="btn btn-warning w-100">
                                <i class="bx bx-chart me-2"></i>
                                Generate Report
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function viewCatch(id) {
    // Implement view catch details modal
    alert('View catch details for ID: ' + id);
}
</script>
@endsection 