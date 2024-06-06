<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController as PetController;

Route::get('/', [PetController::class, 'showPage']);
Route::get('/pets', [PetController::class, 'getPets']);
Route::post('/pets', [PetController::class, 'store']);
Route::get('/pets/{id}', [PetController::class, 'show']);
Route::put('/pets/{id}', [PetController::class, 'update']);
Route::delete('/pets/{id}', [PetController::class, 'destroy']);
