<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ auth()->user()->business_name }} | Geofence Attendance System</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- adminHMD Template CSS -->
    <link rel="stylesheet" href="{{ asset('admin_assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/css/style.css') }}">

    <!-- Existing Core Scripts & Tailwind (kept for inner views compatibility) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            corePlugins: {
                preflight: false,
            },
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
        
        /* Dark Mode Template Variables Fix */
        [data-theme="dark"] {
            --admin-bg: #111827;
            --admin-surface: #1f2937;
            --admin-surface-soft: #374151;
            --admin-border: #374151;
            --admin-text: #f3f4f6;
            --admin-muted: #9ca3af;
            --admin-shadow-sm: 0 10px 24px rgba(0, 0, 0, 0.5);
            --admin-shadow: 0 18px 46px rgba(0, 0, 0, 0.6);
            --admin-shadow-lg: 0 26px 70px rgba(0, 0, 0, 0.7);
        }
        [data-theme="dark"] body {
            background: var(--admin-bg) !important;
            color: var(--admin-text) !important;
        }
        
        /* Dark mode headings & elements fix */
        [data-theme="dark"] .panel, [data-theme="dark"] .card {
            background-color: var(--admin-surface);
            border-color: var(--admin-border);
        }
        [data-theme="dark"] .table {
            --bs-table-bg: transparent;
            --bs-table-color: var(--admin-text);
            --bs-table-border-color: var(--admin-border);
        }
        [data-theme="dark"] .page-heading h1, [data-theme="dark"] .page-heading p {
            color: var(--admin-text) !important;
        }
        [data-theme="dark"] .text-gray-800, [data-theme="dark"] .text-dark {
            color: var(--admin-text) !important;
        }
        [data-theme="dark"] .bg-white, [data-theme="dark"] .bg-light {
            background-color: var(--admin-surface) !important;
        }
        [data-theme="dark"] .border-gray-300, [data-theme="dark"] .border-gray-200 {
            border-color: var(--admin-border) !important;
        }
    </style>
    @stack('styles')
    
    <script>
        // Sync Tailwind dark mode class with the template's data-theme attribute
        document.addEventListener('DOMContentLoaded', () => {
            const htmlEl = document.documentElement;
            
            const syncTheme = () => {
                if (htmlEl.getAttribute('data-theme') === 'dark') {
                    htmlEl.classList.add('dark');
                } else {
                    htmlEl.classList.remove('dark');
                }
            };
            
            // Initial sync
            syncTheme();
            
            // Watch for changes
            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    if (mutation.attributeName === 'data-theme') {
                        syncTheme();
                    }
                });
            });
            
            observer.observe(htmlEl, { attributes: true });
        });
    </script>
</head>

<body>
  <div class="admin-shell">
    <div class="sidebar-backdrop" data-sidebar-close></div>

    <aside class="admin-sidebar" id="adminSidebar" aria-label="Main navigation">
      <div class="sidebar-header">
        <a class="brand-mark" href="{{ route('admin.dashboard') }}" aria-label="Dashboard">
          <span class="brand-copy">
            <span class="brand-title" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 140px;">
              <img src="{{asset('logo.png')}}" alt="" style="width: 48px; height: 48px; border-radius: 5px; color: white;">                                                                                                                                                                    {{ auth()->user()->business_name }}
            </span>
            <span class="brand-subtitle">Geofence Attendance</span>
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

          <h2 class="h5 mb-0 ms-3 fw-bold d-none d-md-block text-gray-800 dark:text-white">
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
          <span>Copyright {{ date('Y') }} Sumatra Sales Private Limited.</span>
          <span>Smart Geofence Attendance</span>
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

            // Global delete confirmation
            $(document).on('click', '.delete-btn', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                var itemType = $(this).data('item') || 'item';
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to delete this " + itemType + "? This action cannot be undone.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
  </script>
  @stack('scripts')
</body>
</html>