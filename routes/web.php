<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PredictController;
Route::get('/', function () {
    return view('form');
});

Route::post('/predict', [PredictController::class, 'predict']);
