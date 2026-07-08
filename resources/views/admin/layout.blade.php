<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ auth()->user()->business_name }} | Geofence Attendance System</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">

    <!-- adminHMD Template CSS -->
    <link rel="stylesheet" href="{{ asset('admin_assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/css/style.css') }}">

    <!-- Existing Core Scripts & Tailwind (kept for inner views compatibility) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            important: true, /* Added important to prevent bootstrap from completely breaking tailwind inner views */
            theme: {
                extend: {
                    colors: {
                        navy: '#1a2639',
                        saffron: '#f6c449',
                        'saffron-hover': '#e5b235',
                    }
                }
            }
        }
    </script>
    <style>
        /* jQuery Validation Styles */
        .error {
            color: #ef4444; /* Tailwind red-500 */
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }
        input.error, select.error, textarea.error {
            border-color: #ef4444 !important;
        }
        /* Prevent SweetAlert2 from breaking full height layout */
        html.swal2-height-auto, body.swal2-height-auto {
            height: 100vh !important;
        }
        /* Tailwind preflight conflicting with Bootstrap fix */
        .admin-main, .admin-sidebar, .navbar {
            box-sizing: border-box;
        }
        a {
            text-decoration: none;
        }
        .page-heading {
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
    </style>
    @stack('styles')
</head>

<body>
  <div class="admin-shell">
    <div class="sidebar-backdrop" data-sidebar-close></div>

    <aside class="admin-sidebar" id="adminSidebar" aria-label="Main navigation">
      <div class="sidebar-header">
        <a class="brand-mark" href="{{ route('admin.dashboard') }}" aria-label="Dashboard">
          <span class="brand-icon">
            <svg class="w-6 h-6 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
          </span>
          <span class="brand-copy">
            <span class="brand-title" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 140px;">{{ auth()->user()->business_name }}</span>
            <span class="brand-subtitle">Attendance System</span>
          </span>
        </a>
      </div>

      <nav class="sidebar-nav">
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
          <span class="nav-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
          <span class="nav-text">Dashboard</span>
        </a>
        <a class="nav-link {{ request()->routeIs('admin.geofences.*') ? 'active' : '' }}" href="{{ route('admin.geofences.index') }}">
          <span class="nav-icon"><i class="bi bi-geo-alt" aria-hidden="true"></i></span>
          <span class="nav-text">Sites (Geofences)</span>
        </a>
        <a class="nav-link {{ request()->routeIs('admin.departments.*') ? 'active' : '' }}" href="{{ route('admin.departments.index') }}">
          <span class="nav-icon"><i class="bi bi-diagram-3" aria-hidden="true"></i></span>
          <span class="nav-text">Departments</span>
        </a>
        <a class="nav-link {{ request()->routeIs('admin.designations.*') ? 'active' : '' }}" href="{{ route('admin.designations.index') }}">
          <span class="nav-icon"><i class="bi bi-briefcase" aria-hidden="true"></i></span>
          <span class="nav-text">Designations</span>
        </a>
        <a class="nav-link {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}" href="{{ route('admin.employees.index') }}">
          <span class="nav-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
          <span class="nav-text">Employees</span>
        </a>
        <a class="nav-link {{ request()->routeIs('admin.attendances.options') || request()->routeIs('admin.attendances') || request()->routeIs('admin.attendances.today') || request()->routeIs('admin.attendances.delete') ? 'active' : '' }}" href="{{ route('admin.attendances.options') }}">
          <span class="nav-icon"><i class="bi bi-calendar-check" aria-hidden="true"></i></span>
          <span class="nav-text">Attendances</span>
        </a>
        <a class="nav-link {{ request()->routeIs('admin.attendances.today-absent') ? 'active' : '' }}" href="{{ route('admin.attendances.today-absent') }}">
          <span class="nav-icon"><i class="bi bi-calendar-x" aria-hidden="true"></i></span>
          <span class="nav-text">Today Absents</span>
        </a>
        <a class="nav-link {{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}" href="{{ route('admin.transactions.index') }}">
          <span class="nav-icon"><i class="bi bi-currency-dollar" aria-hidden="true"></i></span>
          <span class="nav-text">Transactions</span>
        </a>
        <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
          <span class="nav-icon"><i class="bi bi-gear" aria-hidden="true"></i></span>
          <span class="nav-text">Settings</span>
        </a>
      </nav>

      <div class="sidebar-user">
        <div class="avatar-img avatar-md sidebar-user-avatar bg-primary text-white d-flex align-items-center justify-content-center fw-bold rounded-circle">
            {{ auth()->user()->initials() ?? 'US' }}
        </div>
        <strong>{{ auth()->user()->name ?? 'Admin' }}</strong>
        <small style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 160px; display: inline-block;">{{ auth()->user()->email ?? 'admin@example.com' }}</small>
      </div>

      <div class="sidebar-footer">
        <span class="status-dot"></span>
        <span class="sidebar-footer-text">System running smoothly</span>
      </div>
    </aside>

    <div class="admin-main">
      <nav class="navbar admin-navbar navbar-expand bg-white">
        <div class="container-fluid px-3 px-lg-4">
          <button class="sidebar-toggle" type="button" data-sidebar-toggle aria-controls="adminSidebar" aria-expanded="true" aria-label="Toggle sidebar">
            <span></span>
            <span></span>
            <span></span>
          </button>

          <h2 class="h5 mb-0 ms-3 fw-bold d-none d-md-block text-gray-800">
              @yield('header_title', 'Organization Portal')
          </h2>

          <div class="navbar-actions ms-auto">
            <button class="icon-button theme-toggle" type="button" data-theme-toggle aria-label="Switch color theme" title="Switch color theme">
              <i class="bi bi-moon-stars" data-theme-icon aria-hidden="true"></i>
            </button>

            <div class="dropdown">
              <button class="profile-button dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="avatar-img avatar-sm bg-primary text-white d-flex align-items-center justify-content-center fw-bold rounded-circle">
                    {{ auth()->user()->initials() ?? 'US' }}
                </div>
                <span class="profile-name d-none d-sm-inline">{{ auth()->user()->name ?? 'Admin' }}</span>
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('admin.settings.index') }}">Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">Sign out</button>
                    </form>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </nav>

      <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">
          @yield('content')
        </div>
      </main>

      <footer class="admin-footer mt-auto">
        <div class="container-fluid px-3 px-lg-4">
          <span>Copyright {{ date('Y') }} {{ auth()->user()->business_name }}.</span>
          <span>Geofence Attendance System</span>
        </div>
      </footer>
    </div>
  </div>

  <!-- adminHMD Template JS -->
  <script src="{{ asset('admin_assets/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('admin_assets/js/main.js') }}"></script>

  <!-- Existing Core JS Plugins -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

  <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if(Session::has('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ Session::get('success') }}'
            });
        @endif

        @if(Session::has('error'))
            Toast.fire({
                icon: 'error',
                title: '{{ Session::get('error') }}'
            });
        @endif
        
        $(document).ready(function() {
            // Apply validation to any form with .validate-form
            $('.validate-form').each(function() {
                $(this).validate({
                    errorElement: 'span',
                    errorPlacement: function (error, element) {
                        error.addClass('error');
                        if (element.hasClass('select2-hidden-accessible')) {
                            error.insertAfter(element.next('.select2-container'));
                        } else if (element.parent('.relative').length) {
                            error.insertAfter(element.parent('.relative'));
                        } else {
                            error.insertAfter(element);
                        }
                    },
                    highlight: function (element, errorClass, validClass) {
                        $(element).addClass(errorClass);
                        if ($(element).hasClass('select2-hidden-accessible')) {
                            $(element).next('.select2-container').find('.select2-selection').css('border-color', '#ef4444');
                        }
                    },
                    unhighlight: function (element, errorClass, validClass) {
                        $(element).removeClass(errorClass);
                        if ($(element).hasClass('select2-hidden-accessible')) {
                            $(element).next('.select2-container').find('.select2-selection').css('border-color', '');
                        }
                    },
                    invalidHandler: function(event, validator) {
                        var errors = validator.numberOfInvalids();
                        if (errors) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Error',
                                text: 'Please fill in all required fields correctly before submitting.',
                                confirmButtonColor: '#1a2639'
                            });
                        }
                    }
                });
            });
            
            // Ensure select2 triggers validation
            $('.select2').on('change', function() {
                $(this).valid();
            });
        });
  </script>
  @stack('scripts')
</body>
</html>