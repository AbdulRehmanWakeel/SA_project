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

 
Route::middleware(['auth'])->group(function () {

    Route::middleware('permission:view_contacts')->group(function () {
        Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
    });

    Route::middleware('permission:create_contacts')->group(function () {
        Route::get('/contacts/create', [ContactController::class, 'create'])->name('contacts.create');
        Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
    });

    Route::middleware('permission:edit_contacts')->group(function () {
        Route::get('/contacts/{contact}/edit', [ContactController::class, 'edit'])->name('contacts.edit');
        Route::put('/contacts/{contact}', [ContactController::class, 'update'])->name('contacts.update');
    });

    Route::middleware('permission:delete_contacts')->group(function () {
        Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
    });

});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'permission:manage_users'])->group(function () {
    Route::resource('users', UserController::class);
});
