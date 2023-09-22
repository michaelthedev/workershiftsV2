<?php
use App\Controllers\WorkerController;
use App\Handlers\RouterCustomClassLoader;
use Pecee\SimpleRouter\SimpleRouter as Router;

// API Routes start with /api
Router::group(['prefix' => '/api'], function () {

    // Custom class loader with DI
    Router::setCustomClassLoader(new RouterCustomClassLoader());

    Router::get('/', function() {
        response()->json([
            'message' => 'Welcome to the api'
        ]);
    });

    Router::group(['prefix' => 'workers'], function () {
        Router::get('/', [WorkerController::class, 'index']);
        Router::post('/', [WorkerController::class, 'create']);

        Router::get('/{id}', [WorkerController::class, 'get']);
        Router::put('/{id}', [WorkerController::class, 'update']);
        Router::delete('/{id}', [WorkerController::class, 'delete']);
    });

    Router::group(['prefix' => 'shifts'], function () {
        Router::get('/', [WorkerController::class, 'index']);
        Router::post('/', [WorkerController::class, 'create']);

        Router::get('/{id}', [WorkerController::class, 'show']);
        Router::put('/{id}', [WorkerController::class, 'update']);
        Router::delete('/{id}', [WorkerController::class, 'delete']);
    });
});