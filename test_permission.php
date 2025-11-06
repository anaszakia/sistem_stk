<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

echo "=== Testing Permission System ===" . PHP_EOL . PHP_EOL;

// Check if permissions exist
$permissions = Permission::where('name', 'like', '%kendaraan%')->get();
echo "Kendaraan Permissions:" . PHP_EOL;
foreach ($permissions as $perm) {
    echo "  - {$perm->name} (ID: {$perm->id})" . PHP_EOL;
}
echo PHP_EOL;

// Check super_admin role
$superAdmin = Role::where('name', 'super_admin')->first();
if ($superAdmin) {
    echo "Super Admin Role (ID: {$superAdmin->id})" . PHP_EOL;
    echo "Total permissions: " . $superAdmin->permissions->count() . PHP_EOL;
    echo "Has 'view kendaraan': " . ($superAdmin->hasPermissionTo('view kendaraan') ? 'YES' : 'NO') . PHP_EOL;
    echo "Has 'create kendaraan': " . ($superAdmin->hasPermissionTo('create kendaraan') ? 'YES' : 'NO') . PHP_EOL;
} else {
    echo "Super Admin role not found!" . PHP_EOL;
}

echo PHP_EOL . "=== Test Complete ===" . PHP_EOL;
