<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$e = App\Models\User::where('role', 'employee')->first();
if ($e) {
    var_dump($e->is_active);
    $e->is_active = false;
    $e->save();
    var_dump($e->is_active);
    echo json_encode($e->getChanges()) . "\n";
} else {
    echo "No employee found.\n";
}
