<?php
require_once __DIR__ . '/vendor/autoload.php';

use app\models\Router;
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
Router::get('/', ['controller' => FrontEndController::class, 'method' => 'index']);
Router::get('/register', ['controller' => FrontEndController::class, 'method' => 'registerForm']);
Router::post('/register', ['controller' => FrontEndController::class, 'method' => 'register']);
Router::get('/login', ['controller' => FrontEndController::class, 'method' => 'login']);
Router::get('/about', ['controller' => FrontEndController::class, 'method' => 'about']);
Router::get('/forgot/password', ['controller' => FrontEndController::class, 'method' => 'forgotPassword']);
Router::post('/signin', ['controller' => FrontEndController::class, 'method' => 'signin']);
Router::get('/verify_email', ['controller' => FrontEndController::class, 'method' => 'verifyEmail']);
Router::post('/reset_password', ['controller' => FrontEndController::class, 'method' => 'resetPassword']);
Router::get('/reset_password', ['controller' => FrontEndController::class, 'method' => 'showResetPasswordForm']);
Router::post('/new_password', ['controller' => FrontEndController::class, 'method' => 'processPasswordReset']);

// Define routes using static methods in Router class
Router::group('sessionAuth', function () {
    Router::middleware(SessionAuthMiddleware::class);
    Router::get('/apply-leave', ['controller' => FrontEndController::class, 'method' => 'applyLeave']);
    Router::post('/allcode', ['controller' => FrontEndController::class, 'method' => 'allcode']);
    Router::get('/leavestatus', ['controller' => FrontEndController::class, 'method' => 'leavestatus']);
    Router::get('/departments', ['controller' => DepartmentController::class, 'method' => 'getDepartments']);

    // Employees
    Router::get('/admin/employees', ['controller' => EmployeeController::class, 'method' => 'index']);
    Router::get('/admin/employees/index', ['controller' => EmployeeController::class, 'method' => 'employees']);
    Router::get('/admin/employee/create', ['controller' => EmployeeController::class, 'method' => 'createEmployeeForm']);
    Router::post('/admin/employee/create', ['controller' => EmployeeController::class, 'method' => 'createEmployee']);
    Router::get('/admin/employee/update/{id}', ['controller' => EmployeeController::class, 'method' => 'updateEmployeeForm']);
    Router::get('/admin/employee/show/{id}', ['controller' => EmployeeController::class, 'method' => 'show']);
    Router::put('/admin/employee/update/{id}', ['controller' => EmployeeController::class, 'method' => 'updateEmployee']);
    Router::delete('/admin/employee/delete/{id}', ['controller' => EmployeeController::class, 'method' => 'delete']);

    // Department
    Router::get('/admin/departments', ['controller' => DepartmentController::class, 'method' => 'index']);
    Router::get('/admin/department/create', ['controller' => DepartmentController::class, 'method' => 'createDepartmentForm']);
    Router::post('/admin/department/create', ['controller' => DepartmentController::class, 'method' => 'createDepartment']);
    Router::get('/admin/department/update/{id}', ['controller' => DepartmentController::class, 'method' => 'updateDepartmentForm']);
    Router::get('/admin/department/show/{id}', ['controller' => DepartmentController::class, 'method' => 'show']);
    Router::put('/admin/department/update/{id}', ['controller' => DepartmentController::class, 'method' => 'updateDepartment']);
    Router::delete('/admin/department/delete/{id}', ['controller' => DepartmentController::class, 'method' => 'delete']);

    // LeaveTypes
    Router::get('/admin/leavetypes', ['controller' => LeaveTypeController::class, 'method' => 'index']);
    Router::get('/admin/leavetypes/index', ['controller' => LeaveTypeController::class, 'method' => 'leavetypes']);
    Router::get('/admin/leavetype/create', ['controller' => LeaveTypeController::class, 'method' => 'createLtypeForm']);
    Router::post('/admin/leavetype/create', ['controller' => LeaveTypeController::class, 'method' => 'createLtype']);
    Router::get('/admin/leavetype/update/{id}', ['controller' => LeaveTypeController::class, 'method' => 'updateLeaveTypeForm']);
    Router::get('/admin/leavetype/show/{id}', ['controller' => LeaveTypeController::class, 'method' => 'show']);
    Router::put('/admin/leavetype/update/{id}', ['controller' => LeaveTypeController::class, 'method' => 'updateLeaveType']);
    Router::delete('/admin/leavetype/delete/{id}', ['controller' => LeaveTypeController::class, 'method' => 'delete']);

    // Leaves and applied ones
    Router::get('/admin/appliedleaves', ['controller' => LeaveController::class, 'method' => 'index']);
    Router::get('/admin/appliedleave', ['controller' => LeaveController::class, 'method' => 'appliedLeaves']);
    Router::get('/admin/appliedleave/update/{id}', ['controller' => LeaveController::class, 'method' => 'updateAppliedleaveForm']);
    Router::get('/admin/appliedleave/show/{id}', ['controller' => LeaveController::class, 'method' => 'show']);
    Router::put('/admin/appliedleave/update/{id}', ['controller' => LeaveController::class, 'method' => 'updateAppliedleave']);

    // dashboard admin
    Router::get('/admin/profile', ['controller' => DashboardController::class, 'method' => 'profile']);
    Router::get('/admin/dashboard', ['controller' => DashboardController::class, 'method' => 'dashboard']);
    Router::post('/admin/logout', ['controller' => DashboardController::class, 'method' => 'logout']);

    // dashboard employee
    Router::get('/employee/dashboard', ['controller' => EmployeeDashboardController::class, 'method' => 'employeeDashboard']);

    // Employee
    Router::get('/employee/department', ['controller' => EmployerController::class, 'method' => 'employeeDepartment']);
    Router::get('/employee/profile', ['controller' => EmployerController::class, 'method' => 'employeeProfile']);
    Router::post('/employee/logout', ['controller' => EmployerController::class, 'method' => 'employeeLogout']);
    Router::get('/employee/appliedleaves', ['controller' => EmployerController::class, 'method' => 'employeeAppliedleaves']);
    Router::get('/employee/leavetypes', ['controller' => EmployerController::class, 'method' => 'employeeLeavetypes']);
    Router::get('/employee/leavetypes/index', ['controller' => EmployerController::class, 'method' => 'leavetypes']);
    Router::get('/employee/leavetypes/show/{id}', ['controller' => EmployerController::class, 'method' => 'show']);
    Router::get('/employee/applyleave', ['controller' => EmployerController::class, 'method' => 'employeeApplyleaveForm']);
    Router::post('/employee/applyleave', ['controller' => EmployerController::class, 'method' => 'employeeApplyleave']);
});

