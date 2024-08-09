<?php

namespace app\Responses;

class View
{
    private $viewPath;
    private $viewData;
    private $headerTitle;
    private $message;
    private $messageCode;
    private $statusCode;

    public function __construct($viewPath, $viewData,$headerTitle = null, $message = null, $messageCode = null, $statusCode = 200)
    {
        $pathData = $this->getDirViewPath($viewPath);
        $this->viewPath = $pathData;
        $this->viewData = (object) $viewData;
        $this->headerTitle = $headerTitle;
        $this->message = $message;
        $this->messageCode = $messageCode;
        $this->statusCode = $statusCode;
    }

    public function getviewPath()
    {
        return $this->viewPath;
    }

    private function getDirViewPath($dynamicString)
    {
        $parts = explode('.', $dynamicString);
        $dir = array_shift($parts); 
        $viewPath = implode('/', $parts);

        return (object) [
            'dir' => $dir,
            'viewPath' => $viewPath
        ];
    }

    public function getViewData()
    {
        return $this->viewData;
    }

    public function getHeaderTitle()
    {
        return $this->headerTitle;
    }
    public function getMessage()
    {
        return $this->message;
    }

    public function getMessageCode()
    {
        return $this->messageCode;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public static function render($viewPath, $viewData = [],$headerTitle = null, $message = null,  $messageCode = null, $statusCode = 200)
    {
        return new self($viewPath, $viewData, $headerTitle,$message,  $messageCode, $statusCode);
    }

    public static function redirect($url, $message = null, $messageCode = null, $statusCode = 302)
    {
        // Ensure that we don't redirect to the same URL to avoid infinite loop
        // if ($_SERVER['REQUEST_URI'] === $url) {
        //     throw new \Exception('Infinite loop detected.');
        // }

        // Check if the URL is relative
        if (strpos($url, '://') === false && substr($url, 0, 1) !== '/') {
            // If it's not absolute, construct the absolute URL
            $redirectUrl = rtrim($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']), '/') . '/' . ltrim($url, '/');
        } else {
            $redirectUrl = $url;
        }

        $_SESSION['message'] = $message;
        $_SESSION['message_code'] = $messageCode;
        header("Location: $redirectUrl", true, $statusCode);
        exit();
    }
}
