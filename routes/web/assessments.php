<?php
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/a-fast', function () {
  return Inertia::render('Assessments/Afast');
});

Route::post('/a-fast/submit', [App\Http\Controllers\AssessmentController::class, 'storeAfast']);
