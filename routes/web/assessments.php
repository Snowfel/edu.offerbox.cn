<?php
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/a-fast', function () {
  return Inertia::render('Assessments/Afast');
});

Route::post('/a-fast/submit', [App\Http\Controllers\Auth\AssessmentController::class, 'storeAfast']);


Route::get('/performance', function () {
  return Inertia::render('Assessments/Performance');
});

Route::post('/performance/submit', [App\Http\Controllers\Auth\AssessmentController::class, 'storePerformance']);
