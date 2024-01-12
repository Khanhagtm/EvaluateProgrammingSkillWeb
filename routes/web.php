<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProblemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CodeExecutorController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['checkUserRole'])->group(function () {
    Route::get('app/create', [ProblemController::class, 'create'])->name('create');
    Route::put('/app/update/{id}', [ProblemController::class, 'update']);
    Route::get('/app/edit/{id}', [ProblemController::class, 'edit']);
    Route::delete('/app/delete/{id}', [ProblemController::class, 'destroy']);
});

Route::get('/app', function () {
    return view('test');
});
Route::get('/app/assign}', [ProblemController::class, 'assignedProblems'])->name('assignment');
Route::get('/app/exam', [ProblemController::class, 'index'])->name('exam');
Route::get('execute-code', function () {
    return view('userSubmitCode');
});
Route::post('execute-code', [CodeExecutorController::class, 'executeCode']);
// Route::resource('problems', 'ProblemController')->except(['create', 'edit', 'destroy']);
Route::post('/post', [ProblemController::class, 'store']);
Route::get('/app/show/{id}', [ProblemController::class, 'show']);
Route::match(['get', 'post'], '/problems/search', [ProblemController::class, 'search'])->name('problems.search');

// Routes for admin (CheckUserRole middleware applied)


