<?php

use App\Magnita\Swagger\Infrastructure\Http\SwaggerDocumentationController;
use Illuminate\Support\Facades\Route;

Route::prefix('/api/v1')
     ->middleware('api')
     ->group(static function () {
        Route::get('/documentation',[SwaggerDocumentationController::class, 'viewDocumentation'])->name('swagger.view-documentation');
        Route::get('/documentation/json',[SwaggerDocumentationController::class, 'getDocumentationJson'])->name('swagger.get-documentation-json');
    });