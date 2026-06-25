@extends('admin.layout')

@section('content')
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
                @foreach($employee->employeeGeofences as $geofence)
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

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWRO8RCysDN9UMY1wUfydwLR5fD8CHB34"></script>
<script>
    var map;
    var employeeMarker = null;
    var infoWindow;

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 20.5937, lng: 78.9629},
            zoom: 5,
            mapTypeId: 'hybrid' // Matches Satellite with Labels
        });
        
        infoWindow = new google.maps.InfoWindow();
        var bounds = new google.maps.LatLngBounds();

        // Add geofences to map
        @foreach($employee->employeeGeofences as $geofence)
            // Attendance Radius (Blue)
            var attendanceCircle = new google.maps.Circle({
                strokeColor: '#3b82f6',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#3b82f6',
                fillOpacity: 0.1,
                map: map,
                center: {lat: {{ $geofence->latitude }}, lng: {{ $geofence->longitude }}},
                radius: {{ $geofence->radius }}
            });
            
            // Add center of circle to bounds
            bounds.extend(new google.maps.LatLng({{ $geofence->latitude }}, {{ $geofence->longitude }}));

            google.maps.event.addListener(attendanceCircle, 'click', function(ev) {
                infoWindow.setPosition(ev.latLng);
                infoWindow.setContent('<b>{{ $geofence->name }}</b> (Attendance Area)');
                infoWindow.open(map);
            });

            // Tracking Radius (Orange)
            @if($geofence->tracking_radius)
                var trackingCircle = new google.maps.Circle({
                    strokeColor: '#f97316',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: '#f97316',
                    fillOpacity: 0.05,
                    map: map,
                    center: {lat: {{ $geofence->latitude }}, lng: {{ $geofence->longitude }}},
                    radius: {{ $geofence->tracking_radius }}
                });
                google.maps.event.addListener(trackingCircle, 'click', function(ev) {
                    infoWindow.setPosition(ev.latLng);
                    infoWindow.setContent('<b>{{ $geofence->name }}</b> Tracking Area ({{ $geofence->tracking_radius }}m)');
                    infoWindow.open(map);
                });
            @endif
        @endforeach

        // Fit map to geofences if they exist
        if (!bounds.isEmpty()) {
            map.fitBounds(bounds);
            // Optionally set a max zoom so it doesn't zoom too close if there's only one geofence
            google.maps.event.addListenerOnce(map, 'bounds_changed', function() {
                if (map.getZoom() > 16) {
                    map.setZoom(16);
                }
            });
        }

        updateLiveLocation();
        setInterval(updateLiveLocation, 10000);
    }

    function updateLiveLocation() {
        fetch('{{ route("admin.employees.latest-location", $employee) }}')
            .then(response => response.json())
            .then(data => {
                if (data.latitude && data.longitude) {
                    var pos = {lat: parseFloat(data.latitude), lng: parseFloat(data.longitude)};
                    
                    // Parse the updated_at time safely
                    var parts = data.updated_at.split(' - ');
                    var timePart = parts[0];
                    var datePart = parts[1];
                    var dParts = datePart.split('/');
                    var tParts = timePart.split(' ');
                    var hms = tParts[0].split(':');
                    var isPM = tParts[1] === 'PM';
                    var year = parseInt(dParts[2]);
                    var month = parseInt(dParts[1]) - 1;
                    var day = parseInt(dParts[0]);
                    var hour = parseInt(hms[0]);
                    if (isPM && hour < 12) hour += 12;
                    if (!isPM && hour === 12) hour = 0;
                    
                    var lastUpdateTime = new Date(year, month, day, hour, parseInt(hms[1]), parseInt(hms[2]));
                    var now = new Date();
                    var diffMinutes = (now - lastUpdateTime) / (1000 * 60);

                    if (diffMinutes > 2) {
                        document.getElementById('status-badge').innerHTML = '<span class="w-3 h-3 bg-gray-400 rounded-full"></span> Signal Lost (Offline)';
                        document.getElementById('status-badge').className = 'px-4 py-2 bg-gray-100 text-gray-600 rounded-full font-bold text-sm inline-flex items-center gap-2 border border-gray-200';
                        document.getElementById('last-update').innerText = 'Last signal was ' + Math.floor(diffMinutes) + ' mins ago. App might be closed.';
                    } else {
                        document.getElementById('status-badge').innerHTML = '<span class="pulse"></span> Live Tracking Active';
                        document.getElementById('status-badge').className = 'px-4 py-2 bg-green-100 text-green-700 rounded-full font-bold text-sm inline-flex items-center gap-2 border border-green-200';
                        document.getElementById('last-update').innerText = 'Last signal: ' + data.updated_at;
                    }

                    if (!employeeMarker) {
                        employeeMarker = new google.maps.Marker({
                            position: pos,
                            map: map,
                            title: '{{ $employee->name }}',
                            icon: {
                                path: google.maps.SymbolPath.CIRCLE,
                                scale: 8,
                                fillColor: '#22c55e',
                                fillOpacity: 1,
                                strokeColor: '#ffffff',
                                strokeWeight: 2,
                            }
                        });
                        
                        var markerInfoWindow = new google.maps.InfoWindow({
                            content: '<b>{{ $employee->name }}</b><br>Currently Tracking Live'
                        });
                        
                        employeeMarker.addListener('click', function() {
                            markerInfoWindow.open(map, employeeMarker);
                        });
                        
                        markerInfoWindow.open(map, employeeMarker);
                        
                        map.setCenter(pos);
                        map.setZoom(15);
                    } else {
                        employeeMarker.setPosition(pos);
                    }
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

    window.onload = initMap;
</script>
@endsection
