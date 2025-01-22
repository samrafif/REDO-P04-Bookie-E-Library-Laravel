<?php

use Illuminate\Support\Facades\Route;
use App\Models\Book;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\BasicAuthMiddleware;
use App\Http\Controllers\BookController;


// === MAIN VIEW CONTROLLER ===

Route::get('/', [BookController::class, 'index'])->name('home')->middleware('auth');

Route::get('/library', [BookController::class, 'showLibrary'])->name('library')->middleware('auth');

Route::get('/favorites', [BookController::class, 'showFavs'])->name('favorites')->middleware('auth');

Route::get('/categories', [BookController::class, 'showCategories'])->name('categories')->middleware('auth');

Route::get('/published', [BookController::class, 'showPublished'])->name('published')->middleware('auth');

// === ADMIN VIEW CONTROLLER ===

Route::get('/admin', function () {
    // NOTE: lol
    if (!(Auth::user()->role == "admin")) return redirect('/');
    return view('admin.main');
})->name('admin.home')->middleware('auth');

Route::get('/admin/users', [AuthController::class, 'index'])->name('admin.users');
Route::get('/admin/users/{id}/edit', [AuthController::class, 'edit'])->name('admin.users.edit');
Route::post('/admin/users/{id}/edit', [AuthController::class, 'update'])->name('admin.users.edit');
Route::delete('/admin/users/{id}', [AuthController::class, 'delete'])->name('admin.users.delete');

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
