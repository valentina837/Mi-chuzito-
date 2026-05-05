<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuItemController;

Route::resource('menu-items', MenuItemController::class);