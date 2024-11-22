<?php

use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\TestimonialsController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\TrialClassController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route; 
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('testimonials', [TestimonialsController::class, 'index']);
Route::get('teachers', [TeamController::class, 'index']);
Route::get('courses', [CourseController::class, 'index']);
Route::get('courses/science', [CourseController::class, 'courseScience']); 
Route::get('courses/{id}', [CourseController::class, 'show']);
Route::get('courses/{id}/terms', [CourseController::class, 'getTerms']);
Route::resource('trial-classes', TrialClassController::class);
Route::post('auth/register', [RegisterController::class, 'store']);


Route::post('/trials/{user}/{course}', [TrialClassController::class, 'registerTrialClass']);
Route::get('/trials/{user}/{course}/status', [TrialClassController::class, 'checkTrialClassStatus']);
Route::put('/trials/{user}/{course}/complete', [TrialClassController::class, 'completeTrialClass']);