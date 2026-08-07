<?php
$files = [
    'resources/views/admin/employees/index.blade.php',
    'resources/views/admin/attendance/index.blade.php',
    'resources/views/admin/attendance/today.blade.php',
    'resources/views/admin/attendance/delete.blade.php',
    'resources/views/admin/attendance/today_absent.blade.php'
];

$styles = <<<'EOD'
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--single {
        height: 31px; /* match input-sm */
        padding: 2px 12px;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 30px;
    }
    .select2-container .select2-selection--single .select2-selection__rendered {
        padding-left: 0;
    }
</style>
@endpush

EOD;

$scripts = <<<'EOD'

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            width: '100%'
        });
    });
</script>
@endpush
EOD;

foreach ($files as $file) {
    if (!file_exists($file)) continue;
    
    $content = file_get_contents($file);
    
    // 1. Add select2 class to geofence dropdown
    $content = str_replace('<select name="geofence" id="geofence" class="form-select">', '<select name="geofence" id="geofence" class="form-select select2">', $content);
    
    // 2. Add styles after @section('content')
    if (strpos($content, '@push(\'styles\')') === false && strpos($content, '<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />') === false) {
        $content = str_replace("@section('content')\n", "@section('content')\n" . $styles, $content);
    }
    
    // 3. Add scripts at the end of the file
    if (strpos($content, '<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>') === false) {
        $content .= $scripts;
    }
    
    file_put_contents($file, $content);
}

echo "Added select2 to all requested files.\n";
?>
