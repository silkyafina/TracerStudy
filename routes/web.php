<?php

use App\Http\Controllers\Admin\AlumniController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\LaporanPenggunaController;
use App\Http\Controllers\Admin\ProdiController;
use App\Http\Controllers\Admin\TracerOptionController;
use App\Http\Controllers\Admin\TracerQuestionController;
use App\Http\Controllers\Admin\TracerQuestionItemController;
use App\Http\Controllers\Admin\TracerResultController;
use App\Http\Controllers\Admin\TracerSectionController;
use App\Http\Controllers\Admin\UserSurveyAnswerController;
use App\Http\Controllers\Alumni\DashboardController as AlumniDashboardController;
use App\Http\Controllers\Alumni\ProfilController;
use App\Http\Controllers\Alumni\TracerController;
use App\Http\Controllers\Auth\AlumniAuthController;
use App\Http\Controllers\SurveyPenggunaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
    return view('front.home');
});
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/login', [AuthController::class,'formLogin'])
        ->middleware('admin.guest')
        ->name('login');

    Route::post('/login', [AuthController::class,'login']);

    // 🔥 WAJIB: login dulu
    Route::middleware(['admin'])->group(function () {
        // 🔹 dashboard (biar admin_prodi gak 403)
    Route::get('/dashboard', [DashboardController::class,'index'])
    ->middleware('role:admin,admin_prodi')
    ->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('role:admin,admin_prodi')
    ->name('logout');


    Route::middleware(['admin','role:admin'])->group(function () {
        Route::get('/alumni/create', [AlumniController::class, 'create'])->name('alumni.create');
        Route::post('/alumni', [AlumniController::class, 'store'])->name('alumni.store');
        Route::get('/alumni/{alumni}/edit', [AlumniController::class, 'edit'])->name('alumni.edit');
        Route::put('/alumni/{alumni}', [AlumniController::class, 'update'])->name('alumni.update');
        Route::delete('/alumni/{alumni}', [AlumniController::class, 'destroy'])->name('alumni.destroy');
        Route::get('/alumni/import', [AlumniController::class, 'importForm'])
        ->name('alumni.import.form');
        Route::post('/alumni/import', [AlumniController::class, 'import'])
        ->name('alumni.import');
        Route::get('tracer/import', [TracerResultController::class, 'importForm'])
        ->name('tracer.import.form');
        Route::post('tracer/import', [TracerResultController::class, 'import'])
        ->name('tracer.import');
        Route::get('alumni-export', [AlumniController::class, 'export'])
        ->name('alumni.export');
        Route::resource('tracer-section', TracerSectionController::class)
        ->except(['index','show']);
        Route::resource('tracer-question', TracerQuestionController::class)
        ->except(['index','show']);
        Route::resource('tracer-item', TracerQuestionItemController::class)
        ->except(['index','show']);
        Route::resource('tracer-option', TracerOptionController::class)
        ->except(['index','show']);
        Route::post('/user-survey-answers/import', [UserSurveyAnswerController::class, 'import'])
    ->name('user_survey_answers.import');
    Route::get('user-survey-answers/import', [UserSurveyAnswerController::class, 'importForm'])
        ->name('user_survey_answers.import.form');
    });
    });
    Route::middleware(['admin','role:admin,admin_prodi'])->group(function () {
        Route::get('/alumni/template', [AlumniController::class, 'downloadTemplate'])
    ->name('alumni.template');
        Route::get('/alumni', [AlumniController::class, 'index'])->name('alumni.index');
        Route::get('alumni-export', [AlumniController::class, 'export'])
        ->name('alumni.export');
        Route::get('/alumni/{alumni}', [AlumniController::class, 'show'])->name('alumni.show');
        Route::get('tracer-section', [TracerSectionController::class, 'index'])->name('tracer-section.index');
        Route::get('tracer-section/{id}', [TracerSectionController::class, 'show'])->name('tracer-section.show');
        Route::get('tracer-question', [TracerQuestionController::class, 'index'])->name('tracer-question.index');
        Route::get('tracer-question/{id}', [TracerQuestionController::class, 'show'])->name('tracer-question.show');
        Route::get('tracer-item', [TracerQuestionItemController::class, 'index'])->name('tracer-item.index');
        Route::get('tracer-item/{id}', [TracerQuestionItemController::class, 'show'])->name('tracer-item.show');
        Route::get('tracer-option', [TracerOptionController::class, 'index'])->name('tracer-option.index');
        Route::get('tracer-option/{id}', [TracerOptionController::class, 'show'])->name('tracer-option.show');
        Route::get('/tracer-results', [TracerResultController::class, 'index'])
        ->name('tracer.results.index');
        Route::get('/tracer-results/export', [TracerResultController::class, 'export'])
        ->name('tracer.results.export');
        Route::get('/tracer-results/{alumni}', [TracerResultController::class, 'show'])
        ->name('tracer.results.show');
        Route::get('/laporan', [LaporanController::class, 'index'])
        ->name('laporan.index');
        Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])
        ->name('laporan.export.excel');
        Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])
        ->name('laporan.export.pdf');
        Route::get('/user-survey-answers', [UserSurveyAnswerController::class, 'index'])
        ->name('user_survey_answers.index');
        Route::get('/user-survey-answers/export',[UserSurveyAnswerController::class, 'export']
        )->name('user_survey_answers.export');
        Route::get('/user-survey-answers/{id}', [UserSurveyAnswerController::class, 'show'])
        ->name('user_survey_answers.show');
        Route::get('/laporan-pengguna', [LaporanPenggunaController::class, 'index'])
        ->name('laporan.pengguna.index');
        Route::get('/laporan/pengguna/excel', [LaporanPenggunaController::class, 'exportExcel'])
        ->name('laporan.pengguna.excel');
        Route::get('/laporan/pengguna/pdf', [LaporanPenggunaController::class, 'exportPdf'])
        ->name('laporan.pengguna.pdf');
        Route::resource('prodi', ProdiController::class);
        
    Route::get('/tracer/template', [TracerResultController::class, 'downloadTemplate'])
    ->name('tracer.template');
    });
});


