<!-- Navbar -->
<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <!-- Navbar Items -->
    <ul class="navbar-nav flex-row align-items-center ms-auto">
        <!-- Dark/Light Mode Toggle -->
        <li class="nav-item">
            <a href="javascript:void(0);" id="theme-toggle" class="nav-link">
                <i id="theme-icon" class="bx bx-moon fs-4"></i>
            </a>
        </li>

        <!-- User Dropdown -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img id="navbar-profile-image"
                     src="{{ Auth::user()->profile_image ? asset('storage/profile_images/' . Auth::user()->profile_image) : asset('assets/img/default-profile.png') }}" 
                     class="rounded-circle border border-2 shadow-sm" width="40" height="40" alt="User Profile">
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li>
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar avatar-online">
                                    <img id="dropdown-profile-image"
                                         src="{{ Auth::user()->profile_image ? asset('storage/profile_images/' . Auth::user()->profile_image) : asset('assets/img/default-profile.png') }}" 
                                         class="rounded-circle border border-2 shadow-sm" width="40" height="40" alt="User Profile">
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <span class="fw-semibold d-block">{{ Auth::user()->name }}</span>
                            </div>
                        </div>
                    </a>
                </li>
                <li><div class="dropdown-divider"></div></li>
                <li>
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">My Profile</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="#">
                        <i class="bx bx-cog me-2"></i>
                        <span class="align-middle">Settings</span>
                    </a>
                </li>
                <li><div class="dropdown-divider"></div></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="dropdown-item">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 text-dark">
                            <i class="bx bx-power-off me-2"></i>
                            <span class="align-middle">Log Out</span>
                        </button>
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>

<script>
document.getElementById('profile_image').addEventListener('change', function(event) {
    const reader = new FileReader();
    reader.onload = function() {
        document.getElementById('navbar-profile-image').src = reader.result;
        document.getElementById('dropdown-profile-image').src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
});
</script>
