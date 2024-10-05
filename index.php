<?php
require_once __DIR__ . '/vendor/autoload.php';

use app\models\Route;
use app\controllers\FrontEndController;
use app\Middleware\SessionAuthMiddleware;
use app\controllers\admin\LeaveController;
use app\controllers\admin\EmployeeController;
use app\controllers\admin\DashboardController;
use app\controllers\admin\LeaveTypeController;
use app\controllers\admin\DepartmentController;
use app\controllers\employee\EmployeeController as EmployerController;
use app\controllers\employee\DashboardController as EmployeeDashboardController;

// Public Routes
Route::get('/', ['controller' => FrontEndController::class, 'method' => 'index']);
Route::get('/register', ['controller' => FrontEndController::class, 'method' => 'registerForm']);
Route::post('/register', ['controller' => FrontEndController::class, 'method' => 'register']);
Route::get('/login', ['controller' => FrontEndController::class, 'method' => 'login']);
Route::get('/about', ['controller' => FrontEndController::class, 'method' => 'about']);
Route::get('/forgot/password', ['controller' => FrontEndController::class, 'method' => 'forgotPassword']);
Route::post('/signin', ['controller' => FrontEndController::class, 'method' => 'signin']);
Route::get('/verify_email', ['controller' => FrontEndController::class, 'method' => 'verifyEmail']);
Route::post('/reset_password', ['controller' => FrontEndController::class, 'method' => 'resetPassword']);
Route::get('/reset_password', ['controller' => FrontEndController::class, 'method' => 'showResetPasswordForm']);
Route::post('/new_password', ['controller' => FrontEndController::class, 'method' => 'processPasswordReset']);

// Define routes using static methods in Route class
Route::group('sessionAuth', function () {
    Route::middleware(SessionAuthMiddleware::class);
    Route::get('/apply-leave', ['controller' => FrontEndController::class, 'method' => 'applyLeave']);
    Route::post('/allcode', ['controller' => FrontEndController::class, 'method' => 'allcode']);
    Route::get('/leavestatus', ['controller' => FrontEndController::class, 'method' => 'leavestatus']);
    Route::get('/departments', ['controller' => DepartmentController::class, 'method' => 'getDepartments']);

    // Employees
    Route::get('/admin/employees', ['controller' => EmployeeController::class, 'method' => 'index']);
    Route::get('/admin/employees/index', ['controller' => EmployeeController::class, 'method' => 'employees']);
    Route::get('/admin/employee/create', ['controller' => EmployeeController::class, 'method' => 'createEmployeeForm']);
    Route::post('/admin/employee/create', ['controller' => EmployeeController::class, 'method' => 'createEmployee']);
    Route::get('/admin/employee/update/{id}', ['controller' => EmployeeController::class, 'method' => 'updateEmployeeForm']);
    Route::get('/admin/employee/show/{id}', ['controller' => EmployeeController::class, 'method' => 'show']);
    Route::put('/admin/employee/update/{id}', ['controller' => EmployeeController::class, 'method' => 'updateEmployee']);
    Route::delete('/admin/employee/delete/{id}', ['controller' => EmployeeController::class, 'method' => 'delete']);

    // Department
    Route::get('/admin/departments', ['controller' => DepartmentController::class, 'method' => 'index']);
    Route::get('/admin/department/create', ['controller' => DepartmentController::class, 'method' => 'createDepartmentForm']);
    Route::post('/admin/department/create', ['controller' => DepartmentController::class, 'method' => 'createDepartment']);
    Route::get('/admin/department/update/{id}', ['controller' => DepartmentController::class, 'method' => 'updateDepartmentForm']);
    Route::get('/admin/department/show/{id}', ['controller' => DepartmentController::class, 'method' => 'show']);
    Route::put('/admin/department/update/{id}', ['controller' => DepartmentController::class, 'method' => 'updateDepartment']);
    Route::delete('/admin/department/delete/{id}', ['controller' => DepartmentController::class, 'method' => 'delete']);

    // LeaveTypes
    Route::get('/admin/leavetypes', ['controller' => LeaveTypeController::class, 'method' => 'index']);
    Route::get('/admin/leavetypes/index', ['controller' => LeaveTypeController::class, 'method' => 'leavetypes']);
    Route::get('/admin/leavetype/create', ['controller' => LeaveTypeController::class, 'method' => 'createLtypeForm']);
    Route::post('/admin/leavetype/create', ['controller' => LeaveTypeController::class, 'method' => 'createLtype']);
    Route::get('/admin/leavetype/update/{id}', ['controller' => LeaveTypeController::class, 'method' => 'updateLeaveTypeForm']);
    Route::get('/admin/leavetype/show/{id}', ['controller' => LeaveTypeController::class, 'method' => 'show']);
    Route::put('/admin/leavetype/update/{id}', ['controller' => LeaveTypeController::class, 'method' => 'updateLeaveType']);
    Route::delete('/admin/leavetype/delete/{id}', ['controller' => LeaveTypeController::class, 'method' => 'delete']);

    // Leaves and applied ones
    Route::get('/admin/appliedleaves', ['controller' => LeaveController::class, 'method' => 'index']);
    Route::get('/admin/appliedleave', ['controller' => LeaveController::class, 'method' => 'appliedLeaves']);
    Route::get('/admin/appliedleave/update/{id}', ['controller' => LeaveController::class, 'method' => 'updateAppliedleaveForm']);
    Route::get('/admin/appliedleave/show/{id}', ['controller' => LeaveController::class, 'method' => 'show']);
    Route::put('/admin/appliedleave/update/{id}', ['controller' => LeaveController::class, 'method' => 'updateAppliedleave']);

    // dashboard admin
    Route::get('/admin/profile', ['controller' => DashboardController::class, 'method' => 'profile']);
    Route::get('/admin/dashboard', ['controller' => DashboardController::class, 'method' => 'dashboard']);
    Route::post('/admin/logout', ['controller' => DashboardController::class, 'method' => 'logout']);

    // dashboard employee
    Route::get('/employee/dashboard', ['controller' => EmployeeDashboardController::class, 'method' => 'employeeDashboard']);

    // Employee
    Route::get('/employee/department', ['controller' => EmployerController::class, 'method' => 'employeeDepartment']);
    Route::get('/employee/profile', ['controller' => EmployerController::class, 'method' => 'employeeProfile']);
    Route::post('/employee/logout', ['controller' => EmployerController::class, 'method' => 'employeeLogout']);
    Route::get('/employee/appliedleaves', ['controller' => EmployerController::class, 'method' => 'employeeAppliedleaves']);
    Route::get('/employee/leavetypes', ['controller' => EmployerController::class, 'method' => 'employeeLeavetypes']);
    Route::get('/employee/leavetypes/index', ['controller' => EmployerController::class, 'method' => 'leavetypes']);
    Route::get('/employee/leavetypes/show/{id}', ['controller' => EmployerController::class, 'method' => 'show']);
    Route::get('/employee/applyleave', ['controller' => EmployerController::class, 'method' => 'employeeApplyleaveForm']);
    Route::post('/employee/applyleave', ['controller' => EmployerController::class, 'method' => 'employeeApplyleave']);
});

