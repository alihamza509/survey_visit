<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SurveyVisitController;
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

Route::get('/', function () {
    return redirect('/login');
});
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Auth::routes();

Route::get('/home', function () {
    return redirect('/admin/dashboard');
});
Route::post('profile/update', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('admin.dashboard');
    Route::get('setting', [AdminController::class, 'Setting'])->name('admin.setting');
    Route::post('setting/update', [AdminController::class, 'settingStore'])->name('settings.update');
    // User Management Routes

     Route::get('user/view-admin', [App\Http\Controllers\AdminController::class, 'viewAdmin'])->name('admin.user.view-admin');
     Route::get('users/data', [App\Http\Controllers\AdminController::class, 'getAdminData'])->name('admin.users.data');
     Route::get('users/{id}', [App\Http\Controllers\AdminController::class, 'show'])->name('admin.users.show'); // Get user details for editing
     Route::post('users/store', [App\Http\Controllers\AdminController::class, 'store'])->name('admin.users.store'); // Store new user
     Route::post('users/update/{id}', [App\Http\Controllers\AdminController::class, 'update'])->name('admin.users.update'); // Update user
     Route::delete('users/delete/{id}', [App\Http\Controllers\AdminController::class, 'destroy'])->name('admin.users.delete'); // Delete user
     Route::get('users/{id}/checkinout', [AdminController::class, 'showCheckInOut'])->name('admin.users.checkinout');
     Route::get('users/{id}/export', [AdminController::class, 'exportCheckInOut'])->name('admin.users.export');
     Route::get('users/{id}/details', [AdminController::class, 'getUserDetails'])->name('admin.users.details');
     Route::get('admin/expenses', [ExpenseController::class, 'index'])->name('admin.expenses.index');
     Route::get('admin/expenses/export', [ExpenseController::class, 'export'])->name('admin.expenses.export');
     Route::get('admin/expenses/{id}', [ExpenseController::class, 'show'])->name('admin.expenses.show');
     Route::get('admin/expenses/data', [ExpenseController::class, 'getData'])->name('admin.expenses.data');
     Route::get('surveys', [SurveyVisitController::class, 'index'])->name('surveys.index');
     Route::get('surveys/export', [SurveyVisitController::class, 'export'])->name('surveys.export');
     Route::get('surveys/{id}', [SurveyVisitController::class, 'show'])->name('surveys.show');
     Route::get('sample-orders', [SurveyVisitController::class, 'indexSample'])->name('sample-orders.index');
Route::get('sample-orders/export', [SurveyVisitController::class, 'exportSampleOrder'])->name('sample-orders.export');
Route::get('sample-orders/{id}', [SurveyVisitController::class, 'showSample'])->name('sample-orders.show');

Route::get('follow-ups', [SurveyVisitController::class, 'indexShowFollowup'])->name('follow_ups.index');
Route::get('follow-ups/export', [SurveyVisitController::class, 'storeFollowup'])->name('follow_ups.export');
Route::get('follow-ups/{id}', [SurveyVisitController::class, 'showFollowup'])->name('follow_ups.show');

Route::get('trial-orders', [SurveyVisitController::class, 'trailorder'])->name('trial_orders.index');
Route::get('trial-orders/export', [SurveyVisitController::class, 'storetrailorder'])->name('trial_orders.export');
Route::get('trial-orders/{id}', [SurveyVisitController::class, 'showtrailorder'])->name('trial_orders.show');
Route::get('profile_edit', [AdminController::class, 'editProfile'])->name('admin.profile.edit');
// Route::post('profile/update', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
Route::get('change_password', [AdminController::class, 'changePassword'])->name('admin.password.change');
Route::post('password/store', [AdminController::class, 'passwordStore'])->name('admin.password.store');      
});