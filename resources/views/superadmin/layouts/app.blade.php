<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Superadmin Dashboard') | Geofence Attendance</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 h-screen flex overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 text-white flex flex-col">
        <div class="h-16 flex items-center px-6 border-b border-gray-800">
            <h1 class="text-xl font-bold tracking-wider">Superadmin</h1>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="{{ route('superadmin.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-800 transition {{ request()->routeIs('superadmin.dashboard') ? 'bg-gray-800 text-white' : 'text-gray-400' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Dashboard
            </a>
            <a href="{{ route('superadmin.plans.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-800 transition {{ request()->routeIs('superadmin.plans.*') ? 'bg-gray-800 text-white' : 'text-gray-400' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Subscription Plans
            </a>
        </nav>
        <div class="p-4 border-t border-gray-800">
            <form action="{{ route('superadmin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex w-full items-center px-4 py-3 rounded-lg text-red-400 hover:bg-gray-800 hover:text-red-300 transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-screen overflow-y-auto">
        <!-- Header -->
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 z-10 sticky top-0">
            <h2 class="text-xl font-semibold text-gray-800">@yield('page_title')</h2>
            <div class="flex items-center">
                <span class="text-sm font-medium text-gray-600">Logged in as Superadmin</span>
            </div>
        </header>

        <!-- Page Content -->
        <div class="flex-1 p-8">
            @yield('content')
        </div>
    </main>
</body>
</html>
