<?php
require __DIR__ . "/../employee/components/header.php";

if ($viewResult) {
    $description = $Title;
    $request_resourse = __DIR__ . "/{$viewResult->getViewPath()->viewPath}.php";

    if (file_exists($request_resourse)) {
        $data = $viewResult->getViewData();
        $_SESSION['message'] = $viewResult->getMessage();
        $_SESSION['message_code'] = $viewResult->getMessageCode();
        include $request_resourse;
    } else {
        http_response_code(404);
        include __DIR__ . "/404.php";
    }
}

require __DIR__ . "/../employee/components/scripts.php"; 