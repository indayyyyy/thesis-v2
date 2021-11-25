<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

use App\Http\Livewire\Auth\ForgotPassword;
use App\Http\Livewire\Auth\ResetPassword;
use App\Http\Livewire\Auth\SignUp;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Billing;
use App\Http\Livewire\Profile;
use App\Http\Livewire\Tables;
use App\Http\Livewire\Cancelled;
use App\Http\Livewire\StaticSignIn;
use App\Http\Livewire\StaticSignUp;
use App\Http\Livewire\Rtl;
use Illuminate\Support\Facades\DB;
use App\Http\Livewire\LaravelExamples\UserProfile;
use App\Http\Livewire\LaravelExamples\UserManagement;
use App\Models\ClinicSchedule;

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', Login::class)->name('login');

Route::get('/sign-up', SignUp::class)->name('sign-up');
Route::get('/login', Login::class)->name('login');

Route::get('/login/forgot-password', ForgotPassword::class)->name('forgot-password');

Route::get('/reset-password/{id}',ResetPassword::class)->name('reset-password')->middleware('signed');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    // Route::resource('/dashboard', DashboardController::class);
    Route::get('/billing', Billing::class)->name('billing');
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/tables', Tables::class)->name('tables');
    Route::get('/static-sign-in', StaticSignIn::class)->name('sign-in');
    Route::get('/static-sign-up', StaticSignUp::class)->name('static-sign-up');
    Route::get('/rtl', Rtl::class)->name('rtl');
    Route::get('/laravel-user-profile', UserProfile::class)->name('user-profile');
    Route::get('/laravel-user-management', UserManagement::class)->name('user-management');

    Route::get('fullcalender', [ScheduleController::class, 'index']);
    Route::post('fullcalenderAjax', [ScheduleController::class, 'ajax']);

    Route::post('sms/notif',[\App\Http\Controllers\SMSController::class,'send_sms'])->name('send_sms');

    Route::prefix('schedule')->group(function () {
        Route::get('/appointment',\App\Http\Livewire\Appointments::class)->name('appointments');
    });

    Route::put('sched/{schedule}',[ScheduleController::class,'update_sched'])->name('update_sched');
    Route::post('create-sched',[ScheduleController::class,'create_sched'])->name('create_sched');
    Route::post('create-sched/patient',[ScheduleController::class,'create_sched_patient'])
    ->name('create_sched_patient');

    Route::get('test',[ScheduleController::class,'test'])->name('test');

});

Route::delete('appointment/{id}',function($id){

    DB::transaction(function () use($id){
        $data = App\Models\Schedule::find($id);

        if($data->time_type ==='pm' &&  $data->status==='approved'){
            $clinic = ClinicSchedule::where('number_of_patient_pm','pm')->first();
            \DB::table('clinic_schedules')->increment('number_of_patient_pm');
        }
        if($data->time_type ==='am'  && $data->status==='approved'){
            $clinic = ClinicSchedule::where('number_of_patient_am','am')->first();
            \DB::table('clinic_schedules')->increment('number_of_patient_am');
        }
        $data->delete();

    });

return redirect()->back();

});
Route::get('/cancelled/schedule', Cancelled::class)->name('cancelled/schedule');

Route::get('send-mail', function () {

    $details = [
        'title' => 'Mail from ItSolutionStuff.com',
        'body' => 'This is for testing email using smtp'
    ];

    \Mail::to('jezreelgatmaitan.wrk@gmail.com')->send(new \App\Mail\PasswordNotif($details));

    dd("Email is Sent.");

});

