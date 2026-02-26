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
        // Middleware para asegurar que solo admin acceda a estas rutas
        Route::middleware(['auth', 'verified'])->group(function () {
            
            // Verificación de rol manual o mediante Policy en el controlador es recomendada
            // Aquí simplificamos usando una restricción en línea o middleware personalizado
            
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('/{user}', [UserController::class, 'show'])->name('show');
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{user}', [UserController::class, 'update'])->name('update');

            // ELIMINAR: Requiere confirmación de contraseña Y ser admin
            Route::delete('/{user}', [UserController::class, 'destroy'])
                ->name('destroy')
                ->middleware(['password.confirm']); 
                // 'password.confirm' pedirá la contraseña antes de ejecutar la acción.
                // La validación de si es 'admin' debe permanecer en el Controlador o Middleware CheckRole.
        });
    });

    Route::resource('products', ProductController::class);

    Route::resource('sales', SaleController::class);
});
