<?php

use App\Http\Controllers\Acl\PermissionController;
use App\Http\Controllers\Acl\RoleController;
use App\Http\Controllers\Acl\UserController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Admin\Badges\BadgeController;
use App\Http\Controllers\Admin\Menu\CourseManagmentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\Education\CourseController;
use App\Http\Controllers\Education\DepartmentController;
use App\Http\Controllers\Education\Term\TermController;
use App\Http\Controllers\Education\Term\TermSessionController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\Front\CourseController as FrontCourseController;
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\learn\WorkoutController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\Mentors\MentorCommentsController;
use App\Http\Controllers\Mentors\MyLearnerController;
use App\Http\Controllers\Panel\MyCourseController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\RubricController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TestimonialsController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\TrialClassController;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\VideoCall;
use App\Http\Controllers\Admin\AttendanceController as AdminAttendanceController;

Route::get('/video-call', [FrontController::class, 'video'])->name('video.call');
Route::get('/', [FrontController::class, 'index'])->name('home');

Route::get('/courses/trial', [TrialClassController::class,'courseTrial'])->name('courses.trial');
Route::post('/courses/start/trial', [TrialClassController::class,'startTrial'])->name('courses.startTrial');
Route::get('/courses/{course}/content', [TrialClassController::class,'showContent'])->middleware('trial.active')->name('courses.content');
Route::post('/trials/{trial}/complete', [TrialClassController::class, 'completeTrial'])->name('trials.complete');


Route::group(['prefix' => 'front', 'as' => 'front.'], function () {
    Route::get('/courses', [FrontCourseController::class, 'courses'])->name('courses');
    Route::get('/course/{course_id}', [FrontCourseController::class, 'course'])->name('course');
    Route::get('/plans', [FrontCourseController::class, 'plans'])->name('plans');
});

Route::prefix('learn')->middleware(['verified'])->group(function () {
    Route::get('/task/{participant}/{sessionable}', [WorkoutController::class, 'task'])->name('taskLearner');
    Route::post('/task/{participant}/{sessionable}', [WorkoutController::class, 'prepared'])->name('taskLearnerPrepared');
    Route::post('/quiz/workout', [WorkoutController::class, 'workout'])->name('quizWorkout');
    Route::get('my/course', [MyCourseController::class, 'myCourse'])->name('myCourse');
    Route::get('my/course/{participant}', [MyCourseController::class, 'learn'])->name('learningCourse');
    Route::get('/completeAndNext/{workout}', [WorkoutController::class, 'completedAndNext'])->name('completedAndNext');
});
Route::prefix('mentor')->middleware(['verified'])->group(function () {
    Route::get('/learners', [MyLearnerController::class, 'myLearners'])->name('myLearners');
    Route::get('/learner/{user}', [ParticipantController::class, 'participantTerms'])->name('learnerShowTerms');
    Route::get('/workout/{participant}', [ParticipantController::class, 'participantWorkout'])->name('learnerParticipantWorkout');
    Route::get('/review/workout/{participant}/{workout}', [ParticipantController::class, 'reviewWorkout'])->name('reviewWorkout');
    Route::post('/review/update', [ParticipantController::class, 'reviewWorkoutUpdate'])->name('workoutMentorReviewUpdate');
    Route::resource('mentor-comments', MentorCommentsController::class);
});

