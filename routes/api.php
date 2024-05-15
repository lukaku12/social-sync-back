<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('email/verify/{id}', [EmailVerificationController::class, 'verify'])->name('verification.verify');

Route::group(['middleware' => 'guest'], function () {
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('login', [AuthController::class, 'login'])->name('login');

    Route::post('forget-password', [PasswordResetController::class, 'submitForgetPasswordForm'])->name('password.forget');
    Route::post('reset-password', [PasswordResetController::class, 'submitResetPasswordForm'])->name('password.reset');
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('user', [UserController::class, 'index']);

    Route::get('contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::post('contacts', [ContactController::class, 'store'])->name('contacts.store');

    Route::get('conversations', [ConversationController::class, 'index'])->name('conversations.index');
    //    Route::post('conversations', [ConversationController::class, 'store'])->name('conversations.store');
    Route::get('conversations/{id}', [ConversationController::class, 'show'])->name('conversations.show');

    Route::get('conversations/{uuid}/messages', [ConversationController::class, 'messages'])->name('conversations.messages.get');
    Route::post('conversations/{uuid}/messages', [ConversationController::class, 'storeMessage'])->name('conversations.messages.store');

    //    Route::get('messages', [MessageController::class, 'index'])->name('messages.index');
    //    Route::post('messages', [MessageController::class, 'store'])->name('messages.store');
    //    Route::get('messages/{id}', [MessageController::class, 'view'])->name('messages.view');

});
