<?php

namespace app\controllers\admin;

use app\Responses\View;
use app\models\Department;

use app\controllers\Controller;

class DepartmentController extends Controller
{

    public function index()
    {
        $departments = Department::model()->all();
        $viewData = [
            'departments' => $departments,
        ];

        $headerTitle = 'Departments';
        $message = isset($_SESSION['message']) ? $_SESSION['message'] : null;
        $messageCode = isset($_SESSION['message_code']) ? $_SESSION['message_code'] : null;

        return View::render('admin.departments.index', $viewData, $headerTitle, $message, $messageCode, 200);
    }



    public function getDepartments()
    {
        try {
            $itemsPerPage = isset($_GET['perPage']) ? (int) $_GET['perPage'] : 5;

            if (!empty($_GET['search'])) {
                $query = Department::model()->whereLike(['name' => $_GET['search']])->paginate($itemsPerPage);
            } else {
                $query = Department::model()->paginate($itemsPerPage);
            }

            $query['data'] = array_map(function ($department) {
                $data = [
                    'id' => $department->getAttributes()['id'],
                    'name' => $department->getAttributes()['name'],
                    'description' => $department->getAttributes()['description'],
                ];

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


    public function createDepartmentForm()
    {
        $headerTitle = 'Create Department';
        $message = isset($_SESSION['message']) ? $_SESSION['message'] : null;
        $messageCode = isset($_SESSION['message_code']) ? $_SESSION['message_code'] : null;
        return View::render('admin.departments.create', null, $headerTitle, $message, $messageCode, 200);
    }

    public function createDepartment($request)
    {
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
            if (isset($request)) {
                $department = new Department();
                $department->name = $this->parseInput($request['department_name']);
                $department->description = $this->parseInput($request['description']);
            
                    $response = $department->save();
                    if ($response['status'] === 'error') {
                        echo json_encode(['status' => 'danger', 'message' => $response['message'], 'redirect' => false]);
                    } else if ($response['status'] === 'success') {
                        echo json_encode(['status' => 'success', 'message' => 'Leave Type added successfully', 'redirect' => '/admin/departments']);
                    }
                    exit();
            }
        }else if (isset($request['name']) && isset($request['description']) && isset($request['add_dept'])) {
            $departmentCheck = Department::model()->where(["name" => $request['department_name']])->get();
            $departmentExists = count($departmentCheck);

            if ($departmentExists == 0) {
                $department = new Department();

                $newDepartment = $department->create([
                    'name' => $request['department_name'],
                    'description' => $request['description'],
                ]);

                if ($newDepartment) {
                    View::redirect('/admin/departments', "Department Added Successfully!", "success", 302);
                } else {
                    View::redirect("/admin/department/create", "Error occurred processing! Contact administrator", "warning", 302);
                }
            } else {
                View::redirect('/admin/departments', "Department name is already taken!", "danger", 302);
            }
        }
    }

    public function updateDepartmentForm($id)
    {
        $department = Department::model()->where(['id' => $id])->get();

        if (count($department) == 0) {
            View::redirect("/admin/departments", "Department not found", "warning", 302);
        }

        $headerTitle = 'Edit Department';
        $message = isset($_SESSION['message']) ? $_SESSION['message'] : null;
        $messageCode = isset($_SESSION['message_code']) ? $_SESSION['message_code'] : null;

        return View::render('admin.departments.edit', ['department' => $department], $headerTitle, $message, $messageCode, 200);
    }
    public function show($id)
    {
        $department = Department::model()->where(['id' => $id])->get();
        if (count($department) == 0) {
            View::redirect("/admin/departments", "Department not found", "warning", 302);
        }

        $headerTitle = 'Show Department';
        return View::render('admin.departments.show', ['department' => $department], $headerTitle, null, null, 200);
    }

    public function updateDepartment($id, $data)
    {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $department = Department::model()->find($id);

            if (!$department) {
                echo json_encode(['status' => 'warning', 'message' => 'Department not found', 'redirect' => false]);
                exit;
            }

            $department->name = $data['dname'];
            $department->description = $data['description'];
            if ($department->update()) {
                echo json_encode(['status' => 'success', 'message' => 'Department updated successfully', 'redirect' => '/admin/departments']);
            } else {
                echo json_encode(['status' => 'danger', 'message' => 'Error occurred while updating department', 'redirect' => "/admin/department/update/{$id}"]);
            }
            exit;
        } else {
            // Handle non-AJAX request
            $departmentCheck = Department::model()->where(['id' => $id])->get();

            if (!$departmentCheck) {
                View::redirect("/admin/departments", "Department not found", "warning", 302);
            }

            $department = new Department();
            $department->id = $this->parseInput($id);
            $department->name = $this->parseInput($data['name']);
            $department->description = $this->parseInput($data['description']);

            if ($department->update()) {
                View::redirect("/admin/departments", "Department updated successfully!", "success", 302);
            } else {
                View::redirect("/admin/departments", "Error occurred while updating department", "danger", 302);
            }
        }
    }

    public function delete($id)
    {

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $department = Department::model()->find($id);
            if (!$department) {
                echo json_encode(['status' => 'warning', 'message' => 'Department not found', 'redirect' => false]);
                exit;
            }
            if ($department->delete()) {
                echo json_encode(['status' => 'success', 'message' => 'Department updated successfully', 'redirect' => '/admin/departments']);
            } else {
                echo json_encode(['status' => 'danger', 'message' => 'Error occurred while updating department', 'redirect' => "/admin/department/update/{$id}"]);
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
