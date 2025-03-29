<?php

use App\Http\Controllers\DashboardController;

Route::get('/dashboard', function () {
    return view('layout.index');
});
