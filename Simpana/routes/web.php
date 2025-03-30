<?php
use App\Http\Controllers\RegistController;

Route::get('/register', [RegistController::class, 'showForm']);
Route::post('/register', [RegistController::class, 'submitForm']);
