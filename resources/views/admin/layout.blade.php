<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ auth()->user()->business_name }} | Geofence Attendance System</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body class="bg-gray-100">
    <nav class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">{{ auth()->user()->business_name }}</h1>
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-200 {{ request()->routeIs('admin.dashboard') ? 'text-blue-200' : '' }}">Dashboard</a>
                <a href="{{ route('admin.geofences.index') }}" class="hover:text-blue-200 {{ request()->routeIs('admin.geofences.*') ? 'text-blue-200' : '' }}">Sites(Geofences)</a>
                <a href="{{ route('admin.employees.index') }}" class="hover:text-blue-200 {{ request()->routeIs('admin.employees.*') ? 'text-blue-200' : '' }}">Employees</a>
                <a href="{{ route('admin.attendances.options') }}" class="hover:text-blue-200 {{ request()->routeIs('admin.attendances.options') ? 'text-blue-200' : '' }}">Attendances</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="hover:text-blue-200">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-4">
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

            @if(session('success'))
                Toast.fire({
                    icon: 'success',
                    title: "{{ session('success') }}"
                });
            @endif

            @if(session('error'))
                Toast.fire({
                    icon: 'error',
                    title: "{{ session('error') }}"
                });
            @endif
        </script>

        @yield('content')
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>