<?php

use App\Http\Controllers\HomepageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KandidatController;
use App\Http\Controllers\VotingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/homepage', [HomepageController::class, 'index'])->name('homepage');

Route::get('/auth', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Semua route di bawah ini hanya bisa diakses jika sudah login
Route::middleware(['auth'])->group(function () {

    // Route khusus untuk admin
    Route::middleware(['isAdmin'])->group(function () {
        //users normal
        Route::resource('users', UserController::class);
        Route::post('user-update-role', [UserController::class, 'updateRole'])->name('users.update-role');
        Route::get('/chart-data', [App\Http\Controllers\VotingController::class, 'chartData']);
        //user realtime
        Route::get('/user-data', [UserController::class, 'getUserData']);

        // Voting normal
        Route::get('/voting', [VotingController::class, 'index'])->name('voting.index');
        // voting realtime
        Route::get('/voting-data', [VotingController::class, 'getVotingData']);
        Route::delete('/voting/{id}', [VotingController::class, 'destroy'])->name('voting.destroy');
        
        Route::resource('kandidat', KandidatController::class);
    });
    Route::post('/voting', [VotingController::class, 'store'])->name('voting.store');
    
    // Route kandidat & voting untuk semua user login
    Route::get('/kandidat', [KandidatController::class, 'index'])->name('kandidat.index');

    // Profile Route
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    //homepage 
    // Route::get('/getdata', function () {
    //     $kandidats = \App\Models\Kandidat::withCount('votings')->get();
    //     return response()->json($kandidats);
    // });






});
