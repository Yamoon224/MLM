<?php

use App\Http\Controllers\AccountRenewalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MatrixTreeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WithdrawalController;
use App\Http\Controllers\Admin\WithdrawalController as AdminWithdrawalController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified', 'account.active'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Renouvellement de compte (accessible même si compte inactif)
    Route::get('/account/expired', [AccountRenewalController::class, 'show'])->name('account.renewal.show');
    Route::post('/account/renew', [AccountRenewalController::class, 'store'])->name('account.renewal.store');
});

Route::middleware(['auth', 'account.active'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// L'arbre matriciel reste accessible même si le compte est expiré (la position ne disparaît pas)
Route::middleware('auth')->group(function () {
    Route::get('/matrix/tree', [MatrixTreeController::class, 'index'])->name('matrix.tree');
    Route::get('/matrix/tree/{userId}', [MatrixTreeController::class, 'show'])->name('matrix.tree.node');
});

// Gestion des retraits – utilisateur
Route::middleware(['auth', 'account.active'])->group(function () {
    Route::get('/wallet/withdraw', [WithdrawalController::class, 'create'])->name('wallet.withdraw');
    Route::post('/wallet/withdraw', [WithdrawalController::class, 'store'])->name('wallet.withdraw.store');
    Route::get('/wallet/history', [WithdrawalController::class, 'history'])->name('wallet.history');
});

// Gestion des retraits – admin
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/withdrawals', [AdminWithdrawalController::class, 'index'])->name('admin.withdrawals.index');
    Route::post('/withdrawals/{withdrawal}/approve', [AdminWithdrawalController::class, 'approve'])->name('admin.withdrawals.approve');
    Route::post('/withdrawals/{withdrawal}/reject', [AdminWithdrawalController::class, 'reject'])->name('admin.withdrawals.reject');
});

require __DIR__.'/auth.php';
