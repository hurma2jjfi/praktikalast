<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/{user}', [ProfileController::class, 'showAnother'])->name('profile.another');
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    // Route::get('/profile/show', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::delete('/profile/delete', [ProfileController::class, 'delete'])->name('profile.delete');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Category Routes (Admin)
    Route::middleware('admin')->group(function () {
        Route::get('/admin/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
        Route::post('/admin/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
        Route::put('/admin/categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
        Route::delete('/admin/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');
    });


    Route::get('/news', [NewsController::class, 'index'])->name('news.index');
    Route::get('/news/upload', [NewsController::class, 'create'])->name('news.upload');
    Route::post('/news', [NewsController::class, 'store'])->name('news.store');

    // Post Routes
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    
    //Удаление и редактирование поста
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');



    // Friend Routes
    Route::get('/friends/search', [FriendController::class, 'search'])->name('friends.search');
    Route::get('/friends', [FriendController::class, 'index'])->name('friends.index');
    Route::post('/friends/{user}/add', [FriendController::class, 'add'])->name('friends.add');
    Route::post('/friends/{user}/accept', [FriendController::class, 'accept'])->name('friends.accept');
    Route::delete('/friends/{user}/remove', [FriendController::class, 'remove'])->name('friends.remove');

    // Chat Routes
    Route::get('/friends/{user}/chat', [FriendController::class, 'showChat'])->name('friends.chat');
    Route::post('/friends/{user}/chat/send', [FriendController::class, 'sendMessage'])->name('friends.sendMessage');
    Route::delete('/friends/messages/{message}', [FriendController::class, 'deleteMessage'])->name('friends.deleteMessage');


    Route::get('/chats', [ChatController::class, 'index'])->name('chats.index');
    Route::get('/chats/{chat}', [ChatController::class, 'show'])->name('chats.show');
    Route::post('/chats/{chat}/messages', [ChatController::class, 'sendMessage'])->name('chats.messages.store');
});
