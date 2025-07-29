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
                                <i class="bx bx-list-ul me-2"></i>My Fish Catch Records
                            </h4>
                            <p class="card-subtitle">View and manage your submitted fish catch reports</p>
                        </div>
                        <a href="{{ route('catch.create') }}" class="btn btn-primary">
                            <i class="bx bx-plus me-1"></i>New Catch Report
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($catches->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Date</th>
                                        <th>Region</th>
                                        <th>Landing Center</th>
                                        <th>Species</th>
                                        <th>Length (cm)</th>
                                        <th>Weight (g)</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($catches as $catch)
                                    <tr>
                                        <td>
                                            <span class="badge bg-primary">#{{ $catch->id }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <strong>{{ \Carbon\Carbon::parse($catch->date_sampling)->format('M d, Y') }}</strong>
                                                <small class="text-muted">{{ $catch->time_landing }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $catch->region }}</span>
                                        </td>
                                        <td>{{ $catch->landing_center }}</td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <strong>{{ $catch->species }}</strong>
                                                @if($catch->scientific_name)
                                                    <small class="text-muted">{{ $catch->scientific_name }}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>{{ number_format($catch->length_cm, 1) }} cm</td>
                                        <td>{{ number_format($catch->weight_g, 1) }} g</td>
                                        <td>
                                            @if($catch->image_path)
                                                <span class="badge bg-success">
                                                    <i class="bx bx-image me-1"></i>With Photo
                                                </span>
                                            @else
                                                <span class="badge bg-warning">
                                                    <i class="bx bx-edit me-1"></i>Manual Entry
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('catches.show', $catch) }}" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   title="View Details">
                                                    <i class="bx bx-show"></i>
                                                </a>
                                                <a href="{{ route('catches.pdf', $catch) }}" 
                                                   class="btn btn-sm btn-outline-success" 
                                                   title="Download PDF">
                                                    <i class="bx bx-download"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $catches->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="bx bx-fish bx-lg text-muted"></i>
                            </div>
                            <h5 class="text-muted">No catch records found</h5>
                            <p class="text-muted">You haven't submitted any fish catch reports yet.</p>
                            <a href="{{ route('catch.create') }}" class="btn btn-primary">
                                <i class="bx bx-plus me-1"></i>Create Your First Report
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.table th {
    font-weight: 600;
    background-color: #f8f9fa;
}

.badge {
    font-size: 0.75rem;
}

.btn-group .btn {
    padding: 0.25rem 0.5rem;
}

.table-responsive {
    border-radius: 0.5rem;
    overflow: hidden;
}
</style>
@endsection 