@extends('admin.layout')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
    #map { height: 600px; width: 100%; border-radius: 12px; border: 4px solid white; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); }
    .pulse { border-radius: 50%; height: 20px; width: 20px; background: #22c55e; box-shadow: 0 0 0 0 rgba(34, 197, 94, 1); animation: pulse-green 2s infinite; }
    @keyframes pulse-green {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(34, 197, 94, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
    }
</style>

<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Live Tracking: {{ $employee->name }}</h1>
        <p class="text-gray-600">Site-based location monitoring (Active only within tracking radius)</p>
    </div>
    <div class="text-right">
        <div id="status-badge" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-full font-bold text-sm inline-flex items-center gap-2">
            <span class="w-3 h-3 bg-gray-400 rounded-full"></span>
            Checking Status...
        </div>
        <p id="last-update" class="text-xs text-gray-500 mt-1">Waiting for signal...</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
    <div class="lg:col-span-3">
        <div id="map"></div>
    </div>
    
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Assigned Sites
            </h3>
            <div class="space-y-4">
                @foreach($employee->geofences as $geofence)
                <div class="p-3 bg-blue-50 rounded-lg border border-blue-100">
                    <p class="font-bold text-blue-800 text-sm">{{ $geofence->name }}</p>
                    <p class="text-xs text-blue-600 mt-1">Radius: {{ $geofence->radius }}m</p>
                    <p class="text-xs text-orange-600 font-bold mt-1">Track Area: {{ $geofence->tracking_radius ?? 'Disabled' }}m</p>
                </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="font-bold text-gray-800 mb-2 italic text-sm">Employee Details</h3>
            <p class="text-sm text-gray-600"><strong>ID:</strong> {{ $employee->employee_id }}</p>
            <p class="text-sm text-gray-600"><strong>Email:</strong> {{ $employee->email }}</p>
            <p class="text-sm text-gray-600"><strong>Phone:</strong> {{ $employee->phone }}</p>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    // Initialize map
    var map = L.map('map').setView([20.5937, 78.9629], 5); // Default India center
    
    // Using Google Satellite Hybrid (Satellite + Labels)
    L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains:['mt0','mt1','mt2','mt3'],
        attribution: '&copy; Google Maps'
    }).addTo(map);

    var employeeMarker = null;
    var geofenceCircles = [];

    // Add geofences to map
    @foreach($employee->geofences as $geofence)
        // Attendance Radius (Blue)
        L.circle([{{ $geofence->latitude }}, {{ $geofence->longitude }}], {
            color: '#3b82f6',
            fillColor: '#3b82f6',
            fillOpacity: 0.1,
            radius: {{ $geofence->radius }}
        }).addTo(map).bindPopup('<b>{{ $geofence->name }}</b> (Attendance Area)');

        // Tracking Radius (Orange - Dashed)
        @if($geofence->tracking_radius)
            L.circle([{{ $geofence->latitude }}, {{ $geofence->longitude }}], {
                color: '#f97316',
                fillOpacity: 0.05,
                radius: {{ $geofence->tracking_radius }},
                dashArray: '5, 10'
            }).addTo(map).bindPopup('<b>{{ $geofence->name }}</b> Tracking Area ({{ $geofence->tracking_radius }}m)');
        @endif
    @endforeach

    function updateLiveLocation() {
        fetch('{{ route("admin.employees.latest-location", $employee) }}')
            .then(response => response.json())
            .then(data => {
                if (data.latitude && data.longitude) {
                    var pos = [data.latitude, data.longitude];
                    
                    if (!employeeMarker) {
                        employeeMarker = L.marker(pos).addTo(map)
                            .bindPopup('<b>{{ $employee->name }}</b><br>Currently Tracking Live')
                            .openPopup();
                        map.setView(pos, 15);
                    } else {
                        employeeMarker.setLatLng(pos);
                    }

                    document.getElementById('status-badge').innerHTML = '<span class="pulse"></span> Live Tracking Active';
                    document.getElementById('status-badge').className = 'px-4 py-2 bg-green-100 text-green-700 rounded-full font-bold text-sm inline-flex items-center gap-2 border border-green-200';
                    document.getElementById('last-update').innerText = 'Last signal: ' + data.updated_at;
                } else {
                    document.getElementById('status-badge').innerHTML = '<span class="w-3 h-3 bg-red-400 rounded-full"></span> Outside Tracking Area';
                    document.getElementById('status-badge').className = 'px-4 py-2 bg-red-100 text-red-700 rounded-full font-bold text-sm inline-flex items-center gap-2 border border-red-200';
                    document.getElementById('last-update').innerText = 'Employee is outside the site tracking radius.';
                }
            })
            .catch(error => {
                console.error('Tracking Error:', error);
                document.getElementById('status-badge').innerHTML = '<span class="w-3 h-3 bg-gray-400 rounded-full"></span> Signal Lost';
                document.getElementById('status-badge').className = 'px-4 py-2 bg-gray-100 text-gray-600 rounded-full font-bold text-sm inline-flex items-center gap-2';
            });
    }

    // Update every 10 seconds
    setInterval(updateLiveLocation, 10000);
    updateLiveLocation();
</script>
@endsection
