<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\SinscritController;
use App\Http\Controllers\AccesClassController;
use App\Http\Controllers\ContenuController;
use App\Http\Controllers\AccesContenuController;
use App\Http\Controllers\userController;
use App\Http\Controllers\DevoirController;
use App\Http\Controllers\AccesDevoirController;
use App\Http\Controllers\CorrectionController;
use App\Http\Controllers\AccesSessionLiveController;


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
        Route::get('permissions-roles', [AuthController::class, 'getPermissionsAndRoles']);
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

//Acces devoir
Route::middleware(['auth:api'])->group(
    function () {
        Route::get('/accesdevoirs/{id}', [AccesDevoirController::class, 'showAll'])->middleware('CheckAccesContenuPermission');
        Route::get('/accesdevoir/{id}', [AccesDevoirController::class, 'show'])->middleware('CheckShowDevoirPermission');
    }
);

// user
Route::middleware(['auth:api'])->group(
    function () {
        Route::get('/users', [userController::class, 'showAll']);
        Route::get('/user/{id}', [userController::class, 'show']);
        Route::post('/user/update/{id}', [userController::class, 'update']);
        Route::delete('/user/{id}', [userController::class, 'destroy']);
    }
);

// Devoir
Route::middleware(['auth:api'])->group(
    function () {
        Route::post('/devoir', [DevoirController::class, 'create'])->middleware('CheckSinscriPermission');
        Route::get('/devoirs/{id}', [DevoirController::class, 'showAll'])->middleware('CheckClassPermission');
        Route::get('/devoir/{id}', [DevoirController::class, 'show']);
        Route::delete('/devoir/{id}', [DevoirController::class, 'destroy']);
    }
);

// Correction
Route::middleware(['auth:api'])->group(
    function () {
        Route::post('/Correction', [CorrectionController::class, 'create'])->middleware('CheckCreateCorrectionPermission');
        Route::get('/Correction/{id}', [CorrectionController::class, 'show'])->middleware('CheckShowCorrectionDevoirPermission');
        Route::delete('/Correction/{id}', [CorrectionController::class, 'destroy']);
    }
);

// room
Route::middleware(['auth:api'])->group(
    function () {
        Route::get('/room/{id}', [AccesSessionLiveController::class, 'show'])->middleware('CheckAccesRoomPermission');
    }
);