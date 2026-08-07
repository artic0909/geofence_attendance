<?php
// Append CSS to style.css
$css = <<<'EOD'

/* Select2 Global Overrides for Light/Dark Mode & Heights */
.select2-container--default .select2-selection--single {
  height: 38px;
  padding: 5px 36px 5px 12px;
  border: 1px solid var(--admin-border);
  border-radius: 0.375rem;
  background-color: var(--admin-surface);
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
  color: var(--admin-text);
  line-height: 26px;
  padding-left: 0;
  padding-right: 0;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
  height: 36px;
  right: 6px;
}

.select2-dropdown {
  background-color: var(--admin-surface);
  border-color: var(--admin-border);
  color: var(--admin-text);
}

.select2-search--dropdown .select2-search__field {
  background-color: var(--admin-surface);
  border: 1px solid var(--admin-border);
  color: var(--admin-text);
}

.select2-container--default .select2-results__option {
  color: var(--admin-text);
}

.select2-container--default .select2-results__option--selected {
  background-color: var(--admin-surface-soft);
  color: var(--admin-text);
}

.select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
  background-color: var(--admin-primary);
  color: #ffffff;
}
EOD;

file_put_contents('public/admin_assets/css/style.css', $css, FILE_APPEND);

// Remove inline styles from the 5 files
$files = [
    'resources/views/admin/employees/index.blade.php',
    'resources/views/admin/attendance/index.blade.php',
    'resources/views/admin/attendance/today.blade.php',
    'resources/views/admin/attendance/delete.blade.php',
    'resources/views/admin/attendance/today_absent.blade.php',
    'resources/views/admin/employees/create.blade.php',
    'resources/views/admin/employees/edit.blade.php',
    'resources/views/superadmin/organization/employees/create.blade.php',
    'resources/views/superadmin/organization/employees/edit.blade.php'
];

foreach ($files as $file) {
    if (!file_exists($file)) continue;
    $content = file_get_contents($file);
    
    // Use regex to remove <style>...</style> block inside @push('styles') if it's there
    $content = preg_replace('/<style>\s*\.select2-container.*?<\/style>/s', '', $content);
    
    file_put_contents($file, $content);
}

echo "Done fixing CSS\n";
?>
