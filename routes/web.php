<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

 
// View
Route::middleware(['auth', 'permission:view_contacts'])
    ->get('/contacts', [ContactController::class, 'index'])
    ->name('contacts.index');

// Create
Route::middleware(['auth', 'permission:create_contacts'])
    ->get('/contacts/create', [ContactController::class, 'create'])
    ->name('contacts.create');

Route::middleware(['auth', 'permission:create_contacts'])
    ->post('/contacts', [ContactController::class, 'store'])
    ->name('contacts.store');

// Edit
Route::middleware(['auth', 'permission:edit_contacts'])
    ->get('/contacts/{contact}/edit', [ContactController::class, 'edit'])
    ->name('contacts.edit');

Route::middleware(['auth', 'permission:edit_contacts'])
    ->put('/contacts/{contact}', [ContactController::class, 'update'])
    ->name('contacts.update');

// Delete
Route::middleware(['auth', 'permission:delete_contacts'])
    ->delete('/contacts/{contact}', [ContactController::class, 'destroy'])
    ->name('contacts.destroy');

require __DIR__.'/auth.php';

Route::middleware(['auth', 'permission:manage_users'])->group(function () {
    Route::resource('users', UserController::class);
});
