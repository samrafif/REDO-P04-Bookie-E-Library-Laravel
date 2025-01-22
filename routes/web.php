<?php

use Illuminate\Support\Facades\Route;
use App\Models\Book;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\BasicAuthMiddleware;
use App\Http\Controllers\BookController;


Route::get('/', [BookController::class, 'index'])->name('home')->middleware('auth');

Route::get('/library', [BookController::class, 'showLibrary'])->name('library')->middleware('auth');

Route::get('/favorites', [BookController::class, 'showFavs'])->name('favorites')->middleware('auth');

Route::get('/categories', [BookController::class, 'showCategories'])->name('categories')->middleware('auth');

// === BOOK CONTROLLER ===

Route::get('/books/favorite/{bookId}', [BookController::class, 'toggleFavorite'])->name('books.favorite')->middleware('auth');

Route::get('/books/create', function () {
    return view('books.create');
})->name('books.add')->middleware('auth');

Route::post('/books/create', [BookController::class, 'create'])->name('books.add')->middleware('auth');

Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');

Route::get('/books/borrow/{id}', [BookController::class, 'showBorrow'])->name('books.borrow')->middleware('auth');

Route::post('/books/borrow/{id}', [BookController::class, 'borrow'])->name('books.borrow')->middleware('auth');

// === AUTH CONTROLLER ===

// Show registration form
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');

// Handle registration
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Show login form
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Handle login
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Route::resource('books', BookController::class); // DON'T USE
