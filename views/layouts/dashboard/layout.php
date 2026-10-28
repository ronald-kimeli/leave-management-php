<?php
/** @var \app\Responses\View|null $viewResult */
$viewResult ??= null;
// Shared dashboard shell for the admin and employee panels.
// Which panel is shown is decided by the view's directory; access is gated by role.

require __DIR__ . "/header.php"; // sets $Title and $role
/** @var string $Title */

if ($viewResult !== null) {
    $description = $Title;
    $section = $viewResult->getViewPath()->dir;
    $request_resourse = __DIR__ . "/../../{$section}/{$viewResult->getViewPath()->viewPath}.php";

    if (file_exists($request_resourse)) {
        /** @var object $data */
        $data = $viewResult->getViewData();
        $_SESSION['message'] = $viewResult->getMessage();
        $_SESSION['message_code'] = $viewResult->getMessageCode();
        include $request_resourse;
    } else {
        http_response_code(404);
        include __DIR__ . "/../../admin/404.php";
    }
}

require __DIR__ . "/scripts.php";
