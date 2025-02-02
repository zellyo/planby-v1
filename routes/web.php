<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;


use App\Models\Project;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard', [
            'projects' => Project::where('user_id', auth()->id())->get(),
        ]);
    })->name('dashboard');

    // Projects
    Route::resource('projects', ProjectController::class);

    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');

    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])
        ->name('projects.destroy');

    Route::get('/projects/{project}/tasks', [TaskController::class, 'index'])
        ->name('projects.tasks.index');


    Route::prefix('projects/{project}')->group(function () {
        // Products
        Route::get('/products', [ProductController::class, 'index'])->name('projects.products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('projects.products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('projects.products.store');
        Route::get('/products/{product}', [ProductController::class, 'show'])->name('projects.products.show');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('projects.products.destroy');
    });

    Route::prefix('projects/{project}/orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('projects.orders.index');
        Route::get('/create', [OrderController::class, 'create'])->name('projects.orders.create');
        Route::post('/', [OrderController::class, 'store'])->name('projects.orders.store');
        Route::get('/{order}', [OrderController::class, 'show'])->name('projects.orders.show');
    });
});

require __DIR__ . '/auth.php';
