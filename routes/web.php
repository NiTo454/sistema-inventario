<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

require __DIR__.'/auth.php';


Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('users')->name('users.')->group(function () {
        // LISTA - solo admin
        Route::get('/', function () {
            if (auth()->user()->role !== 'admin') {
                abort(403, 'Solo administradores');
            }
            return app(UserController::class)->index();
        })->name('index');

        // CREAR - solo admin
        Route::get('/create', function () {
            if (auth()->user()->role !== 'admin') {
                abort(403, 'Solo administradores');
            }
            return app(UserController::class)->create();
        })->name('create');

        Route::post('/', function (Illuminate\Http\Request $request) {
            if (auth()->user()->role !== 'admin') {
                abort(403, 'Solo administradores');
            }
            return app(UserController::class)->store($request);
        })->name('store');

        // VER - todos pueden ver
        Route::get('/{user}', [UserController::class, 'show'])->name('show');

        // EDITAR - solo admin
        Route::get('/{user}/edit', function (App\Models\User $user) {
            if (auth()->user()->role !== 'admin') {
                abort(403, 'Solo administradores');
            }
            return app(UserController::class)->edit($user);
        })->name('edit');

        Route::put('/{user}', function (Illuminate\Http\Request $request, App\Models\User $user) {
            if (auth()->user()->role !== 'admin') {
                abort(403, 'Solo administradores');
            }
            return app(UserController::class)->update($request, $user);
        })->name('update');

        // ELIMINAR - solo admin
        Route::delete('/{user}', function (App\Models\User $user) {
            if (auth()->user()->role !== 'admin') {
                abort(403, 'Solo administradores');
            }
            return app(UserController::class)->destroy($user);
        })->name('destroy');
    });

    Route::resource('products', ProductController::class);

    Route::resource('sales', SaleController::class);
});
