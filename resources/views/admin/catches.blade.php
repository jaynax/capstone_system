@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">All Fish Catches</h4>
                    <p class="card-subtitle">Manage and view all recorded fish catches</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Species</th>
                                    <th>Length (cm)</th>
                                    <th>Weight (g)</th>
                                    <th>Location</th>
                                    <th>Date & Time</th>
                                    <th>Gear Type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($catches as $catch)
                                <tr>
                                    <td>{{ $catch->id }}</td>
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
                                    <td>{{ $catch->catch_datetime->format('M d, Y H:i') }}</td>
                                    <td>{{ $catch->gear_type }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="viewCatch({{ $catch->id }})">
                                                <i class="bx bx-show"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteCatch({{ $catch->id }})">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="bx bx-fish bx-lg mb-2"></i>
                                            <p>No fish catches recorded yet.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($catches->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $catches->links() }}
                    </div>
                    @endif
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

function deleteCatch(id) {
    if (confirm('Are you sure you want to delete this catch?')) {
        // Implement delete functionality
        alert('Delete catch with ID: ' + id);
    }
}
</script>
@endsection 