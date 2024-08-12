<?php
namespace app\controllers\admin;

use app\controllers\Controller;
use app\models\AppliedLeave;
use app\models\Department;
use app\models\LeaveType;
use app\models\User;
use app\Responses\View;

class DashboardController extends Controller
{
    public function profile()
    {
        $email = $_SESSION['auth_user']['user_email'];
        $user = User::model()->where(['email' => $email])->get('first_name,last_name,email');
   
        $headerTitle = 'Admin Profile';
        return View::render('admin.profile', ['user' => $user], $headerTitle, $message = null, $messageCode = null, 200);
    }

    // Method to handle the admin dashboard action
    public function dashboard()
    {
        // $employees = User::model()->get('gender,department_id,status,role_id');
        // $employees = array_map(function ($employee) {

        //     $data = [
        //         'gender' => $employee->getAttributes()['gender'],
        //         'status' => $employee->getAttributes()['status'],
        //     ];

        //     if (method_exists($employee, 'role')) {
        //         $role = $employee->role()->getAttributes();
        //         $data['role'] = $role['name'];
        //     }

        //     if (method_exists($employee, 'department')) {
        //         $department = $employee->department()->getAttributes();
        //         $data['department'] = $department['name'];
        //     }

        //     return $data;
        // }, $employees);

        $employees = User::model()->count();

        $departments = Department::model()->count();

        $apply_leave = AppliedLeave::model()->count();

        $leave_type = LeaveType::model()->count();

        $viewData = [
            'employees' => $employees,
            'departments' => $departments,
            'apply_leave' => $apply_leave,
            'leave_type' => $leave_type,
        ];

        $headerTitle = 'Admin Dashboard';
        $message = isset($_SESSION['message']) ? $_SESSION['message'] : null;
        $messageCode = isset($_SESSION['message_code']) ? $_SESSION['message_code'] : null;

        return View::render('admin.dashboard', $viewData, $headerTitle, $message, $messageCode, 200);
    }

    public function logout()
    {
        if (isset($_SESSION['auth_user']['user_email'])) {
            $this->destroySession();
            echo json_encode(['status' => 'success', 'message' => 'Logged out successfully', 'redirect' => '/login']);
            exit;
            // View::redirect("/", "Logged out successfully", "success", 302);
        }
    }
}
