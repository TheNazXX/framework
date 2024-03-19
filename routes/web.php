<?php 

use Framework\Router\Route;

use App\Controllers\HomeController;
use App\Controllers\PostController;

return [
  Route::get('/', [HomeController::class, 'index']),
  Route::get('/posts/{id:\d+}', [PostController::class, 'show']),
];