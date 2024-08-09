<?php

namespace app\models;

class Router
{
    protected static $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => [],
    ];

    protected static $middleware = [];
    protected static $middlewareGroups = [];

    public static function get(string $path, array $handler)
    {
        self::$routes['GET'][$path] = $handler;
        return new static(); // Return a new instance for method chaining
    }

    public static function post(string $path, array $handler)
    {
        self::$routes['POST'][$path] = $handler;
        return new static();
    }


    public static function put(string $path, array $handler)
    {
        self::$routes['PUT'][$path] = $handler;
        return new static();
    }

    public static function delete(string $path, array $handler)
    {
        self::$routes['DELETE'][$path] = $handler;
        return new static();
    }

    public static function middleware($middleware)
    {
        self::$middleware[] = $middleware;
        return new static();
    }

    public static function group($middlewareGroup, $callback)
    {
        self::$middlewareGroups[$middlewareGroup] = self::$middleware;
        self::$middleware = [];
        $callback();
        self::$middleware = self::$middlewareGroups[$middlewareGroup];
        unset(self::$middlewareGroups[$middlewareGroup]);
    }

    // Automatically handle requests upon instantiation
    public function __construct()
    {
        // Handle the request
        $this->handleRequest();
    }

    protected function handleRequest()
    {
        // Parse the request URI to extract path and query parameters
        $parsed_url = parse_url($_SERVER['REQUEST_URI']);
        $path = $parsed_url['path'];
        $query_params = isset($parsed_url['query']) ? self::parseQueryParams($parsed_url['query']) : [];

        // Apply middleware
        foreach (self::$middleware as $middleware) {
            // Check if middleware is a class name and instantiate it
            $middlewareInstance = is_string($middleware) ? new $middleware() : $middleware;

            if (!$middlewareInstance->handle($path, $_SERVER['REQUEST_METHOD'])) {
                // Middleware stopped further execution
                return;
            }
        }

        // Check if the route exists for the requested method
        $request_method = isset($_POST['_method']) ? strtoupper($_POST['_method']) : $_SERVER['REQUEST_METHOD'];

        if (isset(self::$routes[$request_method])) {
            foreach (self::$routes[$request_method] as $route => $handler) {
                // Check if the route matches the requested 
                if (self::routeMatches($route, $path)) {
                    // Extract route parameters
                    $params = self::extractRouteParams($route, $path);
                    // Call the appropriate method based on the request method
                    self::executeRoute($handler, $params, $query_params, $path, $request_method);
                    return;
                }
            }
        } else {
            // If route is not found, show error page
            self::showErrorPage(404); // Not Found
        }
    }

    protected static function routeMatches($route, $path)
    {
        // Split the route and path into segments
        $routeSegments = explode('/', trim($route, '/'));
        $pathSegments = explode('/', trim($path, '/'));

        // Check if the number of segments match
        if (count($routeSegments) !== count($pathSegments)) {
            return false;
        }

        // Iterate over each segment and check for matches
        foreach ($routeSegments as $index => $segment) {
            // If the segments don't match and it's not a parameter, return false
            if ($segment !== $pathSegments[$index] && strpos($segment, '{') !== 0) {
                return false;
            }
        }

        // All segments match or are parameters, return true
        return true;
    }

    protected static function executeRoute($handler, $params, $query_params, $request_uri, $request_method)
    {

        $controllerNamespace = $handler['controller'];
        $method = $handler['method'];

        // Instantiate the controller
        $controllerInstance = new $controllerNamespace();

            // Call the appropriate method based on the request method
            if (method_exists($controllerInstance, $method)) {
                // Determine which server data to pass based on the request method
                switch ($request_method) {
                    case 'GET':
                        $data = null;
                        break;
                    case 'POST':
                        $data = $_POST;
                        break;
                    case 'PUT':
                        // For PUT requests, parse request body as URL-encoded form data
                        parse_str(file_get_contents('php://input'), $data);
                        break;
                    case 'DELETE':
                        $data = null;
                        break;
                    default:
                        $data = null;
                }
                // Call the controller method and capture its returned value
                // $viewResult = call_user_func_array([$controllerInstance, $method], $params ? array_merge(array_values($params), [$data]) : [$data]);

                // Define parameters array based on conditions
                if ($params) {
                    if ($data === null) {
                        // Only $id is available
                        $parameters = array_values($params);
                        // [$params];
                    } else {
                        // $id and $data are available
                        if ($query_params) {
                            // $query_params are also available
                            $parameters = array_merge(array_values($params),  [$data], [$query_params]);
                            // array_merge([$params, $data], [$query_params]);
                        } else {
                            // $query_params are not available
                            $parameters = array_merge(array_values($params), [$data]);
                        }
                    }
                } else {
                    if ($data) {
                        // Only $data is available
                        if ($query_params) {
                            // $query_params are also available
                            $parameters = array_merge([$data], [$query_params]);
                        } else {
                            // $query_params are not available
                            $parameters = [$data];
                        }
                    } else {
                        // No $params or $data available
                        if ($query_params) {
                            // $query_params are also available
                            $parameters =  [$query_params];
                        } else {
                            // $query_params are not available
                            $parameters = [];
                        }
                    }
                }

                // var_dump($params); die();

                // Call the controller method with the determined parameters
                $viewResult = call_user_func_array([$controllerInstance, $method], $parameters);
                
                // $viewResult = call_user_func_array([$controllerInstance, $method], $params ? array_merge(array_values($params), [$query_params], [$data]) : [$query_params, $data]);
                if ($viewResult !== null) {
                    // Forward the view to admin/index.php
                    self::forwardViewToIndex( $viewResult, $request_uri, $request_method);
                    exit();
                }

            } else {
                self::showErrorPage(405); // Method Not Allowed
                exit();
            }
    }

    private static function showErrorPage($error)
    {
        $route_file = __DIR__ . "/../../views/frontend/views/{$error}.php";
        if (file_exists($route_file)) {
            require $route_file;
        } else {
            // Default error handling
            http_response_code($error);
            // echo "$error Error";
        }
    }

    protected static function forwardViewToIndex($viewResult , $request_uri, $request_method)
    {

        $dirName = $viewResult->getViewPath()->dir;
        
         // Include the index.php file dynamically(acts as slot layout)
        require __DIR__ . "/../../views/$dirName/index.php";
        exit();
    }
    protected static function extractRouteParams(string $route, string $path): array
    {
        $params = [];
        $routeSegments = explode('/', trim($route, '/'));
        $pathSegments = explode('/', trim($path, '/'));
        foreach ($routeSegments as $index => $segment) {
            if (strpos($segment, '{') === 0 && preg_match('/\{(\w+)(:.*?)?\}/', $segment, $matches)) {
                // Parameter segment with optional type
                $paramName = $matches[1];
                if (isset($pathSegments[$index])) {
                    $params[$paramName] = $pathSegments[$index];
                }
            }
        }
        return $params;
    }

    protected static function parseQueryParams($query)
    {
        // Parse query parameters
        parse_str($query, $params);
        return $params;
    }
}
