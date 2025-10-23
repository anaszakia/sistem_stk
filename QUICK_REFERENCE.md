# 🚀 Quick Reference: Adding New Menu

## ⚡ Quick Commands

```bash
# 1. Add permissions to seeder and run
php artisan db:seed --class=RolePermissionSeeder
php artisan permission:cache-reset

# 2. Create migration (if needed)
php artisan make:migration create_table_name

# 3. Create model
php artisan make:model ModelName

# 4. Create controller
php artisan make:controller ControllerName --resource

# 5. Test and verify
php artisan route:list --name=your_menu
php artisan permission:show
```

## 📋 Permission Template

```php
// In RolePermissionSeeder.php
$permissions = [
    // Existing permissions...
    
    // NEW MENU - Replace 'items' with your menu name
    'view items',
    'create items', 
    'edit items',
    'delete items',
];
```

## 🛣️ Route Template

```php
// In routes/web.php
Route::middleware(['auth', 'log.sensitive'])->group(function () {
    Route::get('/items', [ItemController::class, 'index'])
        ->middleware('permission:view items')
        ->name('items.index');
    Route::get('/items/create', [ItemController::class, 'create'])
        ->middleware('permission:create items')
        ->name('items.create');
    Route::post('/items', [ItemController::class, 'store'])
        ->middleware('permission:create items')
        ->name('items.store');
    Route::get('/items/{item}', [ItemController::class, 'show'])
        ->middleware('permission:view items')
        ->name('items.show');
    Route::get('/items/{item}/edit', [ItemController::class, 'edit'])
        ->middleware('permission:edit items')
        ->name('items.edit');
    Route::put('/items/{item}', [ItemController::class, 'update'])
        ->middleware('permission:edit items')
        ->name('items.update');
    Route::delete('/items/{item}', [ItemController::class, 'destroy'])
        ->middleware('permission:delete items')
        ->name('items.destroy');
});
```

## 🎨 Sidebar Menu Template

```blade
@can('view items')
<li class="relative">
    <a href="{{ route('items.index') }}" 
       class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors rounded-lg {{ request()->routeIs('items.*') ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600' : '' }}">
        <i class="fas fa-icon-name w-5 h-5 mr-3"></i>
        <span>Menu Name</span>
    </a>
</li>
@endcan
```

## 🔍 Controller Template

```php
<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->query('search');
        
        $items = Item::query()
            ->when($keyword, function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%");
            })
            ->latest()
            ->paginate(10)
            ->appends(['search' => $keyword]);
            
        return view('admin.items.index', compact('items', 'keyword'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            // Add other validation rules
        ]);

        Item::create($validated);

        return redirect()->route('items.index')
            ->with('success', 'Item berhasil ditambahkan!');
    }

    // Add other methods: show, edit, update, destroy
}
```

## 🗂️ File Structure

```
app/
├── Http/Controllers/
│   └── ItemController.php
├── Models/
│   └── Item.php
database/
├── migrations/
│   └── xxxx_create_items_table.php
├── seeders/
│   └── RolePermissionSeeder.php (update)
resources/views/admin/items/
├── index.blade.php
├── create.blade.php
├── edit.blade.php
└── show.blade.php
routes/
└── web.php (update)
```

## ✅ Final Checklist

- [ ] Permission added to seeder
- [ ] Migration created & run
- [ ] Model created
- [ ] Controller implemented
- [ ] Routes added with middleware
- [ ] Views created
- [ ] Sidebar updated
- [ ] Cache cleared
- [ ] Tested

## 🔧 Common Commands

```bash
# Clear all caches
php artisan optimize:clear

# Specific cache clearing
php artisan permission:cache-reset
php artisan route:clear
php artisan view:clear

# Database operations
php artisan migrate
php artisan db:seed --class=RolePermissionSeeder

# Development helpers
php artisan make:controller Name --resource
php artisan make:model Name -m
php artisan route:list
php artisan permission:show
```