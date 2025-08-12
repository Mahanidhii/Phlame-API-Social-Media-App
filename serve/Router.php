<?php

class Router {
    private $routes = [];

    public function addRoute($path, $callback, $method = 'GET') {
        $this->routes[] = [
            'path' => $path,
            'callback' => $callback,
            'method' => strtoupper($method)
        ];
    }

    public function route() {
        $basePath = dirname($_SERVER['SCRIPT_NAME']);
        if ($basePath === '/' || $basePath === '\\') {
            $basePath = '';
        }
        
        // 2. Get the full request URI (e.g., /Phlame/users/register)
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // 3. Remove the base path to get the clean route path (e.g., /users/register)
        $requestPath = substr($requestUri, strlen($basePath));
        if (empty($requestPath)) {
            $requestPath = '/';
        }

  
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            // Convert route path to a regex pattern
            $pattern = preg_replace('/<(\w+)>/', '(?P<$1>[^/]+)', $route['path']);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $requestPath, $matches) && $requestMethod === $route['method']) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                call_user_func_array($route['callback'], $params);
                return;
            }
        }

        // If no route is matched, include the 404 file using a reliable path.
        // It gets the 'serve' directory, goes up one level to 'Phlame', then finds '.config'.
        $projectRoot = dirname(__DIR__); 
        include($projectRoot . '/.config/_404.php');
        exit();
    }
}
