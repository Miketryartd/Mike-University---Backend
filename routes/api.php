<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\GradesController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ClassController;

//auth//
Route::post('/register', [UserController::class, 'Register'])->name('register');
Route::post('/login', [UserController::class, 'Login'])->name('login');

//search//
Route::get('/search', [SearchController::class, 'Search'] )->name('search');
Route::get('/profile/user/{id}', [UserController::class, 'UserProfile'])->name('user-profile');
Route::middleware(['auth:sanctum'])->group(function (){
    //auth//
    Route::post('/logout', [UserController::class, 'Logout'])->name('logout');
    Route::get('/user', [UserController::class, 'User'])->name('user');
    
    


    //classes
    Route::post('/create-class', [ClassController::class, "CreateClass"])->name("create-class");

    
    //subjects
      Route::post('/add-subject', [SubjectController::class, 'addSubject'])->name('add-subject');

    //announcements//
    Route::get('/announcements/{page}', [AnnouncementController::class, 'GetAnnouncement'])->name('get-announcement');
    Route::post('/create-announcement', [AnnouncementController::class, 'CreateAnnouncement'])->name('create-announcement');   
    

    //comments//
    Route::post('/add-comment', [CommentController::class, "AddComment"])->name('add-comment');
    
});