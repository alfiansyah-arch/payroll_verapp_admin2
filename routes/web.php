<?php

use App\Http\Controllers\AttendancesController;
use App\Http\Controllers\BroadcastController;
use App\Http\Controllers\LoansController;
use App\Http\Controllers\PayrollController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeTaskController;
use App\Http\Controllers\SettingsController;

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

Route::get('/', [AuthController::class, 'dashboard'])->name('dashboard');
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');

Route::middleware('auth')->group(function () {
    // Auth Controller
    Route::get('dashboard', [AuthController::class, 'dashboard']);
    Route::post('logout', [AuthController::class, '__invoke'])->name('logout.post'); 

    // EMployeeController.php
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees_data');
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.createusers');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.editusers');
    Route::put('/employees/{id}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
    Route::get('/get-positions/{departmentId}', [EmployeeController::class, 'getPositions']);

    // EmployeeTaskController.php
    Route::get('/employee-task', [EmployeeTaskController::class, 'index'])->name('employee_task_list');
    Route::get('/employee-task/create-task', [EmployeeTaskController::class, 'create_task'])->name('employee-task.createtask');
    Route::get('/employee-task/create-user-task', [EmployeeTaskController::class, 'create_task_detail'])->name('employee-task.createtaskdetail');
    Route::post('/employee-task/store-task', [EmployeeTaskController::class, 'storetask'])->name('employee-task.storetask');
    Route::post('/employee-task/store-user-task', [EmployeeTaskController::class, 'storetaskdetail'])->name('employee-task.storetaskdetail');
    Route::get('/employee-task/{id}/edit-task', [EmployeeTaskController::class, 'edittask'])->name('employee-task.edittask');
    Route::put('/employee-task/update-task/{id}', [EmployeeTaskController::class, 'updatetask'])->name('employee-task.updatetask');
    Route::get('/employee-task/{id}/edit-task-detail', [EmployeeTaskController::class, 'edittaskdetail'])->name('employee-task.edittaskdetail');
    Route::put('/employee-task/update-task-detail/{id}', [EmployeeTaskController::class, 'updatetaskdetail'])->name('employee-task.updatetaskdetail');
    Route::delete('/employee-task/delete-task/{id}', [EmployeeTaskController::class, 'destroytask'])->name('employee-task.destroytask');    
    Route::delete('/employee-task/delete-task-detail/{id}', [EmployeeTaskController::class, 'destroytaskdetail'])->name('employee-task.destroytaskdetail');  

    // PayrollController.php
    Route::get('/payroll', [PayrollController::class, 'index'])->name('payroll.index');
    Route::get('/payroll/create', [PayrollController::class, 'create'])->name('payroll.create');
    Route::post('/payroll', [PayrollController::class, 'store'])->name('payroll.store');
    Route::get('/payroll/{id}/edit', [PayrollController::class, 'edit'])->name('payroll.edit');
    Route::put('/payroll/{id}', [PayrollController::class, 'update'])->name('payroll.update');
    Route::delete('/payroll/{id}', [PayrollController::class, 'destroy'])->name('payroll.destroy');

    // BroadcastController.php
    Route::get('/broadcast', [BroadcastController::class, 'index'])->name('broadcast.index');
    Route::get('/broadcast/create', [BroadcastController::class, 'create'])->name('broadcast.create');
    Route::post('/broadcast', [BroadcastController::class, 'store'])->name('broadcast.store');   
    Route::get('/broadcast/create-category', [BroadcastController::class, 'createCategory'])->name('broadcast.createcategory');
    Route::post('/broadcast/store-category', [BroadcastController::class, 'storeCategory'])->name('broadcast.storeCategory');
    Route::get('/broadcast/{id}/show', [BroadcastController::class, 'show'])->name('broadcast.show');
    Route::get('/broadcast/{id}/edit', [BroadcastController::class, 'edit'])->name('broadcast.edit');
    Route::put('/broadcast/{id}', [BroadcastController::class, 'update'])->name('broadcast.update');
    Route::get('/broadcast/{id}/edit-category', [BroadcastController::class, 'editCategory'])->name('broadcast.editcategory');
    Route::put('/broadcast/update-category/{id}', [BroadcastController::class, 'updateCategory'])->name('broadcast.updatecategory');
    Route::delete('/broadcast/{id}', [BroadcastController::class, 'destroy'])->name('broadcast.destroy');
    Route::delete('/broadcast/delete-category/{id}', [BroadcastController::class, 'destroyCategory'])->name('broadcast.destroycategory');
    Route::post('/broadcast/upload', [BroadcastController::class, 'upload'])->name('ckeditor.upload');

    // AttendancesController.php
    Route::get('/attendances/presensi', [AttendancesController::class, 'presensi'])->name('attendances.presensi');
    Route::get('/attendances/leaves', [AttendancesController::class, 'leaves'])->name('attendances.leaves');
    Route::get('/attendances/create-presensi', [AttendancesController::class, 'createPresensi'])->name('attendances.presensi.create');
    Route::post('/attendances/presensi-store', [AttendancesController::class, 'storePresensi'])->name('attendances.presensi.store');
    Route::get('/attendances/{id}/edit-presensi', [AttendancesController::class, 'editPresensi'])->name('attendances.presensi.edit');
    Route::put('/attendances/presensi/update-presensi/{id}', [AttendancesController::class, 'updatePresensi'])->name('attendances.presensi.update');
    Route::put('/attendances/presensi/update-leaves/{id}', [AttendancesController::class, 'updateLeaves'])->name('attendances.leaves.update');
    Route::put('/attendances/presensi/{id}', [AttendancesController::class, 'updateStatus'])->name('attendances.presensi.updatestatus');
    Route::delete('/attendances/presensi/{id}', [AttendancesController::class, 'destroyPresensi'])->name('attendances.presensi.destroy');

    // LoansController.php
    Route::get('/loans/list', [LoansController::class, 'index'])->name('loans.list');
    Route::get('/loans/list/create-loans', [LoansController::class, 'create'])->name('loans.list.create');
    Route::post('/loans/list/loans-store', [LoansController::class, 'store'])->name('loans.list.store');
    Route::get('/loans/list/{id}/edit-loans', [LoansController::class, 'edit'])->name('loans.list.edit');
    Route::put('/loans/list/loans/{id}', [LoansController::class, 'update'])->name('loans.list.update');
    Route::delete('/loans/list/loans/delete/{id}', [LoansController::class, 'destroy'])->name('loans.list.destroy');
    Route::put('/loans/list/loans/completely/{id}', [LoansController::class, 'completely'])->name('loans.list.completely');
    Route::get('/loans/list/{id}/show', [LoansController::class, 'show'])->name('loans.list.show');

    // SettingsController.php
    // Setting Department
    Route::get('/settings/departments', [SettingsController::class, 'departments'])->name('settings.departments');
    Route::get('/settings/create-department', [SettingsController::class, 'createDepartment'])->name('settings.departments.create');
    Route::post('/settings/department-store', [SettingsController::class, 'storeDepartment'])->name('settings.departments.store');
    Route::get('/settings/{id}/edit-department', [SettingsController::class, 'editDepartment'])->name('settings.departments.edit');
    Route::put('/settings/departments/{id}', [SettingsController::class, 'updateDepartment'])->name('settings.departments.update');
    Route::delete('/settings/departments/{dept_id}', [SettingsController::class, 'destroyDepartment'])->name('settings.departments.destroy');

    // Setting Position
    Route::get('/settings/positions', [SettingsController::class, 'positions'])->name('settings.positions');
    Route::get('/settings/create-position', [SettingsController::class, 'createPosition'])->name('settings.positions.create');
    Route::post('/settings/position-store', [SettingsController::class, 'storePosition'])->name('settings.positions.store');
    Route::get('/settings/{id}/edit-position', [SettingsController::class, 'editPosition'])->name('settings.positions.edit');
    Route::put('/settings/positions/{id}', [SettingsController::class, 'updatePosition'])->name('settings.positions.update');
    Route::delete('/settings/positions/{id}', [SettingsController::class, 'destroyPosition'])->name('settings.positions.destroy');

    // Setting Installsments
    Route::get('/settings/installsments', [SettingsController::class, 'installsments'])->name('settings.installments');
    Route::get('/settings/create-installsment', [SettingsController::class, 'createInstallments'])->name('settings.installments.create');
    Route::post('/settings/installments-store', [SettingsController::class, 'storeInstallments'])->name('settings.installments.store');
    Route::get('/settings/{id}/edit-installsment', [SettingsController::class, 'editInstallments'])->name('settings.installments.edit');
    Route::put('/settings/installsments/{id}', [SettingsController::class, 'updateInstallments'])->name('settings.installments.update');
    Route::delete('/settings/installsments/{id}', [SettingsController::class, 'destroyInstallments'])->name('settings.installments.destroy');

    // Setting Interest
    Route::get('/settings/interests', [SettingsController::class, 'interests'])->name('settings.interests');
    Route::get('/settings/create-interests', [SettingsController::class, 'createInterests'])->name('settings.interests.create');
    Route::post('/settings/interests-store', [SettingsController::class, 'storeInterests'])->name('settings.interests.store');
    Route::get('/settings/{id}/edit-interests', [SettingsController::class, 'editInterests'])->name('settings.interests.edit');
    Route::put('/settings/interests/{id}', [SettingsController::class, 'updateInterests'])->name('settings.interests.update');
    Route::delete('/settings/interests/{id}', [SettingsController::class, 'destroyInterests'])->name('settings.interests.destroy');
});
