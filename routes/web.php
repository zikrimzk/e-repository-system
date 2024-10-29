<?php

use App\Models\Staff;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\ProgrammeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\NominationController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\MySupervisionController;
use App\Http\Controllers\StudentManagementController;

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





 



/*-------Staff Route ------- */
Route::get('/staff', function () {
    return redirect()->route('staff.login');
});
Route::prefix('staff')->group(function () {
    //RESET PASSWORD
    Route::get('/reset-password', [StaffController::class,'indexResetPasswordRequest'])->name('staffResetPasswordRequest');
    Route::get('/email-sent-reset-password-{id}', [StaffController::class,'indexResetPassword'])->name('staffResetPasswordSent');


    //POST
    Route::post('/reset-password-mail-sent', [StaffController::class,'resetPasswordMail'])->name('resetStaffPasswordMail');
    Route::post('/email-sent-reset-password-post{id}', [StaffController::class,'resetPassword'])->name('resetStaffPassword');

});
Route::prefix('staff')->middleware('auth:staff')->group(function () {
    //STAFF MANAGEMENT
    Route::get('/dashboard', [StaffController::class,'index'])->name('staffHome');
    Route::get('/staff-management', [StaffController::class,'gotoStaffManagement'])->name('staffManagement');
    Route::get('/register', [StaffController::class,'gotoStaffRegistration'])->name('staffAdd');
    Route::get('/update-staff-{id}', [StaffController::class,'gotoUpdate'])->name('staffUpdate');
    Route::get('/staff-list-excel-export', [StaffController::class,'exportStaff'])->name('staffListExport');
    Route::get('/excel-export-template-staff', [StaffController::class,'exportStaffTemplate'])->name('staffExportTemplate');
    Route::get('/profile', [StaffController::class,'indexProfile'])->name('staffProfile');
    Route::get('/profile-edit', [StaffController::class,'indexProfileEdit'])->name('staffProfileEdit');
    
    //POST
    Route::post('/register-post', [StaffController::class,'Registration'])->name('staffPost');
    Route::post('/update-post', [StaffController::class,'Update'])->name('staffUpdatePost');
    Route::get('/delete-{id}', [StaffController::class,'Delete'])->name('staffDeletePost');
    Route::post('/excel-import', [StaffController::class,'importStaff'])->name('staffImport');
    Route::post('/profile-update-post{id}', [StaffController::class,'UpdateProfile'])->name('staffProfileUpdatePost');
    Route::post('/profile-update-password-post{id}', [StaffController::class,'UpdatePassword'])->name('staffProfileUpdatePasswordPost');


    //SEMESTER SETTING
    Route::get('/semester', [SemesterController::class,'index'])->name('semesterManagement');
    Route::get('/semester-add', [SemesterController::class,'gotoSemesterAdd'])->name('semesterAdd');
    Route::get('/update-semester-{id}', [SemesterController::class,'gotoUpdate'])->name('semesterUpdate');
    Route::get('/remove-semester-{id}', [SemesterController::class,'DeleteSemester'])->name('semesterDelete');


    //POST
    Route::post('/semester-post', [SemesterController::class,'Add'])->name('semesterPost');
    Route::post('/update-semester', [SemesterController::class,'Update'])->name('semesterUpdatePost');
    Route::post('/current-semester', [SemesterController::class,'CurrentSemester'])->name('semCurrentPost');


    //PROGRAMME SETTING
    Route::get('/programme', [ProgrammeController::class,'index'])->name('programmeManagement');
    Route::get('/programme-add', [ProgrammeController::class,'gotoProgrammeAdd'])->name('programmeAdd');
    Route::get('/update-programme-{id}', [ProgrammeController::class,'gotoUpdate'])->name('programmeUpdate');
    Route::get('/delete-programme-{id}', [ProgrammeController::class,'Delete'])->name('programmeDelete');



    //POST 
    Route::post('/programme-post', [ProgrammeController::class,'Add'])->name('programmePost');
    Route::post('/update-programme-{id}', [ProgrammeController::class,'Update'])->name('programmeUpdatePost');

    //FACULTY SETTING
    Route::get('/faculty', [FacultyController::class,'index'])->name('facultySetting');
    Route::get('/faculty-delete-{id}', [FacultyController::class,'Delete'])->name('facDelete');


    //POST
    Route::post('/faculty-post', [FacultyController::class,'Add'])->name('facAddPost');
    Route::post('/faculty-update-post{id}', [FacultyController::class,'Update'])->name('facUpdatePost');


    // DEPARTMENT SETTING
    Route::get('/department', [DepartmentController::class,'index'])->name('departmentSetting');
    Route::get('/department-delete-{id}', [DepartmentController::class,'Delete'])->name('depDelete');

    //POST
    Route::post('/department-post', [DepartmentController::class,'Add'])->name('depAddPost');
    Route::post('/department-update-post{id}', [DepartmentController::class,'Update'])->name('depUpdatePost');




    //STUDENT MANAGEMENT
    Route::get('/student-management', [StudentController::class,'index'])->name('studentManagement');
    Route::get('/student-add', [StudentController::class,'gotoStudentAdd'])->name('studentAdd');
    Route::get('/update-student-{id}', [StudentController::class,'gotoUpdate'])->name('studentUpdate');
    Route::get('/student-excel-export', [StudentController::class,'exportStudent'])->name('studentExport');
    Route::get('/student-excel-export-template-student', [StudentController::class,'exportStudentTemplate'])->name('studentExportTemplate');
    Route::get('/register-student-submission-{id}', [StudentController::class,'submissionRegister'])->name('studentSubPost');


    //POST
    Route::post('/student-management', [StudentController::class,'index'])->name('studentManagements');
    Route::post('/register-student-post', [StudentController::class,'Registration'])->name('studentPost');
    Route::post('/update-student', [StudentController::class,'Update'])->name('studentUpdatePost');
    Route::get('/remove-student-{id}', [StudentController::class,'Remove'])->name('removeStudent');
    Route::post('/student-excel-import', [StudentController::class,'importStudent'])->name('studentImport');

    //STUDENT SUPERVISION
    Route::get('/student-supervision', [StudentController::class,'gotoSupervision'])->name('studentSupervision');
    Route::get('/student-supervision-excel-export', [StudentController::class,'exportSupervision'])->name('stustaExport');
    Route::get('/student-supervision-remove-{stud}{sta}', [StudentController::class,'SupervisionRemove'])->name('removeSupervision');

    
    //POST
    Route::post('/student-supervisor-post', [StudentController::class,'Supervision'])->name('studentSupervisionPost');
    Route::post('/student-supervisor-update-post', [StudentController::class,'SupervisionUpdate'])->name('studentSupervisionUpdatePost');
    Route::post('/student-title-update-post', [StudentController::class,'TitleUpdate'])->name('studentTitleUpdatePost');

    Route::post('/student-supervisor-excel-import', [StudentController::class,'importSupervision'])->name('stustaImport');


    //ACTIVITY & PROCEDURE SETTING 
    Route::get('/activity', [ActivityController::class,'index'])->name('activitySetting');
    Route::get('/procedure', [ActivityController::class,'indexProcedure'])->name('procedureManagement');
    Route::get('/materialDownload-{act}-{prog}', [ActivityController::class,'downloadsMaterial'])->name('materialDownAct');
    Route::get('/activity-delete-{id}-post', [ActivityController::class,'Delete'])->name('activityDeletePost');

    //POST
    Route::post('/activity-post', [ActivityController::class,'Add'])->name('activityAddPost');
    Route::post('/activity-update-post', [ActivityController::class,'Update'])->name('activityUpdatePost');
    Route::post('/procedure-post', [ActivityController::class,'AddProcedure'])->name('proAddPost');
    Route::post('/procedure-update-post', [ActivityController::class,'UpdateProcedure'])->name('proUpdatePost');
    Route::get('/procedure-delete-post-{act}-{prog}', [ActivityController::class,'DeleteProcedure'])->name('proDeletePost');

    //FORM SETTING
    Route::get('/form', [FormController::class,'index'])->name('formSetting');
    Route::get('/form-delete-post-{id}', [FormController::class,'removeForm'])->name('formDeletePost');


     //POST
    Route::post('/form-post', [FormController::class,'addForm'])->name('formAddPost');
    Route::post('/form-update-post-{id}', [FormController::class,'updateForm'])->name('formUpdatePost');


    //DOCUMENT SETTING
    Route::get('/document', [DocumentController::class,'index'])->name('docManagement');
    Route::get('/document-{id}-delete-post', [DocumentController::class,'Delete'])->name('docDeletePost');


    //POST
    Route::post('/document-post', [DocumentController::class,'Add'])->name('docAddPost');
    Route::post('/document-update-post', [DocumentController::class,'Update'])->name('docUpdatePost');

    //SUBMISSION MANAGEMENT
    Route::get('/submission-management', [SubmissionController::class,'indexSubmission'])->name('submissionAllManagement');
    Route::get('/submission-document-download-{id}', [SubmissionController::class,'downloadsDoc'])->name('subDocDown');

    //POST
    Route::post('/submission-update{id}', [SubmissionController::class,'updateSubmission'])->name('subUpdate');

    //DECISION SUPPORT MANAGEMENT SYSTEM (SUGGESTION)
    Route::get('/suggestion', [SubmissionController::class,'indexSuggestion'])->name('suggestionSystem');
    Route::get('/suggestion-iso-list', [SubmissionController::class,'isolatedList'])->name('isolatedList');
    Route::get('/suggestion-accepted-list', [SubmissionController::class,'AcceptedList'])->name('AcceptedList');
    Route::get('/suggestion-revert-{id}-{act}', [SubmissionController::class,'revertStudent'])->name('revertStudent');
    Route::get('/suggestion-refresh-submission', [SubmissionController::class,'refreshSubmission'])->name('refreshSubmission');

    //POST
    Route::post('/suggestion', [SubmissionController::class,'indexSuggestion'])->name('suggestList');
    Route::post('/suggestion-student-isolate', [SubmissionController::class,'selectStudent'])->name('selectProcessPost');
    Route::post('/suggestion-student-remove-isolate', [SubmissionController::class,'studentRemoveIsolate'])->name('isolateRemoveProcessPost');
    Route::post('/suggestion-submission-approval', [SubmissionController::class,'suggestionApproval'])->name('suggestionApprovalProcessPost');


    // MY SUPERVISION
    Route::get('/mysupervision-student-list', [MySupervisionController::class,'indexStudentList'])->name('mysvstudentlist');
    Route::get('/mysupervision-submission-management', [MySupervisionController::class,'indexSubmission'])->name('mysvsubmissionManagement');
    Route::get('/mysupervision-submission-approval', [MySupervisionController::class,'indexSubmissionApproval'])->name('mysvsubmissionApproval');
    Route::get('/final-document-download-{act}-{stud}', [MySupervisionController::class,'downloadsFinalDoc'])->name('mysvfinalDocDown');
    Route::get('/mysupervision-nomination', [MySupervisionController::class,'indexNomination'])->name('mysvnomination');
    Route::get('/excel-export', [MySupervisionController::class,'exportStudentList'])->name('mysvlistExport');

    //POST
    Route::post('/mysupervision-submission-update{id}', [MySupervisionController::class,'updateSubmission'])->name('mysvSubUpdate');
    Route::post('/approve-submission-{act}-{stud}', [MySupervisionController::class,'approveSubmission'])->name('mysvApproveSubmission');
    Route::post('/reject-submission-{stuact}{staff}', [MySupervisionController::class,'rejectSubmission'])->name('mysvRejectSubmission');
    Route::post('/nomination-form-upload-{stud}-{act}', [MySupervisionController::class,'UploadNominationForm'])->name('mysvUploadNomination');

    //DOWNLOAD FORM BOTH NOMINATION & MYSV NOMINATION
    Route::get('/nomination-form-download-{id}', [NominationController::class,'downloadNominationForm'])->name('nomDown');
    Route::get('/nomination-template-form-download-{id}', [MySupervisionController::class,'downloadNominationTemplateForm'])->name('nomTemplateDown');

    //NOMINATION
    Route::get('/nomination-management', [NominationController::class,'indexNomination'])->name('nominationManagement');
    Route::get('/nomination-rejected-{id}', [NominationController::class,'nominationRejection'])->name('nominationRejection');

    //POST
    Route::post('/nomination-approved-{id}', [NominationController::class,'nominationApproval'])->name('nominationApproval');

    //EVALUATION ARRAGEMENT
    Route::get('/evaluation', [EvaluationController::class,'indexEva'])->name('evaluationArragement');
    Route::get('/evaluation-delete-{id}', [EvaluationController::class,'deleteEva'])->name('evaDeleteGet');

    //POST
    Route::post('/evaluation-add', [EvaluationController::class,'addEva'])->name('evaPost');
    Route::post('/evaluation-update-{id}', [EvaluationController::class,'updateEva'])->name('evaUpdatePost');

    //MY EVALUATION
    Route::get('/myevaluation-{id}', [EvaluationController::class,'indexMyEva'])->name('myevaluationManagement');
    Route::get('/form-myevaluation-download-{id}', [EvaluationController::class,'downloadEvaForm'])->name('evaDown');


    //POST
    Route::post('/myevaluation-upload-post{id}', [EvaluationController::class,'uploadMyEva'])->name('myevaUploadPost');


    //TDP SUBMISSION APPROVAL
    Route::get('/submission-approval', [AdminController::class,'indexSubmissionApproval'])->name('adminsubmissionApproval');

    //POST
    Route::post('/admin-approve-submission-{act}-{stud}', [AdminController::class,'approveSubmission'])->name('adminApproveSubmission');









 

 

});
/*-------End Staff Route ------- */