Route::prefix('panel')->middleware(['verified'])->group(function () {
    Route::get('/menu/education', [CourseManagmentController::class, 'courses'])->name('adminMenuCourse');
    Route::get('/menu/plugins', [CourseManagmentController::class, 'plugins'])->name('adminMenuPlugins');
    Route::get('/dashboard', [GeneralController::class, 'dashboard'])->name('dashboard');
    Route::get('/settings', [SettingController::class, 'index'])->name('settings');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::patch('/setting/{user}', [SettingController::class, 'update'])->name('setting.update');
    Route::resource('department', DepartmentController::class);
    Route::resource('course', CourseController::class);
    Route::resource('term', TermController::class);
    Route::resource('session', SessionController::class);
    Route::post('attendances/checkout/{attendanceId}', [AttendanceController::class, 'checkOut'])->name('attendances.checkout');
    Route::get('attendances/marked', [AttendanceController::class, 'markedAttendance'])->name('teacher.attendance.marked');
    Route::get('attendances/mark', [AttendanceController::class, 'markAttendance'])->name('attendances.mark');
    Route::middleware(['role:teacher|Super-Admin'])->group(function () {
        //Route::resource('attendance', AttendanceController::class); 
        //Route::post('attendances/store', [AttendanceController::class, 'storeAttendance'])->name('attendances.store'); 
        // Route::get('teacher/attendances/mark', [AttendanceController::class, 'teacherAttendance'])->name('teacher.attendance.mark');
        // Route::post('teacher/attendances/mark', [AttendanceController::class, 'markAttendance'])->name('attendance.mark');
        // Route::post('teacher/attendances/checkout/{id}', [AttendanceController::class, 'checkOut'])->name('attendance.checkout');
    });
    Route::middleware(['auth', 'role:student'])->group(function () {
        Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.checkIn');
        Route::post('/attendance/check-out', [AttendanceController::class, 'checkOut'])->name('attendance.checkOut');
        Route::get('/attendance/view', [AttendanceController::class, 'viewAttendance'])->name('attendance.view');
    });
    Route::resource('file', FileController::class);
    Route::resource('activity', ActivityController::class);
    Route::resource('document', DocumentController::class);
    Route::resource('quiz', QuizController::class);
    Route::resource('question', QuestionController::class);
    Route::resource('rubric', RubricController::class);
    Route::resource('feedback', FeedbackController::class);
    Route::resource('plan', PlanController::class);
    Route::resource('badges', BadgeController::class);
    Route::resource('pricings', PricingController::class);
    Route::get('course/{id}/pricing/edit', [CourseController::class, 'editPricing'])->name('course.pricing.edit');
    Route::put('course/{id}/pricing', [CourseController::class, 'updatePricing'])->name('course.pricing.update');
    Route::resource('trial-classes', TrialClassController::class);
    Route::get('logs', [LogController::class, 'index'])->name('logs');
    Route::get('/document/order/{from}/{move}', [DocumentController::class, 'orderChangeFiles'])->name("changeOrderFile");
    Route::get('/document/file/add/{document}/{file}', [DocumentController::class, 'addFileToDocument'])->name("addFileToDocument");
    Route::get('/document/file/delete/{documentFile}', [DocumentController::class, 'deleteFileAsDocument'])->name("deleteFileDocument");
    Route::get('/session/document/{session}/{active_id}', [SessionController::class, 'addDocumentToSession'])->name("addDocumentToSession");
    Route::get('/session/file/{session}/{active_id}', [SessionController::class, 'addFileToSession'])->name("addFileToSession");
    Route::get('/session/order/{from}/{move}', [SessionController::class, 'changeOrderSessionable'])->name("changeOrderSessionable");
    Route::get('/session/quiz/{session}/{active_id}', [SessionController::class, 'addQuizToSession'])->name("addQuizToSession");
    Route::get('/session/delete/{session_id}', [SessionController::class, 'deleteActivityAsSession'])->name("deleteActivityAsSession");
    Route::resource('/configuration', ConfigurationController::class)->middleware('role:Super-Admin');
    Route::get('/session/rubric/{session}/{active_id}', [SessionController::class, 'addRubricToSession'])->name("addRubricToSession");
    Route::get('/quiz/order/{from}/{move}', [QuizController::class, 'orderChangeQuestion'])->name("orderChangeQuestion");
    Route::get('/quiz/question/add/{parent}/{question}', [QuizController::class, 'addQuestionToQuiz'])->name("addQuestionToQuiz");
    Route::get('/quiz/question/delete/{quizQuestion}', [QuizController::class, 'deleteQuestionAsQuiz'])->name("deleteQuestionAsQuiz");
    Route::get('/feedback/order/{from}/{move}', [FeedbackController::class, 'orderChangeQuestionFeedback'])->name("orderChangeQuestionFeedback");
    Route::get('/feedback/question/add/{parent}/{question}', [FeedbackController::class, 'addQuestionToFeedback'])->name("addQuestionToFeedback");
    Route::get('/feedback/question/delete/{feedbackQuestion}', [FeedbackController::class, 'deleteQuestionAsFeedback'])->name("deleteQuestionAsFeedback");
    Route::get('/session/feedback/{session}/{active_id}', [SessionController::class, 'addFeedbackToSession'])->name("addFeedbackToSession");
    Route::get('/term/add/{term}/session/{session}', [TermSessionController::class, 'store'])->name("addSessionToTerm");
    Route::get('/term/remove/{term}/session/{session}', [TermSessionController::class, 'destroy'])->name("deleteSessionAsTerm");
    Route::get('/term/order/{from}/{move}', [TermSessionController::class, 'order'])->name("orderChangeSession");
    Route::resource('user', UserController::class)->middleware('role:Super-Admin');
    Route::resource('role', RoleController::class)->middleware('role:Super-Admin');
    Route::resource('permission', PermissionController::class)->middleware('role:Super-Admin');
    Route::post('role/permission/{role}', [RoleController::class, 'permission'])->name("role_permissions");
    Route::middleware('role:Super-Admin')->group(function () {
        Route::resource('testimonials', TestimonialsController::class);
        // Route::get('testimonials', [TestimonialsController::class, 'index'])->name('testimonial.index');
        // Route::get('testimonials/create', [TestimonialsController::class, 'create'])->name('testimonial.create');
        // Route::post('testimonials/store', [TestimonialsController::class, 'store'])->name('testimonial.store');
        // Route::put('testimonials/edit', [TestimonialsController::class, 'storeAttendance'])->name('testimonial.edit');
        Route::prefix('admin')->middleware(['auth', 'role:Super-Admin'])->name('admin.')->group(function () {
            Route::get('/attendances', [AdminAttendanceController::class, 'index'])->name('attendances.index');
            Route::get('/attendances/{id}', [AdminAttendanceController::class, 'show'])->name('attendances.show');
            Route::get('/attendances/edit/{id}', [AdminAttendanceController::class, 'edit'])->name('attendances.edit');
            Route::post('/attendances/update/{id}', [AdminAttendanceController::class, 'update'])->name('attendances.update');
            Route::delete('/attendances/delete/{id}', [AdminAttendanceController::class, 'destroy'])->name('attendances.destroy');
            Route::get('/attendances/report', [AdminAttendanceController::class, 'report'])->name('attendances.report');
            Route::get('/attendances/export', [AdminAttendanceController::class, 'export'])->name('attendances.export');
        });
    });
});
