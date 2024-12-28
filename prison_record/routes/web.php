<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AccountSettings\UserAccountController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Crimes\CrimeController;
use App\Http\Controllers\DiseasePrisoner\DiseasePrisonerController;
use App\Http\Controllers\EscapePrisoner\EscapePrisonerController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\Prisoner\PrisonerController;
use App\Http\Controllers\PrisonerCrime\CrimePrisonerController;
use App\Http\Controllers\PrisonerMedicalRecord\PrisonerMedicalRecordController;
use App\Http\Controllers\PrisonerParole\PrisonerParoleController;
use App\Http\Controllers\ReleasePrisoner\ReleasePrisonerController;
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\TransfferedPrisoner\TransfferedPrisonerController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\EmployeeMiddleware;
use App\Http\Middleware\SuperAdminMiddleware;
use App\Livewire\ViewFeedBackDetails;
use App\Models\PrisonerMedicalRecord;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('home');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login_user');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');




Route::middleware(['auth', SuperAdminMiddleware::class])->group(function () {

    Route::prefix('/superadmin')->name('superadmin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::prefix('')->group(function () {
            Route::get('/user-image-profile', [UserAccountController::class, 'showUpdateImgPage'])->name('update.photo.show');
            Route::put('/update-profile-upload', [UserAccountController::class, 'updateProfileImage'])->name('update.photo');
            Route::get('/update-account-settings', [UserAccountController::class, 'showUpdateAccountPage'])->name('update.account.show');
            Route::get('/update-account-password', [UserAccountController::class, 'showUpdatePasswordPage'])->name('update.password.show');
        });

        Route::prefix('/prisoners')->name('prisoners.')->group(function () {
            Route::get('/search', [PrisonerController::class, 'search'])->name('search');
            Route::get('/index', [PrisonerController::class, 'index'])->name('index');
            Route::get('/show/{prisoner}', [PrisonerController::class, 'show'])->name('show');
            Route::get('/add-prisoners', [PrisonerController::class, 'showAddingPage'])->name('create');
            Route::get('/update-prisoners/{prisoner}', [PrisonerController::class, 'showEditingPage'])->name('update');
        });

        Route::prefix('/crimes')->name('crimes.')->group(function () {
            Route::get('/crimes-list', [CrimeController::class, 'index'])->name('index');
            Route::get('/add-crime', [CrimeController::class, 'showAddingPage'])->name('create');
            Route::get('/update-crime/{crime}', [CrimeController::class, 'showEditingPage'])->name('update');
            Route::get('/search', [CrimeController::class, 'search'])->name('search');

            Route::get('/prisoner-list', [CrimePrisonerController::class, 'index'])->name('prisoner-crimes.index');
            Route::get('/prisoner-crime-list/{prisoner}', [CrimePrisonerController::class, 'prisonerCrimeIndex'])->name('prisoner-crimes-list.index');
            Route::get('/prisoner-attach-crime/{prisoner}', [CrimePrisonerController::class, 'showAddingPage'])->name('prisoner-crimes.attach');
            Route::get('/prisoner-update-crime/{prisonerCrimeId}', [CrimePrisonerController::class, 'showEdittingPage'])
                ->name('prisoner-crimes.update');
        });

        Route::prefix('/medical-records')->name('medical-records.')->group(function () {
            Route::get('/prisoner-list', [PrisonerMedicalRecordController::class, 'index'])->name('index');
            Route::get('/prisoner-medical-records/{prisoner}', [PrisonerMedicalRecordController::class, 'showPrisonerMedicalRecord'])->name('prisoner-medical-records');
            Route::get('/prisoner-store-medical-record/{prisoner}', [PrisonerMedicalRecordController::class, 'showAddingPage'])->name('create');
            Route::get('/show/{prisonerMedicalRecord}', [PrisonerMedicalRecordController::class, 'showViewingMedicalRecord'])->name('show');
            Route::get('/update/{prisonerMedicalRecord}', [PrisonerMedicalRecordController::class, 'showEditingPage'])->name('update');
        });

        Route::prefix('/prisoner-paroles')->name('prisoner-paroles.')->group(function () {
            Route::get('/prisoner-list', [PrisonerParoleController::class, 'index'])->name('index');
        });

        Route::prefix('/escape-prisoners')->name('escape-prisoners.')->group(function () {
            Route::get('/prisoners-list', [EscapePrisonerController::class, 'index'])->name('index');
        });

        Route::prefix('/disease-prisoners')->name('disease-prisoners.')->group(function () {
            Route::get('/prisoners-list', [DiseasePrisonerController::class, 'index'])->name('index');
        });

        Route::prefix('/transfered-prisoners')->name('transfered-prisoners.')->group(function () {
            Route::get('/prisoners-list', [TransfferedPrisonerController::class, 'index'])->name('index');
        });

        Route::prefix('/released-prisoners')->name('released-prisoners.')->group(function () {
            Route::get('/prisoners-list', [ReleasePrisonerController::class, 'index'])->name('index');
        });

        Route::prefix('/user-management')->name('user-management.')->group(function () {
            Route::get('/user-list', [UserController::class, 'index'])->name('index');
        });

        Route::prefix('audit-logs')->name('audit.')->group(function () {
            Route::get('/index', [AuditController::class, 'index'])->name('index');
            Route::get('/{model}/{id}', [AuditController::class, 'show'])->name('show');
        });

        Route::prefix('/feedbacks')->name('feedbacks.')->group(function () {
            Route::get('/index', [FeedbackController::class, 'index'])->name('index');
            Route::get('/feedback/{feedback}', [FeedbackController::class, 'view'])->name('view');
        });

        Route::prefix('/system-help')->name('help.')->group(function () {
            Route::get('/index', [HelpController::class, 'index'])->name('index');
            Route::get('/create', [HelpController::class, 'showCreatePage'])->name('create');
            Route::get('/show/{help}', [HelpController::class, 'showViewPage'])->name('show');
            Route::get('/update/{help}', [HelpController::class, 'showEditPage'])->name('update');
        });

        Route::prefix('/about-page')->name('about.')->group(function (){
            Route::get('/', [AboutController::class, 'index'])->name('index');
        });
    });
});

