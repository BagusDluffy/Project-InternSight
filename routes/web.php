<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MuridController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\DudikaController;
use App\Http\Controllers\MagangController;
use App\Http\Controllers\LaporanController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Middleware Guest (Belum Login)
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [HomeController::class, 'login'])->name('login');
    Route::post('/login', [HomeController::class, 'dologin'])->name('dologin');
    Route::get('/register', [HomeController::class, 'register'])->name('register');
    Route::post('/register', [HomeController::class, 'doregister'])->name('doregister');
});

// Middleware Auth (Sudah Login)
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('home', [HomeController::class, 'index'])->name('home');

    // Profile Routes
    Route::prefix('profile')->group(function () {
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/update', [ProfileController::class, 'update'])->name('profile.update');
    });

    // Guru Routes
    Route::prefix('guru')->group(function () {
        Route::post('/import', [GuruController::class, 'import'])->name('guru.import');
    });
    Route::resource('guru', GuruController::class);

    Route::prefix('dudika')->group(function () {
        Route::post('/import', [DudikaController::class, 'import'])->name('dudika.import');
    });

    Route::prefix('murid')->group(function () {
        Route::post('/import', [MuridController::class, 'import'])->name('murid.import');
    });

    Route::prefix('jurusan')->group(function () {
        Route::post('/import', [JurusanController::class, 'import'])->name('jurusan.import');
    });

    // Resource Routes
    Route::resources([
        'jurusan' => JurusanController::class,
        'dudika' => DudikaController::class,
        'murid' => MuridController::class,
        'magang' => MagangController::class,
    ]);
    Route::resource('magang', MagangController::class)->except(['show']);

    // Custom Routes
    Route::get('/get-murid', [MagangController::class, 'getMurid'])->name('get.murid');
    Route::delete('/magang/{magang}', [MagangController::class, 'destroy'])->name('magang.destroy');
    Route::get('/magang/{magang}/edit', [MagangController::class, 'edit'])->name('magang.edit');
    Route::post('/magang/{id}/laporan', [MagangController::class, 'uploadLaporan']);
    Route::get('/magang/{magang}/print-data', [MagangController::class, 'getPrintData'])->name('magang.print-data');
    Route::get('/magang/export', [MagangController::class, 'export'])->name('magang.export');

    // Laporan Routes
    Route::post('/laporan', [LaporanController::class, 'store']);

    // Logout
    Route::get('/logout', [HomeController::class, 'logout'])->name('logout');
});

// Development/Testing Routes (Sebaiknya dihapus di production)
Route::get('/teskon', [HomeController::class, 'testcon']);
