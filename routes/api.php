<?php

use App\Http\Controllers\LinkController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Auth;
use App\Http\Middleware\Click;
use App\Http\Middleware\Registered;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



Route::middleware(['auth'])->group(function () {
    Route::post('/registration', [UserController::class, 'registration']);

    // Route::get('/links/paginate', [LinkController::class,'getLinkPaginate']);

    Route::prefix('link')->group(function () {
        Route::post('/create', [LinkController::class,'create']);
        Route::post('/{id}/edit', [LinkController::class, 'edit']);
        Route::post('/{id}/remove', [LinkController::class, 'remove']);
        Route::post('/{id}/click',[LinkController::class,'click'])->withoutMiddleware(['auth']);
    });
});

Route::post('/user/remove', [UserController::class, 'removeAccount']);



