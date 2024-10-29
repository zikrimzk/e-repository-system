<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\StaffAuth\AuthenticatedSessionController;

Route::middleware('guest:staff')->group(function () {

    Route::get('staff/login', [AuthenticatedSessionController::class, 'index'])->name('staff.login');
    Route::post('loginstaff', [AuthenticatedSessionController::class, 'login'])->name('loginStaff');
    Route::get('staff/forgot-password', [PasswordResetLinkController::class, 'create'])->name('staff.password.request');
    Route::post('staff/forgot-password', [PasswordResetLinkController::class, 'store'])->name('staff.password.email');

    
});

Route::middleware('auth:staff')->group(function () {
    Route::post('staff/logout', [AuthenticatedSessionController::class, 'logout'])->name('staff.logout');
});





























// use App\Http\Controllers\StaffAuth\ConfirmablePasswordController;
// use App\Http\Controllers\StaffAuth\EmailVerificationNotificationController;
// use App\Http\Controllers\StaffAuth\EmailVerificationPromptController;
// use App\Http\Controllers\StaffAuth\NewPasswordController;
// use App\Http\Controllers\StaffAuth\PasswordController;
// use App\Http\Controllers\StaffAuth\PasswordResetLinkController;
// use App\Http\Controllers\StaffAuth\VerifyEmailController;

 // Route::get('staff/forgot-password', [PasswordResetLinkController::class, 'create'])
    //             ->name('staff.password.request');

    // Route::post('staff/forgot-password', [PasswordResetLinkController::class, 'store'])
    //             ->name('staff.password.email');

    // Route::get('staff/reset-password/{token}', [NewPasswordController::class, 'create'])
    //             ->name('staff.password.reset');

    // Route::post('staff/reset-password', [NewPasswordController::class, 'store'])
    //             ->name('staff.password.store');
    
    // Route::get('staff/verify-email', EmailVerificationPromptController::class)
    //             ->name('staff.verification.notice');

    // Route::get('staff/verify-email/{id}/{hash}', VerifyEmailController::class)
    //             ->middleware(['signed', 'throttle:6,1'])
    //             ->name('staff.verification.verify');

    // Route::post('staff/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    //             ->middleware('throttle:6,1')
    //             ->name('staff.verification.send');

    // Route::get('staff/confirm-password', [ConfirmablePasswordController::class, 'show'])
    //             ->name('staff.password.confirm');

    // Route::post('staff/confirm-password', [ConfirmablePasswordController::class, 'store']);

    // Route::put('staff/password', [PasswordController::class, 'update'])->name('staff.password.update');
