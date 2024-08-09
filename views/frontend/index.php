<?php
require __DIR__ ."/components/header.php"; // Header template

// echo "<pre/>";
// var_dump($viewResult->getViewPath());
// exit(0);
if($viewResult){
  // Try Listen to all of http Methods 
  $pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
  if ($pageWasRefreshed) {
      // Do something because page was refreshed
      $description = $Title;
      $request_resourse = __DIR__ . "/{$viewResult->getViewPath()->viewPath}.php";
  } else {
      // Handled by js clicks
      $description = $Title;
      $request_resourse = __DIR__ . "/{$viewResult->getViewPath()->viewPath}.php";
  }
  
  if (file_exists($request_resourse)) {
      $data = $viewResult->getViewData();
      $_SESSION['message'] = $viewResult->getMessage();
      $_SESSION['message_code'] = $viewResult->getMessageCode();
      require_once $request_resourse;
  } else {
      http_response_code(404);
      require_once __DIR__ . "/404.php";
  }
}

require __DIR__ ."/components/scripts.php"; // Layout scripts