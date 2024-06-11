<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;

use App\Http\Controllers\Admin\ManageStudentController;
use App\Http\Controllers\Admin\ManageCounsellorController;
use App\Http\Controllers\Admin\ManagePsychologistController;

use App\Http\Controllers\CounsellorController;
use App\Http\Controllers\Counsellor\CounsellorAssessmentController;
use App\Http\Controllers\Counsellor\AssessmentSettingController;
use App\Http\Controllers\Counsellor\CaseController;

use App\Http\Controllers\Auth\StudentForgotPasswordController;
use App\Http\Controllers\Auth\StudentResetPasswordController;

use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentAuth\StudentLoginController;
use App\Http\Controllers\ResultController;


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
    return redirect()->route('login');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        // Check the user's role and redirect accordingly
        if (auth()->user()->role === 'admin') {
            // If the user is an admin
            return redirect()->route('admin.manage-students');
        } elseif (auth()->user()->role === 'counsellor') {
            // If the user is a counsellor
            return redirect()->route('counsellor.assessment');
        } else {
            // Handle other roles or show an error
            return abort(403, 'Unauthorized');
        }
    })->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/admin/manage-students', [ManageStudentController::class, 'getStudentList'])->name('admin.manage-students');
        Route::get('/admin/student-form', [ManageStudentController::class, 'getStudentForm'])->name('admin.student-form');
        Route::post('/admin/add-student', [ManageStudentController::class, 'postAddStudent'])->name('admin.add-student');
        Route::get('/admin/edit-student-form/{ic}', [ManageStudentController::class, 'getEditStudent'])->name('admin.edit-student-form');
        Route::put('/admin/edit-student/{ic}', [ManageStudentController::class, 'putEditStudent'])->name('admin.edit-student');
        Route::delete('/admin/delete-student/{ic}', [ManageStudentController::class, 'deleteStudent'])->name('admin.delete-student');

        Route::get('/admin/manage-counsellors', [ManageCounsellorController::class, 'getCounsellorList'])->name('admin.manage-counsellors');
        Route::get('/admin/counsellor-form', [ManageCounsellorController::class, 'getCounsellorForm'])->name('admin.counsellor-form');
        Route::post('/admin/add-counsellor', [ManageCounsellorController::class, 'postAddCounsellor'])->name('admin.add-counsellor');
        Route::get('/admin/edit-counsellor-form/{ic}', [ManageCounsellorController::class, 'getEditCounsellor'])->name('admin.edit-counsellor-form');
        Route::put('/admin/edit-counsellor/{ic}', [ManageCounsellorController::class, 'putEditCounsellor'])->name('admin.edit-counsellor');
        Route::delete('/admin/delete-counsellor/{ic}', [ManageCounsellorController::class, 'deleteCounsellor'])->name('admin.delete-counsellor');

        Route::get('/admin/manage-psychologists', [ManagePsychologistController::class, 'getPsychologistList'])->name('admin.manage-psychologists');
        Route::get('/admin/psychologist-form', [ManagePsychologistController::class, 'getPsychologistForm'])->name('admin.psychologist-form');
        Route::post('/admin/add-psychologist', [ManagePsychologistController::class, 'postAddPsychologist'])->name('admin.add-psychologist');
        Route::get('/admin/edit-psychologist-form/{id}', [ManagePsychologistController::class, 'getEditPsychologist'])->name('admin.edit-psychologist-form');
        Route::put('/admin/edit-psychologist/{id}', [ManagePsychologistController::class, 'putEditPsychologist'])->name('admin.edit-psychologist');
        Route::delete('/admin/delete-psychologist/{id}', [ManagePsychologistController::class, 'deletePsychologist'])->name('admin.delete-psychologist');
    });

    /* ------- Counsellor Route -------*/
    Route::middleware('auth')->group(function () {
        Route::get('/counsellor/assessment', [CounsellorAssessmentController::class, 'getQuestionList'])->name('counsellor.assessment');
        Route::get('/counsellor/add-question', [CounsellorAssessmentController::class, 'getQuestionForm'])->name('counsellor.add-question');
        Route::post('/counsellor/add-question', [CounsellorAssessmentController::class, 'postAddQuestion'])->name('counsellor.post-add-question');
        Route::get('/counsellor/edit-question/{question}', [CounsellorAssessmentController::class, 'getEditQuestion'])->name('counsellor.edit-question');
        Route::put('/counsellor/edit-question/{question}', [CounsellorAssessmentController::class, 'putEditQuestion'])->name('counsellor.put-edit-question');
        Route::delete('/counsellor/delete-question/{question}', [CounsellorAssessmentController::class, 'deleteQuestion'])->name('counsellor.delete-question');
        Route::post('/counsellor/assessment/toggle', [CounsellorAssessmentController::class, 'toggleAssessment'])->name('counsellor.assessment.toggle');
        Route::get('/counsellor/dashboard', [CounsellorController::class, 'dashboard'])->name('counsellor.dashboard');
        Route::get('/counsellor/case-management', [CounsellorController::class, 'case'])->name('counsellor.case-management');
        Route::get('/counsellor/screening-score-reference', [CounsellorController::class, 'screeningScoreReference'])->name('counsellor.screening-score-reference');
        Route::get('/counsellor/unanswered', [CaseController::class, 'unanswered'])->name('counsellor.unanswered');
        Route::get('/counsellor/passed', [CaseController::class, 'passed'])->name('counsellor.passed');
        Route::get('/counsellor/intervention', [CaseController::class, 'intervention'])->name('counsellor.intervention');
        Route::post('/counsellor/update-intervention-date', [CaseController::class, 'updateInterventionDate'])->name('counsellor.update-intervention-date');
        Route::post('/counsellor/update-allow-second-assessment', [CaseController::class, 'updateAllowSecondAssessment'])->name('counsellor.update-allow-second-assessment');
        Route::get('/counsellor/second_passed', [CaseController::class, 'secondPassed'])->name('counsellor.secondPassed');
        Route::get('/counsellor/second_intervention', [CaseController::class, 'secondIntervention'])->name('counsellor.secondIntervention');
        Route::get('/counsellor/select-psychologist/{student_ic}', [CaseController::class, 'selectPsychologist'])->name('counsellor.selectPsychologist');
        Route::post('/counsellor/generate-pdf', [CaseController::class, 'generatePdf'])->name('counsellor.generatePdf');
    /* ---- End of counsellor Route ----*/
    });
});

