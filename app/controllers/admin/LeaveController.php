<?php

namespace app\controllers\admin;

use app\Responses\View;
use app\models\AppliedLeave;
use app\controllers\Controller;

class LeaveController extends Controller
{

    public function index()
    {
        $headerTitle = 'Applied Leaves';
        $message = isset($_SESSION['message']) ? $_SESSION['message'] : null;
        $messageCode = isset($_SESSION['message_code']) ? $_SESSION['message_code'] : null;

        return View::render('admin.appliedleaves.index', null, $headerTitle, $message, $messageCode, 200);
    }

    public function appliedLeaves()
    {
        try {
            $itemsPerPage = isset($_GET['perPage']) ? (int) $_GET['perPage'] : 5;
            if (isset($_GET['search']) && $_GET['search'] === '') {
                $query = AppliedLeave::model()->paginate($itemsPerPage);
            } else {
                $query = AppliedLeave::model()->whereLike(['description' => $_GET['search']])->paginate($itemsPerPage);
            }

            $query['data'] = array_map(function ($leave) {

                // $data = $leave->getAttributes();
                $data = [
                    'id' => $leave->getAttributes()['id'],
                    'description' => $leave->getAttributes()['description'],
                    'status' => $leave->getAttributes()['status'],
                ];

                if (method_exists($leave, 'leavetype')) {
                    $leavetype = $leave->leavetype()->getAttributes();
                    $data['leavetype'] = [
                        'name' => $leavetype['name'],
                    ];
                    // $leavetype;
                }

                if (method_exists($leave, 'applied_by')) {
                    $appliedBy = $leave->applied_by()->getAttributes();
                    $data['applied_by'] = [
                        'first_name' => $appliedBy['first_name'],
                        'last_name' => $appliedBy['last_name'],
                    ];
                    // $appliedBy;
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

    public function updateAppliedleaveForm($id)
    {
        $appliedLeave = appliedLeave::model()->where(['id' => $id])->get();

        $idCheck = count($appliedLeave);

        if ($idCheck == 0) {
            View::redirect("/admin/appliedleaves", "appliedLeave not found", "warning", 302);
        }

        $headerTitle = 'Edit appliedLeave';
        $message = isset($_SESSION['message']) ? $_SESSION['message'] : null;
        $messageCode = isset($_SESSION['message_code']) ? $_SESSION['message_code'] : null;

        return View::render('admin.appliedleaves.edit', ['appliedleave' => $appliedLeave], $headerTitle, $message, $messageCode, 200);
    }

    public function show($id)
    {
        $appliedLeave = appliedLeave::model()->where(['id' => $id])->get();

        $idCheck = count($appliedLeave);

        if ($idCheck == 0) {
            View::redirect("/admin/appliedleaves", "appliedLeave not found", "warning", 302);
        }

        $headerTitle = 'Show appliedLeave';
        $message = isset($_SESSION['message']) ? $_SESSION['message'] : null;
        $messageCode = isset($_SESSION['message_code']) ? $_SESSION['message_code'] : null;

        return View::render('admin.appliedleaves.show', ['appliedleave' => $appliedLeave], $headerTitle, $message, $messageCode, 200);
    }

    public function updateAppliedleave($id, $data)
    {
        if (isset($data['status']) && isset($id)) {
            $leave = AppliedLeave::model()->find($id);

            if ($leave) {
                $leave->status = $data['status'];
                $leave->from_date = $data['from_date'];
                $leave->to_date = $data['to_date'];
                $updateSuccessful = $leave->update();
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

                    if ($updateSuccessful) {
                        echo json_encode(['status' => 'success', 'message' => 'Applied Leave updated successfully', 'redirect' => '/admin/appliedleaves']);
                        exit;
                    } else {
                        echo json_encode(['status' => 'danger', 'message' => 'Error occurred while updating Applied Leave', 'redirect' => false]);
                        exit;
                    }
                } else {
                    if ($updateSuccessful) {
                        View::redirect("/admin/appliedleaves", "Applied Leave updated successfully!", "success", 302);
                    } else {
                        View::redirect("/admin/appliedleaves", "Error occurred while updating Applied Leave", "danger", 302);
                    }
                }
            } else {
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                    echo json_encode(['status' => 'danger', 'message' => 'Applied Leave Not Found!', 'redirect' => false]);
                    exit;
                } else {
                    View::redirect("/admin/appliedleaves", "Applied Leave Not Found!", "danger", 302);
                }
            }
        }
    }
}