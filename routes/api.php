<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\GradesController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CommentController;
Route::post('/register', [UserController::class, 'Register'])->name('register');
Route::post('/login', [UserController::class, 'Login'])->name('login');
Route::get('/search', [SearchController::class, 'Search'] )->name('search');

Route::middleware(['auth:sanctum'])->group(function (){
    Route::post('/logout', [UserController::class, 'Logout'])->name('logout');
    Route::post('/add-subject', [SubjectController::class, 'addSubject'])->name('add-subject');
    Route::get('/user', [UserController::class, 'User'])->name('user');

    Route::get('/announcements/{page}', [AnnouncementController::class, 'GetAnnouncement'])->name('get-announcement');
    Route::post('/create-announcement', [AnnouncementController::class, 'CreateAnnouncement'])->name('create-announcement');   
    
    Route::post('/add-comment', [CommentController::class, "AddComment"])->name('add-comment');
    
});