<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\CreateItem;
use App\Livewire\EditItem;
use App\Livewire\ItemList;
use App\Livewire\ItemShow;
use App\Livewire\MyItems;
use Illuminate\Support\Facades\Route;

// Redirect root to items list (protected behind auth)
Route::get('/', function () {
    return redirect()->route('items.index');
});

// Protected routes - require authentication
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard route used by Breeze controllers and tests.
    // Пренасочва към основния списък с обяви.
    Route::get('/dashboard', function () {
        return redirect()->route('items.index');
    })->name('dashboard');

    // Items list (main feed)
    Route::get('/items', ItemList::class)->name('items.index');

    // My items
    Route::get('/my-items', MyItems::class)->name('items.mine');

    // Create item
    Route::get('/items/create', CreateItem::class)->name('items.create');

    // Show item detail
    Route::get('/items/{item}', ItemShow::class)->name('items.show');

    // Edit item
    Route::get('/items/{item}/edit', EditItem::class)->name('items.edit');

    // Profile routes (from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
