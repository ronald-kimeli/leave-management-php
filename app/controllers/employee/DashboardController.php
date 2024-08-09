<?php

namespace app\controllers\employee;

use app\Responses\View;
use app\models\LeaveType;
use app\models\Department;
use app\models\AppliedLeave;
use app\controllers\Controller;
use app\models\User;

class DashboardController extends Controller
{

    public function employeeDashboard()
    {

        $email = $_SESSION['auth_user']['user_email'];
        $user = User::model()->where(['email' => $email])->get()[0];
        $departments = Department::model()->where(['id' => $user->department_id])->count();        
        $apply_leave = AppliedLeave::model()->where(['applied_by' => $user->id])->count();
        $leave_type = LeaveType::model()->count();
        $viewData = [
            'departments' => $departments,
            'apply_leave' => $apply_leave,
            'leave_type' => $leave_type,
        ];

        $headerTitle = 'Employee Dashboard';
        $message = isset($_SESSION['message']) ? $_SESSION['message'] : null;
        $messageCode = isset($_SESSION['message_code']) ? $_SESSION['message_code'] : null;

        return View::render('employee.dashboard', $viewData, $headerTitle, $message, $messageCode, 200);
    }

    public function logout($data)
    {
        if (isset($data['logout_btn']) && isset($_SESSION['auth_user']['user_email'])) {
            $this->destroySession();
            View::redirect("/", "Logged out successfully", "success", 302);
        }
    }

}
