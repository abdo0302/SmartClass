<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\SinscritController;
use App\Http\Controllers\AccesClassController;
use App\Http\Controllers\ContenuController;
use App\Http\Controllers\AccesContenuController;

// Route::get('/user', function (Request $request) {
// return $request->user();
// })->middleware('auth:api');
Route::group(
    ['prefix' => 'auth'],
    function ($router) {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);
    }
);

Route::middleware(['auth:api'])->group(
    function () {
        Route::post('me', [AuthController::class, 'me']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
    }
);

// classe
Route::middleware(['auth:api'])->group(
    function () {
        Route::post('/classe', [ClasseController::class, 'create']);
        Route::get('/classes', [ClasseController::class, 'showAll']);
        Route::get('/classe/{id}', [ClasseController::class, 'show'])->middleware('CheckClassPermission');
        Route::post('/classe/update/{id}', [ClasseController::class, 'update'])->middleware('CheckClassPermission');
        Route::delete('/classe/{id}', [ClasseController::class, 'destroy'])->middleware('CheckClassPermission');
    }
);

// inscrit elev a classe
Route::middleware(['auth:api'])->group(
    function () {
        Route::post('/inscrit', [SinscritController::class, 'create'])->middleware('CheckSinscriPermission');
        Route::get('/inscrit/{id}', [SinscritController::class, 'show'])->middleware('CheckClassPermission');
        Route::delete('/inscrit/{id}', [SinscritController::class, 'destroy'])->middleware('CheckSinscriDeletPermission');
    }
);

// inscrit elev a classe
Route::middleware(['auth:api'])->group(
    function () {
        Route::get('/accesclass', [AccesClassController::class, 'showAll']);
    }
);

// Contenu
Route::middleware(['auth:api'])->group(
    function () {
        Route::post('/contenu', [ContenuController::class, 'create'])->middleware('CheckSinscriPermission');
        Route::get('/contenus/{id}', [ContenuController::class, 'showAll'])->middleware('CheckClassPermission');
        Route::get('/contenu/{id}', [ContenuController::class, 'show']);
        Route::post('/contenu/update/{id}', [ContenuController::class, 'update']);
        Route::delete('/contenu/{id}', [ContenuController::class, 'destroy']);
    }
);

//AccesContenu
Route::middleware(['auth:api'])->group(
    function () {
        Route::get('/accescontenus/{id}', [AccesContenuController::class, 'showAll'])->middleware('CheckAccesContenuPermission');
        Route::get('/accescontenu/{id}', [AccesContenuController::class, 'show'])->middleware('CheckShowContenuPermission');
    }
);