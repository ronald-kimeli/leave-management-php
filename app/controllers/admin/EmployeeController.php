<?php

namespace app\controllers\admin;

use app\models\Role;
use app\models\User;
use app\Responses\View;
use app\models\Department;
use app\controllers\Controller;

class EmployeeController extends Controller
{

    public function index()
    {
        $headerTitle = 'Employees';
        $message = isset($_SESSION['message']) ? $_SESSION['message'] : null;
        $messageCode = isset($_SESSION['message_code']) ? $_SESSION['message_code'] : null;

        return View::render('admin.employees.index', null, $headerTitle, $message, $messageCode, 200);
    }
    public function employees()
    {
        try {
            $itemsPerPage = isset($_GET['perPage']) ? (int) $_GET['perPage'] : 5;

            if (isset($_GET['search']) && $_GET['search'] === '') {
                $query = User::model()->paginate($itemsPerPage);
            } else {
                $query = User::model()->whereLike(['name' => $_GET['search']])->paginate($itemsPerPage);
            }

            $query['data'] = array_map(function ($employee) {

                // $data = $employee->getAttributes();
                $data = [
                    'id' => $employee->getAttributes()['id'],
                    'first_name' => $employee->getAttributes()['first_name'],
                    'last_name' => $employee->getAttributes()['last_name'],
                    'verify_status' => $employee->getAttributes()['verify_status'],
                ];

                if (method_exists($employee, 'role')) {
                    $role = $employee->role()->getAttributes();
                    $data['role'] =  [
                        'name' => $role['name'],
                    ];
                    // $role;
                }

                if (method_exists($employee, 'department')) {
                    $department = $employee->department()->getAttributes();
                    $data['department'] = [
                        'name' => $department['name'],
                    ];
                    // $department;
                }

                return $data;
            }, $query['data']);

            header('Content-Type: application/json');
            echo json_encode($query, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        } catch (\PDOException $e) {
            header('Content-Type: application/json', true, 500);
            echo json_encode(['error' => 'PDOException: ' . $e->getMessage()]);
        } finally {
            exit;
        }
    }
    public function createEmployeeForm()
    {
        $departments = Department::model()->all();
        $roles = Role::model()->all();

        $headerTitle = 'Create Employee';
        return View::render('admin.employees.create', ['departments' => $departments, 'roles' => $roles], $headerTitle, $message = null, $messageCode = null, 200);
    }

    public function createEmployee($request)
    {
        if (isset($request)) {
            $employee = new User();
            $employee->first_name = $this->parseInput($request['first_name']);
            $employee->last_name = $this->parseInput($request['last_name']);
            $employee->gender = $this->parseInput($request['gender']);
            $employee->department_id = $this->parseInput($request['department_id']);
            $employee->email = $this->parseInput($request['email']);
            $password = $this->parseInput($request['password']);
            $confirm_password = $this->parseInput($request['confirm_password']);
            $employee->password = password_hash($password, PASSWORD_DEFAULT);
            $employee->role_id = $this->parseInput($request['role_id']);
            $employee->status = isset($request['status']) == true ? 'active' : 'disabled';
            // Dummy way for verify token 
            $employee->verify_token = md5(rand());
            $employee->verify_status = $this->parseInput($request['verify_status']);

            if ($password == $confirm_password) {
                $response = $employee->save();
                if ($response['status'] === 'error') {
                    echo json_encode(['status' => 'danger', 'message' => $response['message'], 'redirect' => false]);
                } else if ($response['status'] === 'success') {
                    echo json_encode(['status' => 'success', 'message' => $response['message'], 'redirect' => '/admin/employees']);
                }
                exit();
            } else {
                echo json_encode(['status' => 'danger', 'message' => "Password and Confirm Password does not match", 'redirect' => false]);
                exit();
            }
        }
    }

    public function updateEmployeeForm($id)
    {
        $idCheck = count(User::model()->where(['id' => $id])->get());
        if ($idCheck == 0) {
            View::redirect("/admin/employees", "Record not found", "warning", 302);
        }

        $employee = User::model()->where(['id' => $id])->get();
        $roles = Role::model()->get('name, id');
        $departments = Department::model()->get('name, id');

        $viewData = [
            'employee' => $employee,
            'roles' => $roles,
            'departments' => $departments
        ];
        $headerTitle = 'Edit Employee';
        if (isset($_SESSION['message']) && isset($_SESSION['message_code'])) {
            return View::render('admin.employees.edit', $viewData, $headerTitle, $_SESSION['message'], $_SESSION['message_code'], 200);
        }
        return View::render('admin.employees.edit', $viewData, $headerTitle, $message = null, $messageCode = null, 200);
    }


    public function show($id)
    {
        $idCheck = count(User::model()->where(['id' => $id])->get());
        if ($idCheck == 0) {
            View::redirect("/admin/employees", "Record not found", "warning", 302);
        }

        $employee = User::model()->where(['id' => $id])->get();
        $roles = Role::model()->get('name, id');
        $departments = Department::model()->get('name, id');

        $viewData = [
            'employee' => $employee,
            'roles' => $roles,
            'departments' => $departments
        ];
        $headerTitle = 'Show Employee';
        if (isset($_SESSION['message']) && isset($_SESSION['message_code'])) {
            return View::render('admin.employees.show', $viewData, $headerTitle, $_SESSION['message'], $_SESSION['message_code'], 200);
        }
        return View::render('admin.employees.show', $viewData, $headerTitle, $message = null, $messageCode = null, 200);
    }

    public function updateEmployee($id, $request)
    {
        if (isset($request) && isset($id)) {
            $employee = User::model()->find($id);
            if ($employee) {
                $employee->first_name = $this->parseInput($request['first_name']);
                $employee->last_name = $this->parseInput($request['last_name']);
                $employee->gender = $this->parseInput($request['gender']);
                $employee->department_id = $this->parseInput($request['department_id']);
                $employee->email = $this->parseInput($request['email']);
                $password = $this->parseInput($request['password']);
                $employee->password = password_hash($password, PASSWORD_BCRYPT);
                $employee->role_id = $this->parseInput($request['role_id']);
                $employee->status = isset($request['status']) == true ? 'active' : 'disabled';
                $employee->verify_status = $this->parseInput($request['verify_status']);

                if ($employee->update()) {
                    echo json_encode(['status' => 'success', 'message' => "Employee updated Successfully", 'redirect' => '/admin/employees']);
                } else {
                    echo json_encode(['status' => 'danger', 'message' => "Error occurred processing! contact administrator", 'redirect' => false]);
                }
                exit();
            } else {
                echo json_encode(['status' => 'danger', 'message' => "Employee Not Found!", 'redirect' => false]);
            }
        }
    }

    public function delete($id)
    {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $employees = User::model()->find($id);
            if (!$employees) {
                echo json_encode(['status' => 'warning', 'message' => 'employees not found', 'redirect' => false]);
                exit;
            }
            if ($employees->delete()) {
                echo json_encode(['status' => 'success', 'message' => 'Employee updated successfully', 'redirect' => false]);
            } else {
                echo json_encode(['status' => 'danger', 'message' => 'Error occurred while updating Employee', 'redirect' => '/admin/employeess']);
            }
            exit;
        }
    }
    private function parseInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

}