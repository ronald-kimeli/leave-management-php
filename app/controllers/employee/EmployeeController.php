<?php

namespace app\controllers\employee;

use app\controllers\Controller;
use app\models\AppliedLeave;
use app\models\LeaveType;
use app\models\User;
use app\Responses\View;

class EmployeeController extends Controller
{
    public function employeeProfile()
    {
        $email = $_SESSION['auth_user']['user_email'];
        $user = User::model()->where(['email'=> $email])->get()[0]; 
        $viewData = [
            'user' => $user,
        ];

        $headerTitle = 'Employee Profile';
        return View::render('employee.profile', $viewData,  $headerTitle, $message = null, $messageCode = null, 200);
    }

    public function employeeDepartment()
    {
        $email = $_SESSION['auth_user']['user_email'];
        $department = User::model()->where(['email' => $email])->get()[0]->department;   
        $viewData = [
            'department' => $department,
        ];

        $headerTitle = 'Employee Department';
        return View::render('employee.department', $viewData,  $headerTitle, $message = null, $messageCode = null, 200);
    }

    public function employeeAppliedleaves()
    {
        $email = $_SESSION['auth_user']['user_email'];
        $user_id = User::model()->where(['email' => $email])->get('id')[0]->id; 
        $appliedleaves = AppliedLeave::model()->where(['applied_by' => $user_id])->get();

        $viewData = [
            'appliedleaves' => $appliedleaves,
        ];

        $headerTitle = 'Employee Appliedleaves';
        if (isset($_SESSION['message']) && isset($_SESSION['message_code'])) {
            return View::render('employee.appliedleaves', $viewData,$headerTitle, $_SESSION['message'],  $_SESSION['message_code'], 200);
        }
        return View::render('employee.appliedleaves', $viewData,  $headerTitle, $message = null, $messageCode = null, 200);
    }

    public function employeeLeavetypes()
    {

        $leaveTypes = LeaveType::model()->all();

        $viewData = [
            'leaveTypes' => $leaveTypes,
        ];

        $headerTitle = 'Employee Leave Types';
        return View::render('employee.leavetypes', $viewData, $headerTitle, null, null, 200);
    }


    public function leavetypes()
    {
        try {
            $perPage = isset($_GET['perPage']) ? (int) $_GET['perPage'] : 5;
            if (isset($_GET['search']) && $_GET['search'] === '') {
                $query = LeaveType::model()->paginate($perPage);
            } else {
                $query = LeaveType::model()->whereLike(['name' => $_GET['search']])->paginate($perPage);
            }

            $query['data'] = array_map(function ($entity) {
                return $entity->getAttributes();
            }, $query['data']);

            header('Content-Type: application/json');
            echo json_encode($query, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        } catch (\PDOException $e) {
            header('Content-Type: application/json', true, 500);
            echo json_encode(['error' => 'PDOException: ' . $e->getMessage()]);

        } catch (\Exception $e) {
            header('Content-Type: application/json', true, 500);
            echo json_encode(['error' => 'Exception: ' . $e->getMessage()]);

        } finally {
            exit;
        }
    }

    public function show($id)
    {
        $leavetype = LeaveType::model()->where(['id' => $id])->get();
        $idCheck = count($leavetype);

        if ($idCheck == 0) {
            View::redirect("/admin/leavetypes", "Leave Type not found", "warning", 302);
        }

        $headerTitle = 'Show Leave Type';
        $message = isset($_SESSION['message']) ? $_SESSION['message'] : null;
        $messageCode = isset($_SESSION['message_code']) ? $_SESSION['message_code'] : null;

        return View::render('employee.show', ['leavetype' => $leavetype], $headerTitle, $message, $messageCode, 200);
    }

    public function employeeApplyleaveForm()
    {
        $email = $_SESSION['auth_user']['user_email'];
        $user_id = User::model()->where(['email' => $email])->get('id')[0]->id; 
        $leave_type = LeaveType::model()->orderBy('created_at')->all();

        $viewData = [
            'leave_type' => $leave_type,
            'user_id' => $user_id,
        ];

        $headerTitle = 'Apply Leave Form';
        if (isset($_SESSION['message']) && isset($_SESSION['message_code'])) {
            return View::render('employee.applyleave', $viewData,$headerTitle, $_SESSION['message'],  $_SESSION['message_code'], 200);
        }
        return View::render('employee.applyleave', $viewData,  $headerTitle, $message = null, $messageCode = null, 200);
    }

    public function employeeApplyleave($request)
    {
        if (isset($request['apply_leave'])) {
            $leave = new AppliedLeave();
            $leave->applied_by = $this->parseInput($request['applied_by']);
            $leave->leavetype_id = $this->parseInput($request['leavetype_id']);
            $leave->description = $this->parseInput($request['description']);
            $leave->from_date = date('Y-m-d', strtotime($request['from_date']));
            $leave->to_date = date('Y-m-d', strtotime($request['to_date']));

            $response = $leave->save();
            if ($response['status'] === 'error') {
                View::redirect('/employee/appliedleaves', $response['message'], "danger", 302);
            } else if ($response['status'] === 'success') {
                View::redirect('/employee/appliedleaves', $response['message'], "success", 302);
            }
        }
    }

    public function employeeLogout($data)
    {
        if (isset($data['logout_btn']) && isset($_SESSION['auth_user']['user_email'])) {
            $this->destroySession();
            View::redirect("/", "Logged out successfully", "success", 302);
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
