@extends('layouts.users.app')

@section('content')
<div class="container-fluid">
    <!-- Welcome Carousel -->
    <div class="row mb-4">
        <div class="col-12">
            <div id="personnelCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#personnelCarousel" data-bs-slide-to="0" class="active"></button>
                    <button type="button" data-bs-target="#personnelCarousel" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#personnelCarousel" data-bs-slide-to="2"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="card bg-gradient-warning text-white">
                            <div class="card-body p-5">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h2 class="display-4 fw-bold">BFAR Inspection Team</h2>
                                        <p class="lead">Monitor fish landings, inspect catches, and collect vital data from fishermen for sustainable fisheries management.</p>
                                        <div class="mt-4">
                                            <a href="{{ route('catch.create') }}" class="btn btn-light btn-lg me-3">
                                                <i class="bx bx-clipboard me-2"></i>Record Inspection
                                            </a>
                                            <a href="#" class="btn btn-outline-light btn-lg">
                                                <i class="bx bx-search me-2"></i>View Reports
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <i class="bx bx-search-alt bx-lg" style="font-size: 8rem; opacity: 0.3;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="card bg-gradient-danger text-white">
                            <div class="card-body p-5">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h2 class="display-4 fw-bold">Data Collection Excellence</h2>
                                        <p class="lead">Document fish species, sizes, weights, and catch locations to support fisheries research and conservation efforts.</p>
                                        <div class="mt-4">
                                            <a href="{{ route('catch.create') }}" class="btn btn-light btn-lg me-3">
                                                <i class="bx bx-camera me-2"></i>Document Catch
                                            </a>
                                            <a href="#" class="btn btn-outline-light btn-lg">
                                                <i class="bx bx-map me-2"></i>Location Data
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <i class="bx bx-data bx-lg" style="font-size: 8rem; opacity: 0.3;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="card bg-gradient-secondary text-white">
                            <div class="card-body p-5">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h2 class="display-4 fw-bold">Fisheries Compliance</h2>
                                        <p class="lead">Ensure compliance with fishing regulations, monitor catch limits, and protect marine resources for future generations.</p>
                                        <div class="mt-4">
                                            <a href="#" class="btn btn-light btn-lg me-3">
                                                <i class="bx bx-shield-check me-2"></i>Compliance Check
                                            </a>
                                            <a href="#" class="btn btn-outline-light btn-lg">
                                                <i class="bx bx-book-open me-2"></i>Regulations
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <i class="bx bx-shield bx-lg" style="font-size: 8rem; opacity: 0.3;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#personnelCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#personnelCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="card-title mb-0">{{ \App\Models\FishCatch::where('user_id', Auth::id())->count() }}</h3>
                            <p class="card-text">Inspections Today</p>
                        </div>
                        <div class="text-end">
                            <i class="bx bx-clipboard bx-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-danger text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="card-title mb-0">{{ \App\Models\FishCatch::where('user_id', Auth::id())->whereDate('created_at', today())->count() }}</h3>
                            <p class="card-text">Today's Inspections</p>
                        </div>
                        <div class="text-end">
                            <i class="bx bx-calendar-check bx-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-secondary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="card-title mb-0">{{ \App\Models\FishCatch::where('user_id', Auth::id())->distinct('species')->count() }}</h3>
                            <p class="card-text">Species Documented</p>
                        </div>
                        <div class="text-end">
                            <i class="bx bx-category bx-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-dark text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="card-title mb-0">{{ \App\Models\FishCatch::where('user_id', Auth::id())->sum('weight_g') }}</h3>
                            <p class="card-text">Total Weight (g)</p>
                        </div>
                        <div class="text-end">
                            <i class="bx bx-weight bx-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Feature Cards -->
    <div class="row mb-4">
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="bx bx-clipboard bx-lg text-warning"></i>
                    </div>
                    <h5 class="card-title">Record Inspection</h5>
                    <p class="card-text">Document fish catches from fishermen with species identification and measurements.</p>
                    <a href="{{ route('catch.create') }}" class="btn btn-warning">
                        <i class="bx bx-right-arrow-alt me-1"></i>Start Inspection
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="bx bx-search bx-lg text-danger"></i>
                    </div>
                    <h5 class="card-title">Compliance Check</h5>
                    <p class="card-text">Verify fishing permits, catch limits, and ensure regulatory compliance.</p>
                    <a href="#" class="btn btn-danger">
                        <i class="bx bx-right-arrow-alt me-1"></i>Check Compliance
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="bx bx-chart bx-lg text-secondary"></i>
                    </div>
                    <h5 class="card-title">Inspection Reports</h5>
                    <p class="card-text">Generate reports on inspections, violations, and compliance statistics.</p>
                    <a href="#" class="btn btn-secondary">
                        <i class="bx bx-right-arrow-alt me-1"></i>View Reports
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Inspections -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">
                        <i class="bx bx-time me-2"></i>Recent Inspections
                    </h5>
                </div>
                <div class="card-body">
                    @if(\App\Models\FishCatch::where('user_id', Auth::id())->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Species</th>
                                        <th>Scientific Name</th>
                                        <th>Length</th>
                                        <th>Weight</th>
                                        <th>Inspection Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(\App\Models\FishCatch::where('user_id', Auth::id())->latest()->take(5)->get() as $catch)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold">{{ $catch->species }}</div>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $catch->scientific_name ?? 'N/A' }}</span>
                                        </td>
                                        <td>{{ $catch->length_cm }} cm</td>
                                        <td>{{ $catch->weight_g }} g</td>
                                        <td>{{ $catch->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-warning">
                                                <i class="bx bx-show"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bx bx-clipboard bx-lg text-muted mb-3"></i>
                            <p class="text-muted">No inspections recorded yet.</p>
                            <p class="text-muted">Start by recording your first fish inspection!</p>
                            <a href="{{ route('catch.create') }}" class="btn btn-warning">
                                <i class="bx bx-plus-circle me-2"></i>Record First Inspection
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-warning {
    background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 50%, #fecfef 100%);
}

.bg-gradient-danger {
    background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
}

.bg-gradient-secondary {
    background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
}

.carousel-item .card {
    border: none;
    border-radius: 15px;
    overflow: hidden;
}

.carousel-control-prev,
.carousel-control-next {
    width: 5%;
}

.carousel-indicators {
    bottom: 20px;
}

.carousel-indicators button {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    margin: 0 5px;
}

.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

.btn {
    border-radius: 25px;
    padding: 10px 25px;
    font-weight: 500;
}

.table-hover tbody tr:hover {
    background-color: rgba(0,0,0,0.02);
}
</style>

<script>
// Auto-advance carousel
document.addEventListener('DOMContentLoaded', function() {
    const carousel = new bootstrap.Carousel(document.getElementById('personnelCarousel'), {
        interval: 5000,
        wrap: true
    });
});
</script>
@endsection 