Route::middleware(['auth', AdminMiddleware::class])->group(function () {

    Route::prefix('/admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::prefix('')->group(function () {
            Route::get('/user-image-profile', [UserAccountController::class, 'showUpdateImgPage'])->name('update.photo.show');
            Route::put('/update-profile-upload', [UserAccountController::class, 'updateProfileImage'])->name('update.photo');
            Route::get('/update-account-settings', [UserAccountController::class, 'showUpdateAccountPage'])->name('update.account.show');
            Route::get('/update-account-password', [UserAccountController::class, 'showUpdatePasswordPage'])->name('update.password.show');
        });

        Route::prefix('/prisoners')->name('prisoners.')->group(function () {
            Route::get('/search', [PrisonerController::class, 'search'])->name('search');
            Route::get('/index', [PrisonerController::class, 'index'])->name('index');
            Route::get('/show/{prisoner}', [PrisonerController::class, 'show'])->name('show');
            Route::get('/add-prisoners', [PrisonerController::class, 'showAddingPage'])->name('create');
            Route::get('/update-prisoners/{prisoner}', [PrisonerController::class, 'showEditingPage'])->name('update');
        });

        Route::prefix('/crimes')->name('crimes.')->group(function () {
            Route::get('/crimes-list', [CrimeController::class, 'index'])->name('index');
            Route::get('/add-crime', [CrimeController::class, 'showAddingPage'])->name('create');
            Route::get('/update-crime/{crime}', [CrimeController::class, 'showEditingPage'])->name('update');
            Route::get('/search', [CrimeController::class, 'search'])->name('search');

            Route::get('/prisoner-list', [CrimePrisonerController::class, 'index'])->name('prisoner-crimes.index');
            Route::get('/prisoner-crime-list/{prisoner}', [CrimePrisonerController::class, 'prisonerCrimeIndex'])->name('prisoner-crimes-list.index');
            Route::get('/prisoner-attach-crime/{prisoner}', [CrimePrisonerController::class, 'showAddingPage'])->name('prisoner-crimes.attach');
            Route::get('/prisoner-update-crime/{prisonerCrimeId}', [CrimePrisonerController::class, 'showEdittingPage'])
                ->name('prisoner-crimes.update');
        });

        Route::prefix('/medical-records')->name('medical-records.')->group(function () {
            Route::get('/prisoner-list', [PrisonerMedicalRecordController::class, 'index'])->name('index');
            Route::get('/prisoner-medical-records/{prisoner}', [PrisonerMedicalRecordController::class, 'showPrisonerMedicalRecord'])->name('prisoner-medical-records');
            Route::get('/prisoner-store-medical-record/{prisoner}', [PrisonerMedicalRecordController::class, 'showAddingPage'])->name('create');
            Route::get('/show/{prisonerMedicalRecord}', [PrisonerMedicalRecordController::class, 'showViewingMedicalRecord'])->name('show');
            Route::get('/update/{prisonerMedicalRecord}', [PrisonerMedicalRecordController::class, 'showEditingPage'])->name('update');
        });

        Route::prefix('/prisoner-paroles')->name('prisoner-paroles.')->group(function () {
            Route::get('/prisoner-list', [PrisonerParoleController::class, 'index'])->name('index');
        });

        Route::prefix('/escape-prisoners')->name('escape-prisoners.')->group(function () {
            Route::get('/prisoners-list', [EscapePrisonerController::class, 'index'])->name('index');
        });

        Route::prefix('/disease-prisoners')->name('disease-prisoners.')->group(function () {
            Route::get('/prisoners-list', [DiseasePrisonerController::class, 'index'])->name('index');
        });

        Route::prefix('/transfered-prisoners')->name('transfered-prisoners.')->group(function () {
            Route::get('/prisoners-list', [TransfferedPrisonerController::class, 'index'])->name('index');
        });

        Route::prefix('/released-prisoners')->name('released-prisoners.')->group(function () {
            Route::get('/prisoners-list', [ReleasePrisonerController::class, 'index'])->name('index');
        });

        Route::prefix('/user-management')->name('user-management.')->group(function () {
            Route::get('/user-list', [UserController::class, 'index'])->name('index');
        });

        Route::prefix('audit-logs')->name('audit.')->group(function () {
            Route::get('/index', [AuditController::class, 'index'])->name('index');
            Route::get('/{model}/{id}', [AuditController::class, 'show'])->name('show');
        });

        Route::prefix('/feedbacks')->name('feedbacks.')->group(function () {
            Route::get('/submit-feedback', [FeedbackController::class, 'index'])->name('index');
        });

        Route::prefix('/system-help')->name('help.')->group(function () {
            Route::get('/index', [HelpController::class, 'index'])->name('index');
            Route::get('/show/{help}', [HelpController::class, 'showViewPage'])->name('show');
        });

        Route::prefix('/about-page')->name('about.')->group(function (){
            Route::get('/', [AboutController::class, 'index'])->name('index');
        });
    });
});

