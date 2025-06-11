<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SessionDashboardController;
use App\Http\Controllers\FavoriteTutorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AvailabilitySlotController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TutorProfileController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::post('/tutors/{tutorProfile}/favorite', [FavoriteTutorController::class, 'store'])->name('tutors.favorite');
    Route::delete('/tutors/{tutorProfile}/unfavorite', [FavoriteTutorController::class, 'destroy'])->name('tutors.unfavorite');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{user}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{user}', [MessageController::class, 'store'])->name('messages.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/availability', [AvailabilitySlotController::class, 'index'])->name('availability.index');
    Route::post('/availability', [AvailabilitySlotController::class, 'store'])->name('availability.store');
    Route::delete('/availability/{availabilitySlot}', [AvailabilitySlotController::class, 'destroy'])->name('availability.destroy');
});

Route::middleware(['auth'])->post('/tutors/{tutor}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

Route::middleware(['auth'])->group(function () {
    Route::get('/become-a-tutor', [TutorController::class, 'create'])->name('tutor.become');
    Route::post('/become-a-tutor', [TutorController::class, 'store'])->name('tutor.save');
});

Route::post('/sessions/{session}/approve', [SessionController::class, 'approve'])->name('sessions.approve');
Route::post('/sessions/{session}/reject', [SessionController::class, 'reject'])->name('sessions.reject');
Route::post('/sessions/{session}/cancel', [SessionController::class, 'cancel'])->name('sessions.cancel');



require __DIR__.'/auth.php';


Route::get('/tutors', [TutorController::class, 'index'])->name('tutors.index');
Route::get('/tutors/{id}', [TutorController::class, 'show'])->name('tutors.show');
Route::post('/sessions/book/{tutor}', [SessionController::class, 'book'])->name('sessions.book');
Route::get('/dashboard/sessions', [SessionDashboardController::class, 'index'])->name('sessions.dashboard');
