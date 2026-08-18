<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => response()->json([
    'name' => 'LinuxPath API',
    'version' => 'v1',
    'status' => 'ok',
]));
