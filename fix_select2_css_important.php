<?php
$file = 'public/admin_assets/css/style.css';
$content = file_get_contents($file);

$search = <<<'EOD'
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

$replace = <<<'EOD'
/* Select2 Global Overrides for Light/Dark Mode & Heights */
.select2-container--default .select2-selection--single {
  height: 38px !important;
  padding: 5px 36px 5px 12px !important;
  border: 1px solid var(--admin-border) !important;
  border-radius: 0.375rem !important;
  background-color: var(--admin-surface) !important;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
  color: var(--admin-text) !important;
  line-height: 26px !important;
  padding-left: 0 !important;
  padding-right: 0 !important;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
  height: 36px !important;
  right: 6px !important;
}

.select2-dropdown {
  background-color: var(--admin-surface) !important;
  border-color: var(--admin-border) !important;
  color: var(--admin-text) !important;
}

.select2-search--dropdown .select2-search__field {
  background-color: var(--admin-surface) !important;
  border: 1px solid var(--admin-border) !important;
  color: var(--admin-text) !important;
}

.select2-container--default .select2-results__option {
  color: var(--admin-text) !important;
}

.select2-container--default .select2-results__option--selected {
  background-color: var(--admin-surface-soft) !important;
  color: var(--admin-text) !important;
}

.select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
  background-color: var(--admin-primary) !important;
  color: #ffffff !important;
}
EOD;

if (strpos($content, $search) !== false) {
    $content = str_replace($search, $replace, $content);
    file_put_contents($file, $content);
    echo "Successfully updated style.css with !important rules.\n";
} else {
    // Just append the replace if it's somehow not matching exactly
    // Let's check first
    echo "Could not find exact block to replace, doing a regex replace.\n";
    $content = preg_replace('/\/\* Select2 Global Overrides for Light\/Dark Mode & Heights \*\/.*?color: #ffffff;\n}/s', $replace, $content);
    file_put_contents($file, $content);
}
?>