Route::get('/get-kota/{provinsi_id}', [TracerController::class, 'getKota'])
        ->name('get.kota');
Route::prefix('alumni')->name('alumni.')->group(function () {
        Route::get('/login', [AlumniAuthController::class, 'showLogin'])
        ->name('login');

        Route::post('/login', [AlumniAuthController::class, 'login'])
        ->name('login.process');
    // REGISTER
        Route::get('/alumni/register', [AlumniAuthController::class, 'showRegister'])->name('register');
        Route::post('/alumni/register', [AlumniAuthController::class, 'register'])->name('register.process');
        Route::post('/logout', [AlumniAuthController::class, 'logout'])
        ->name('logout');
        
Route::middleware('alumni')->group(function () {
        Route::get('/dashboard', [AlumniDashboardController::class, 'index'])
        ->name('dashboard');
        Route::get('/tracer/section-1', [TracerController::class, 'section1'])
        ->name('tracer.section1');
        Route::post('/tracer/section-1', [TracerController::class, 'storeSection1'])
        ->name('tracer.section1.store');
        Route::get('/tracer/section-2', [TracerController::class, 'section2'])
        ->name('tracer.section2');
        Route::post('/tracer/section-2', [TracerController::class, 'storeSection2'])
        ->name('tracer.section2.store');
        Route::get('/tracer/section-3', [TracerController::class, 'section3'])
        ->name('tracer.section3');
        Route::post('/tracer/section-3', [TracerController::class, 'storeSection3'])
        ->name('tracer.section3.store');
       
        Route::get('/tracer/section-4', [TracerController::class, 'section4'])
        ->name('tracer.section4');
        Route::post('/tracer/section-4', [TracerController::class, 'storeSection4'])
        ->name('tracer.section4.store');
        Route::get('/tracer/section-5', [TracerController::class, 'section5'])
        ->name('tracer.section5');
        Route::post('/tracer/section-5', [TracerController::class, 'storeSection5'])
        ->name('tracer.section5.store');
        Route::get('/tracer/section-6', [TracerController::class, 'section6'])
        ->name('tracer.section6');
        Route::post('/tracer/section-6', [TracerController::class, 'storeSection6'])
        ->name('tracer.section6.store');
        Route::get('/tracer/section-7', [TracerController::class, 'section7'])
        ->name('tracer.section7');
        Route::post('/tracer/section-7', [TracerController::class, 'storeSection7'])
        ->name('tracer.section7.store');
        Route::get('/tracer/section-8', [TracerController::class, 'section8'])
        ->name('tracer.section8');
        Route::post('/tracer/section-8', [TracerController::class, 'storeSection8'])
        ->name('tracer.section8.store');
        Route::get('/tracer/section-9', [TracerController::class, 'section9'])
        ->name('tracer.section9');
        Route::post('/tracer/section-9', [TracerController::class, 'storeSection9'])
        ->name('tracer.section9.store');
        Route::get('/tracer/section-10', [TracerController::class, 'section10'])
        ->name('tracer.section10');
        Route::post('/tracer/section-10', [TracerController::class, 'storeSection10'])
        ->name('tracer.section10.store');
        Route::get('/tracer/section-11', [TracerController::class, 'section11'])
        ->name('tracer.section11');
        Route::post('/tracer/section-11', [TracerController::class, 'storeSection11'])
        ->name('tracer.section11.store');
        Route::get('/tracer/riwayat', [TracerController::class, 'riwayat'])
        ->name('tracer.riwayat');
        Route::get('/tracer/riwayat/{session}', [TracerController::class, 'detailRiwayat'])
        ->name('tracer.riwayat.detail');
        Route::get('/profil', [ProfilController::class, 'index'])
        ->name('profil');
        Route::get('/profil/edit', [ProfilController::class, 'edit'])
        ->name('profil.edit');
        Route::put('/profil', [ProfilController::class, 'update'])
        ->name('profil.update');
        Route::get('/alumni/password', [ProfilController::class, 'editPassword'])
        ->name('password.edit');
    
    Route::post('/alumni/password', [ProfilController::class, 'updatePassword'])
        ->name('password.update');

        });

        });
    Route::get('/survey/pengguna/{token}', [SurveyPenggunaController::class, 'show'])->name('survey.pengguna.show');
    Route::post('/survey/pengguna/{token}', [SurveyPenggunaController::class, 'store'])->name('survey.pengguna.store');

    

Route::get('/test-mail', function () {

    Mail::raw('Email test dari Tracer Study berhasil dikirim.', function ($message) {
        $message->to('silky.afina.saly@gmail.com')
                ->subject('Test Email');
    });

    return 'Mail sent!';
});