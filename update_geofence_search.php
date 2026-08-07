<?php
$files = [
    'resources/views/admin/employees/create.blade.php',
    'resources/views/admin/employees/edit.blade.php'
];

$searchHtmlOld = <<<'EOD'
            <label class="form-label fw-bold mb-3">Assign Geofences <span class="text-danger">*</span></label>
            <div class="row g-3">
                @foreach($geofences as $geofence)
                <div class="col-md-6">
EOD;

$searchHtmlNew = <<<'EOD'
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-3 gap-2">
                <label class="form-label fw-bold mb-0">Assign Geofences <span class="text-danger">*</span></label>
                <div class="input-group input-group-sm" style="max-width: 300px;">
                    <span class="input-group-text bg-transparent"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" id="geofenceSearch" class="form-control border-start-0 ps-0" placeholder="Search sites...">
                </div>
            </div>
            <div class="row g-3" id="geofenceList">
                @foreach($geofences as $geofence)
                <div class="col-md-6 geofence-item">
EOD;

$searchHtmlOld2 = <<<'EOD'
                        <div>
                            <div class="fw-bold">{{ $geofence->name }}</div>
EOD;

$searchHtmlNew2 = <<<'EOD'
                        <div>
                            <div class="fw-bold geofence-name">{{ $geofence->name }}</div>
EOD;

$errorDivOld = <<<'EOD'
                @endforeach
            </div>
            @error('geofences')
EOD;
$errorDivNew = <<<'EOD'
                @endforeach
            </div>
            <div id="noGeofenceResults" class="alert alert-light border border-info border-start border-start-4 mt-3 d-none">
                <i class="bi bi-info-circle me-2 text-info"></i> No sites found matching your search.
            </div>
            @error('geofences')
EOD;

$jsToInsert = <<<'EOD'
        $('#geofenceSearch').on('input', function() {
            var searchTerm = $(this).val().toLowerCase();
            var visibleCount = 0;
            
            $('.geofence-item').each(function() {
                var text = $(this).find('.geofence-name').text().toLowerCase();
                if (text.indexOf(searchTerm) > -1) {
                    $(this).removeClass('d-none');
                    visibleCount++;
                } else {
                    $(this).addClass('d-none');
                }
            });
            
            if (visibleCount === 0 && $('.geofence-item').length > 0) {
                $('#noGeofenceResults').removeClass('d-none');
            } else {
                $('#noGeofenceResults').addClass('d-none');
            }
        });
EOD;

foreach ($files as $file) {
    if (!file_exists($file)) continue;
    $content = file_get_contents($file);
    
    // Replace HTML
    if (strpos($content, 'id="geofenceSearch"') === false) {
        $content = str_replace($searchHtmlOld, $searchHtmlNew, $content);
        $content = str_replace($searchHtmlOld2, $searchHtmlNew2, $content);
        $content = str_replace($errorDivOld, $errorDivNew, $content);
    }
    
    // Replace JS
    if (strpos($content, "$('#geofenceSearch').on('input'") === false) {
        $content = preg_replace('/(\$\(document\)\.ready\(function\(\)\s*\{)/', "$1\n" . $jsToInsert, $content);
    }
    
    file_put_contents($file, $content);
}

echo "Search added.\n";
?>