Route::middleware(['auth', EmployeeMiddleware::class])->group(function () {

    Route::prefix('/employee')->name('employee.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::prefix('')->group(function () {
            Route::get('/user-image-profile', [UserAccountController::class, 'showUpdateImgPage'])->name('update.photo.show');
            Route::put('/update-profile-upload', [UserAccountController::class, 'updateProfileImage'])->name('update.photo');
            Route::get('/update-account-settings', [UserAccountController::class, 'showUpdateAccountPage'])->name('update.account.show');
            Route::get('/update-account-password', [UserAccountController::class, 'showUpdatePasswordPage'])->name('update.password.show');
        });

        Route::prefix('/prisoners')->name('prisoners.')->group(function () {
            Route::get('/search', [PrisonerController::class, 'search'])->name('search');
            Route::get('/index', [PrisonerController::class, 'index'])->name('index');
            Route::get('/show/{prisoner}', [PrisonerController::class, 'show'])->name('show');
            Route::get('/add-prisoners', [PrisonerController::class, 'showAddingPage'])->name('create');
            Route::get('/update-prisoners/{prisoner}', [PrisonerController::class, 'showEditingPage'])->name('update');
        });

        Route::prefix('/crimes')->name('crimes.')->group(function () {
            Route::get('/prisoner-list', [CrimePrisonerController::class, 'index'])->name('prisoner-crimes.index');
            Route::get('/prisoner-crime-list/{prisoner}', [CrimePrisonerController::class, 'prisonerCrimeIndex'])->name('prisoner-crimes-list.index');
            Route::get('/prisoner-attach-crime/{prisoner}', [CrimePrisonerController::class, 'showAddingPage'])->name('prisoner-crimes.attach');
            Route::get('/prisoner-update-crime/{prisonerCrimeId}', [CrimePrisonerController::class, 'showEdittingPage'])
                ->name('prisoner-crimes.update');
        });

        Route::prefix('/medical-records')->name('medical-records.')->group(function () {
            Route::get('/prisoner-list', [PrisonerMedicalRecordController::class, 'index'])->name('index');
            Route::get('/prisoner-medical-records/{prisoner}', [PrisonerMedicalRecordController::class, 'showPrisonerMedicalRecord'])->name('prisoner-medical-records');
            Route::get('/prisoner-store-medical-record/{prisoner}', [PrisonerMedicalRecordController::class, 'showAddingPage'])->name('create');
            Route::get('/show/{prisonerMedicalRecord}', [PrisonerMedicalRecordController::class, 'showViewingMedicalRecord'])->name('show');
            Route::get('/update/{prisonerMedicalRecord}', [PrisonerMedicalRecordController::class, 'showEditingPage'])->name('update');
        });

        Route::prefix('/prisoner-paroles')->name('prisoner-paroles.')->group(function () {
            Route::get('/prisoner-list', [PrisonerParoleController::class, 'index'])->name('index');
        });

        Route::prefix('/escape-prisoners')->name('escape-prisoners.')->group(function () {
            Route::get('/prisoners-list', [EscapePrisonerController::class, 'index'])->name('index');
        });

        Route::prefix('/disease-prisoners')->name('disease-prisoners.')->group(function () {
            Route::get('/prisoners-list', [DiseasePrisonerController::class, 'index'])->name('index');
        });

        Route::prefix('/transfered-prisoners')->name('transfered-prisoners.')->group(function () {
            Route::get('/prisoners-list', [TransfferedPrisonerController::class, 'index'])->name('index');
        });

        Route::prefix('/released-prisoners')->name('released-prisoners.')->group(function () {
            Route::get('/prisoners-list', [ReleasePrisonerController::class, 'index'])->name('index');
        });

        Route::prefix('/feedbacks')->name('feedbacks.')->group(function () {
            Route::get('/submit-feedback', [FeedbackController::class, 'index'])->name('index');
        });

        Route::prefix('/system-help')->name('help.')->group(function () {
            Route::get('/index', [HelpController::class, 'index'])->name('index');
            Route::get('/show/{help}', [HelpController::class, 'showViewPage'])->name('show');
        });

        Route::prefix('/about-page')->name('about.')->group(function (){
            Route::get('/', [AboutController::class, 'index'])->name('index');
        });
    });
});
