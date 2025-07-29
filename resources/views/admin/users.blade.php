@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Manage Users</h4>
                    <p class="card-subtitle">View and manage all registered users</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Profile</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Registered</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>
                                        <img src="{{ $user->profile_image ? asset('storage/profile_images/' . $user->profile_image) : asset('assets/img/avatars/1.png') }}" 
                                             class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $user->name }}</div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->role === 'BFAR_PERSONNEL')
                                            <span class="badge bg-info">BFAR Personnel</span>
                                        @elseif($user->role === 'REGIONAL_ADMIN')
                                            <span class="badge bg-warning">Regional Admin</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $user->role }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->address)
                                            <span title="{{ $user->address }}">{{ Str::limit($user->address, 30) }}</span>
                                        @else
                                            <span class="text-muted">Not provided</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->phone)
                                            {{ $user->phone }}
                                        @else
                                            <span class="text-muted">Not provided</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="viewUser({{ $user->id }})">
                                                <i class="bx bx-show"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-warning" onclick="editUser({{ $user->id }})">
                                                <i class="bx bx-edit"></i>
                                            </button>
                                            @if($user->id !== Auth::id())
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteUser({{ $user->id }})">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="bx bx-user bx-lg mb-2"></i>
                                            <p>No users found.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($users->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $users->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function viewUser(id) {
    // Implement view user details modal
    alert('View user details for ID: ' + id);
}

function editUser(id) {
    // Implement edit user functionality
    alert('Edit user with ID: ' + id);
}

function deleteUser(id) {
    if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
        // Implement delete functionality
        alert('Delete user with ID: ' + id);
    }
}
</script>
@endsection 