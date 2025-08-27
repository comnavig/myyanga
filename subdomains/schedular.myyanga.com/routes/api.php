<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CohortController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\CohortLocationController;
use App\Http\Controllers\InstructorController;
use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\GetUserFromToken;


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

Route::middleware('auth:sanctum')->get('/user', function () {
    return auth()->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('/current-user', [AuthController::class, 'getCurrentUser']);

//SECTION - Admin Routes
Route::middleware(CheckAdmin::class)->get('/users', [UserController::class, 'getUsers']);
Route::middleware(CheckAdmin::class)->post('/users', [UserController::class, 'createAccount']);
Route::middleware(CheckAdmin::class)->get('/users/{id}', [UserController::class, 'getUserById']);
Route::middleware(CheckAdmin::class)->put('/users/{userId}/edit', [UserController::class, 'editUser']);

Route::middleware(CheckAdmin::class)->post('/courses', [CourseController::class, 'createCourse']);
Route::middleware(CheckAdmin::class)->put('/courses/{id}', [CourseController::class, 'updateCourse']);
Route::middleware(CheckAdmin::class)->delete('/courses/{id}', [CourseController::class, 'destroy']);

Route::middleware(CheckAdmin::class)->post('/cohort', [CohortController::class, 'store']);
Route::middleware(CheckAdmin::class)->put('/cohort/{id}', [CohortController::class, 'update']);
Route::middleware(CheckAdmin::class)->delete('/cohort/{id}', [CohortController::class, 'destroy']);

Route::middleware(CheckAdmin::class)->post('/resource', [ResourceController::class, 'store']);
Route::middleware(CheckAdmin::class)->put('/resource/{id}', [ResourceController::class, 'update']);
Route::middleware(CheckAdmin::class)->delete('/resource/{id}', [ResourceController::class, 'destroy']);

Route::middleware(CheckAdmin::class)->post('/location', [LocationController::class, 'store']);
Route::middleware(CheckAdmin::class)->put('/location/{id}', [LocationController::class, 'update']);
Route::middleware(CheckAdmin::class)->delete('/location/{id}', [LocationController::class, 'destroy']);

Route::middleware(CheckAdmin::class)->post('/cohort_location', [CohortLocationController::class, 'store']);
Route::middleware(CheckAdmin::class)->put('/cohort_location/{id}', [CohortLocationController::class, 'update']);
Route::middleware(CheckAdmin::class)->delete('/cohort_location/{id}', [CohortLocationController::class, 'destroy']);

Route::middleware(CheckAdmin::class)->post('/instructor', [InstructorController::class, 'store']);
Route::middleware(CheckAdmin::class)->put('/instructor/{id}', [InstructorController::class, 'update']);
Route::middleware(CheckAdmin::class)->delete('/instructor/{id}', [InstructorController::class, 'destroy']);


//SECTION - User Routes
Route::middleware(GetUserFromToken::class)->put('/profile/edit', [AuthController::class, 'editProfile']);
Route::middleware(GetUserFromToken::class)->put('/profile/password', [AuthController::class, 'updatePassword']);

Route::middleware(GetUserFromToken::class)->get('/courses', [CourseController::class, 'index']);
Route::middleware(GetUserFromToken::class)->get('/courses/{id}', [CourseController::class, 'show']);

Route::middleware(GetUserFromToken::class)->get('/cohort', [CohortController::class, 'index']);
Route::middleware(GetUserFromToken::class)->get('/cohort/{id}', [CohortController::class, 'show']);

Route::middleware(GetUserFromToken::class)->get('/resource', [ResourceController::class, 'index']);
Route::middleware(GetUserFromToken::class)->get('/resource/{id}', [ResourceController::class, 'show']);

Route::middleware(GetUserFromToken::class)->get('/location', [LocationController::class, 'index']);
Route::middleware(GetUserFromToken::class)->get('/location/{id}', [LocationController::class, 'show']);

Route::middleware(GetUserFromToken::class)->get('/cohort_location', [CohortLocationController::class, 'index']);
Route::middleware(GetUserFromToken::class)->get('/cohort_location/{id}', [CohortLocationController::class, 'show']);

Route::middleware(GetUserFromToken::class)->get('/instructor', [InstructorController::class, 'index']);
Route::middleware(GetUserFromToken::class)->get('/instructor/{id}', [InstructorController::class, 'show']);