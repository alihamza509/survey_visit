<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckInCheckOutController;
use App\Http\Controllers\SurveyVisitController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('login', [AuthController::class, 'login'])->name('login');
// Group routes that require authentication
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/check-in-out', [CheckInCheckOutController::class, 'checkInOut']);
    Route::get('/check-ins', [CheckInCheckOutController::class, 'index']);
    Route::post('/survey-visits', [SurveyVisitController::class, 'store']);
    Route::get('/shop-names', [SurveyVisitController::class, 'getShopNames']);
    Route::post('/expense', [SurveyVisitController::class, 'expenseStore']);
    Route::post('/sample_order', [SurveyVisitController::class, 'storeSampleOrder']);
    Route::get('/sample_order', [SurveyVisitController::class, 'indexSampleOrder']);
    Route::post('/follow_up', [SurveyVisitController::class, 'storeFollowUp']);
    Route::get('/follow_up', [SurveyVisitController::class, 'indexFollowUp']);
    Route::post('/trail_order', [SurveyVisitController::class, 'storeTrailOrder']);
    Route::get('/trail_order', [SurveyVisitController::class, 'indexTrailOrder']);
    Route::post('/download-data', [SurveyVisitController::class, 'fetchData']);

});