/*-------Student Route ------- */
Route::get('/', function () {
    return redirect()->route('student.login');
});

Route::prefix('student')->group(function () {
    //RESET PASSWORD
    Route::get('/reset-student-password', [StudentManagementController::class,'indexResetPasswordRequest'])->name('studentResetPasswordRequest');
    Route::get('/student-email-sent-reset-password-{id}', [StudentManagementController::class,'indexResetPassword'])->name('studentResetPasswordSent');


    //POST
    Route::post('/reset-password-mail-sent', [StudentManagementController::class,'resetPasswordMail'])->name('resetStudentPasswordMail');
    Route::post('/student-email-sent-reset-password-post{id}', [StudentManagementController::class,'resetPassword'])->name('resetStudentPassword');

});
Route::prefix('student')->middleware('auth')->group(function () {

    //STUDENT SUBMISSION MANAGEMENT
    Route::get('/dashboard', [StudentManagementController::class,'index'])->name('studentHome');
    Route::get('/activity', [StudentManagementController::class,'indexActivity'])->name('studentActivity');
    Route::get('/activities-{id}', [StudentManagementController::class,'indexEachActivity'])->name('studentEachActivity');
    Route::get('/profile', [StudentManagementController::class,'indexProfile'])->name('studentProfile');
    Route::get('/profile-edit', [StudentManagementController::class,'indexEditProfile'])->name('studentEditProfile');
    Route::get('/materialDownload-{act}-{prog}', [StudentManagementController::class,'downloadsMaterial'])->name('materialDown');
    Route::get('/document-submission-{id}', [StudentManagementController::class,'indexDocument'])->name('documentsubmission');
    Route::get('/document-remove-submission-{id}', [StudentManagementController::class,'removeSubmission'])->name('removeSubmission'); 
    Route::get('/submissionDownload-{id}', [StudentManagementController::class,'downloadSubmission'])->name('submissionDown');
    Route::get('/finaldoc-Download-{act}-{stud}', [StudentManagementController::class,'downloadsFinalDoc'])->name('finalDocDown');
    Route::get('/test-{act}', [StudentManagementController::class,'test'])->name('test');


    //POST
    Route::post('/submission-{id}-{act}', [StudentManagementController::class,'submission'])->name('submissionPost');
    Route::post('/confirm-submission-{act}', [StudentManagementController::class,'confirmSubmission'])->name('confirmsubmission');
    Route::post('/profile-edit-post-{id}', [StudentManagementController::class,'updateProfile'])->name('studentProfileUpdatePost');
    Route::post('/password-update-post-{id}', [StudentManagementController::class,'updatePassword'])->name('studentPasswordUpdatePost');



    
});
/*-------End Student Route ------- */




require __DIR__.'/auth.php';
require __DIR__.'/staffauth.php';

