<?php

use App\Http\Controllers\ExportController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\ExternalMailController;
use App\Http\Controllers\IncomingMailController;
use App\Http\Controllers\OutgoingMailController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SubTypeController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('/user', UserController::class)->except('create', 'edit');
    Route::post('/user/destroy-bulk', [UserController::class, 'destroyBulk'])->name('user.destroy-bulk');

    Route::resource('/unit', UnitController::class)->except('create', 'edit');
    Route::post('/unit/destroy-bulk', [UnitController::class, 'destroyBulk'])->name('unit.destroy-bulk');

    Route::resource('/type', TypeController::class)->except('create', 'edit');
    Route::post('/type/destroy-bulk', [TypeController::class, 'destroyBulk'])->name('type.destroy-bulk');

    Route::resource('/outgoing-mail', OutgoingMailController::class)->except('create', 'edit');
    Route::post('/outgoing_mail/verifikasi', [OutgoingMailController::class, 'verifikasi'])->name('outgoing-mail.verifikasi');
    Route::post('/outgoing_mail/upload_foto', [OutgoingMailController::class, 'upload_foto']);
    Route::get('/outgoing_mail/attachment/{id}', [OutgoingMailController::class, 'view_attachment']);

    Route::resource('/incoming-mail', IncomingMailController::class)->except('create', 'edit');

    Route::resource('/sub-type', SubTypeController::class)->except('create', 'edit');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/roles', RoleController::class)->except('create', 'show', 'edit');
    Route::post('/role/destroy-bulk', [RoleController::class, 'destroyBulk'])->name('role.destroy-bulk');

    Route::resource('/permission', PermissionController::class)->except('create', 'show', 'edit');
    Route::post('/permission/destroy-bulk', [PermissionController::class, 'destroyBulk'])->name('permission.destroy-bulk');

    Route::prefix('inbox')->name('inbox.')->controller(InboxController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });

    Route::resource('/external-mail', ExternalMailController::class)->except('create', 'edit');
    Route::get('/external-mail/view-file/{id}', [ExternalMailController::class, 'viewFile']);

});

Route::prefix('export')->name('export.')->controller(ExportController::class)->group(function () {
    Route::get('/tte/{mailModel}/{mailId}', 'tte')->name('tte');
    Route::get('/umum/{outgoingMailId}', 'umum')->name('umum');
    Route::get('/{mailModel}/{mailId}', 'show')->name('show');
});

require __DIR__ . '/auth.php';
