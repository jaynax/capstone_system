<!-- Navbar -->
<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <!-- Navbar Items -->
    <ul class="navbar-nav flex-row align-items-center ms-auto">
        <!-- Theme Mode Buttons -->
        <li class="nav-item dropdown me-2">
            <a class="nav-link dropdown-toggle" href="#" id="themeDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bx bx-palette fs-4"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="themeDropdown">
                <li>
                    <a class="dropdown-item theme-btn" href="javascript:void(0)" data-theme="light">
                        <i class="bx bx-sun me-2"></i>
                        <span>Light Mode</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item theme-btn" href="javascript:void(0)" data-theme="dark">
                        <i class="bx bx-moon me-2"></i>
                        <span>Dark Mode</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- User Dropdown -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img id="navbar-profile-image"
                     src="{{ Auth::user()->profile_image ? asset('storage/profile_images/' . Auth::user()->profile_image) : asset('assets/img/avatars/1.png') }}" 
                     class="rounded-circle border border-2 shadow-sm" width="40" height="40" alt="User Profile" style="object-fit: cover;">
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li>
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar avatar-online">
                                    <img id="dropdown-profile-image"
                                         src="{{ Auth::user()->profile_image ? asset('storage/profile_images/' . Auth::user()->profile_image) : asset('assets/img/avatars/1.png') }}" 
                                         class="rounded-circle border border-2 shadow-sm" width="40" height="40" alt="User Profile" style="object-fit: cover;">
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

<style>
/* Theme button styling */
.theme-btn {
    transition: all 0.3s ease;
}

.theme-btn:hover {
    background-color: var(--bs-primary);
    color: white;
}

.theme-btn.active {
    background-color: var(--bs-primary);
    color: white;
}

.theme-btn i {
    transition: transform 0.3s ease;
}

.theme-btn:hover i {
    transform: scale(1.2);
}

/* Custom dark mode styles */
[data-bs-theme="dark"] {
    --bs-body-bg: #212529;
    --bs-body-color: #f8f9fa;
    --bs-navbar-bg: #343a40;
    --bs-navbar-color: #f8f9fa;
    --bs-card-bg: #343a40;
    --bs-border-color: #495057;
}

[data-bs-theme="dark"] .layout-navbar {
    background-color: #343a40 !important;
    color: #f8f9fa !important;
}

[data-bs-theme="dark"] .layout-menu {
    background-color: #212529 !important;
    color: #f8f9fa !important;
}

[data-bs-theme="dark"] .card {
    background-color: #343a40 !important;
    color: #f8f9fa !important;
    border-color: #495057 !important;
}

[data-bs-theme="dark"] .dropdown-menu {
    background-color: #343a40 !important;
    border-color: #495057 !important;
}

[data-bs-theme="dark"] .dropdown-item {
    color: #f8f9fa !important;
}

[data-bs-theme="dark"] .dropdown-item:hover {
    background-color: #495057 !important;
}
</style>

<script>
// Profile image update
document.getElementById('profile_image').addEventListener('change', function(event) {
    const reader = new FileReader();
    reader.onload = function() {
        document.getElementById('navbar-profile-image').src = reader.result;
        document.getElementById('dropdown-profile-image').src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
});

// Enhanced Theme functionality with separate buttons
document.addEventListener('DOMContentLoaded', function() {
    const html = document.documentElement;
    const body = document.body;
    const themeButtons = document.querySelectorAll('.theme-btn');
    
    // Initialize theme
    function initializeTheme() {
        const savedTheme = localStorage.getItem('theme') || 'light';
        applyTheme(savedTheme);
        updateActiveButton(savedTheme);
        console.log('Theme initialized:', savedTheme);
    }
    
    // Apply theme to all elements
    function applyTheme(theme) {
        console.log('Applying theme:', theme);
        
        // Apply to html and body
        html.setAttribute('data-bs-theme', theme);
        body.setAttribute('data-bs-theme', theme);
        
        // Apply to specific elements
        const navbar = document.getElementById('layout-navbar');
        const sidebar = document.getElementById('layout-menu');
        
        if (navbar) {
            navbar.setAttribute('data-bs-theme', theme);
        }
        
        if (sidebar) {
            sidebar.setAttribute('data-bs-theme', theme);
        }
        
        // Force CSS update
        document.documentElement.style.setProperty('--bs-theme', theme);
        
        // Save to localStorage
        localStorage.setItem('theme', theme);
        
        console.log('Theme applied successfully:', theme);
        console.log('HTML data-bs-theme:', html.getAttribute('data-bs-theme'));
        console.log('Body data-bs-theme:', body.getAttribute('data-bs-theme'));
    }
    
    // Update active button styling
    function updateActiveButton(theme) {
        themeButtons.forEach(btn => {
            btn.classList.remove('active');
            if (btn.getAttribute('data-theme') === theme) {
                btn.classList.add('active');
            }
        });
    }
    
    // Theme button click handlers
    themeButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const theme = this.getAttribute('data-theme');
            
            console.log('Theme button clicked:', theme);
            
            applyTheme(theme);
            updateActiveButton(theme);
            
            // Add animation effect
            this.style.transform = 'scale(1.1)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 200);
        });
    });
    
    // Initialize theme on page load
    initializeTheme();
    
    // Listen for theme changes from other parts of the app
    window.addEventListener('storage', function(e) {
        if (e.key === 'theme') {
            const newTheme = e.newValue || 'light';
            applyTheme(newTheme);
            updateActiveButton(newTheme);
        }
    });
});
</script>