Route::middleware('auth')->group(function () {
    // Route to show the password update form
    Route::get('/profile/update-password', [ProfileController::class, 'showUpdatePasswordForm'])->name('profile.update-password-form');  
    Route::put('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
});

require __DIR__.'/auth.php';

/* ------- Student Route -------*/
Route::prefix('student')->group(function (){
    Route::get('/login', [StudentLoginController::class, 'showLoginForm'])->name('student.login');
    Route::post('/login', [StudentLoginController::class, 'login'])->name('student.login.submit');
    Route::post('/logout', [StudentLoginController::class, 'logout'])->name('student.logout');
    Route::get('/home', [StudentController::class, 'index'])->name('student.home');
    Route::get('/assessment', [StudentController::class, 'assessment'])->name('student.assessment');
    Route::post('/submit-assessment', [StudentController::class, 'submitAssessment'])->name('submit-assessment');
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
});

Route::middleware(['auth:student'])->group(function () {
    Route::get('/student/profile/update-password', [StudentProfileController::class, 'showUpdatePasswordForm'])->name('student.profile.update-password-form');
    Route::put('/student/profile/update-password', [StudentProfileController::class, 'updatePassword'])->name('student.profile.update-password');
});

// Password Reset Routes for Students...
Route::get('student/password/reset', [StudentForgotPasswordController::class, 'showLinkRequestForm'])->name('student.password.request');
Route::post('student/password/email', [StudentForgotPasswordController::class, 'sendResetLinkEmail'])->name('student.password.email');
Route::get('student/password/reset/{token}', [StudentResetPasswordController::class, 'showResetForm'])->name('student.password.reset');
Route::post('student/password/reset', [StudentResetPasswordController::class, 'reset'])->name('student.password.update');

// Password Reset Routes for Students...
Route::get('student/password/reset', [StudentForgotPasswordController::class, 'showLinkRequestForm'])->name('student.password.request');
Route::post('student/password/email', [StudentForgotPasswordController::class, 'sendResetLinkEmail'])->name('student.password.email');
Route::get('student/password/reset/{token}', [StudentResetPasswordController::class, 'showResetForm'])->name('student.password.reset');
Route::post('student/password/reset', [StudentResetPasswordController::class, 'reset'])->name('student.password.update');

Route::get('password/reset', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('password/email', [PasswordResetLinkController::class, 'store'])->name('password.email');
Route::get('password/reset/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('password/reset', [NewPasswordController::class, 'store'])->name('password.update');
/* ----- End Student Route -----*/