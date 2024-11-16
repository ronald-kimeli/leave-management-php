<?php
namespace app\controllers\admin;

use app\Responses\View;
use app\models\LeaveType;
use app\controllers\Controller;

class LeaveTypeController extends Controller
{
    public function index()
    {
        $headerTitle = 'Leave Types';
        $message = isset($_SESSION['message']) ? $_SESSION['message'] : null;
        $messageCode = isset($_SESSION['message_code']) ? $_SESSION['message_code'] : null;

        return View::render('admin.leavetypes.index', null, $headerTitle, $message, $messageCode, 200);
    }

    public function leavetypes()
    {
        try {
            $perPage = isset($_GET['perPage']) ? (int) $_GET['perPage'] : 10;
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

    public function createLtypeForm()
    {
        $headerTitle = 'Create Leave Type';
        return View::render('admin.leavetypes.create', $viewData = null, $headerTitle, null, $messageCode = null, 200);
    }

    public function createLtype($request)
    {
        if (isset($request)) {
            $leaveType = new LeaveType();
            $leaveType->name = $this->parseInput($request['leave_type_name']);
            $leaveType->description = $this->parseInput($request['description']);

            $response = $leaveType->save();
            if ($response['status'] === 'error') {
                echo json_encode(['status' => 'danger', 'message' => $response['message'], 'redirect' => false]);
            } else if ($response['status'] === 'success') {
                echo json_encode(['status' => 'success', 'message' => 'Leave Type added successfully', 'redirect' => '/admin/leavetypes']);
            }
            exit();
        }
    }

    public function updateLeaveTypeForm($id)
    {
        $leavetype = LeaveType::model()->where(['id' => $id])->get();
        $idCheck = count($leavetype);

        if ($idCheck == 0) {
            View::redirect("/admin/leavetypes", "Leave Type not found", "warning", 302);
        }

        $headerTitle = 'Edit Leave Type';
        $message = isset($_SESSION['message']) ? $_SESSION['message'] : null;
        $messageCode = isset($_SESSION['message_code']) ? $_SESSION['message_code'] : null;

        return View::render('admin.leavetypes.edit', ['leavetype' => $leavetype], $headerTitle, $message, $messageCode, 200);
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

        return View::render('admin.leavetypes.show', ['leavetype' => $leavetype], $headerTitle, $message, $messageCode, 200);
    }

    public function updateLeaveType($id, $request)
    {
        // Check if the request is AJAX
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $leaveType = LeaveType::model()->find($id);

            if (!$leaveType) {
                echo json_encode(['status' => 'warning', 'message' => 'Leave Type not found', 'redirect' => false]);
                exit;
            }

            // Update the LeaveType record
            $leaveType->name = $request['leave_type_name']; // Use 'name' instead of 'leave_type'
            $leaveType->description = $request['description'];

            if ($leaveType->update()) {
                echo json_encode(['status' => 'success', 'message' => 'Leave Type updated successfully', 'redirect' => '/admin/leavetypes']);
            } else {
                echo json_encode(['status' => 'danger', 'message' => 'Error occurred while updating Leave Type', 'redirect' => false]);
            }
            exit;
        } else {
            // Handle non-AJAX request
            $leaveTypeCheck = LeaveType::model()->where(['id' => $id])->get();

            if (!$leaveTypeCheck) {
                View::redirect("/admin/leavetypes", "Leave Type not found", "warning", 302);
            }

            $leaveType = new LeaveType();
            $leaveType->id = $this->parseInput($id);
            $leaveType->name = $this->parseInput($request['leave_type_name']); // Use 'name' instead of 'leave_type'
            $leaveType->description = $this->parseInput($request['description']);

            if ($leaveType->update()) {
                View::redirect("/admin/leavetypes", "Leave Type updated successfully!", "success", 302);
            } else {
                View::redirect("/admin/leavetypes", "Error occurred while updating Leave Type", "danger", 302);
            }
        }
    }

    public function delete($id)
    {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $leavetpe = LeaveType::model()->find($id);
            if (!$leavetpe) {
                echo json_encode(['status' => 'warning', 'message' => 'Leave Type not found', 'redirect' => false]);
                exit;
            }
            if ($leavetpe->delete()) {
                echo json_encode(['status' => 'success', 'message' => 'Leave Type deleted successfully', 'redirect' => '/admin/leavetypes']);
            } else {
                echo json_encode(['status' => 'danger', 'message' => 'Error occurred while deleting Leave Type', 'redirect' => false]);
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
