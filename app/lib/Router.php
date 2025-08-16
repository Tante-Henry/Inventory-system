<?php
class Router
{
    private $routes = [
        'GET' => [
            'items' => 'ItemController@index',
            'items/{id}' => 'ItemController@show',
            'items/create' => 'ItemController@create',
            'items/{id}/edit' => 'ItemController@edit',
        ],
        'POST' => [
            'items' => 'ItemController@store',
            'items/{id}' => 'ItemController@update',
            'items/{id}/delete' => 'ItemController@destroy',
        ],
    ];

    public function dispatch($uri)
    {
        $path = trim(parse_url($uri, PHP_URL_PATH), '/');
        $httpMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        if (isset($this->routes[$httpMethod])) {
            foreach ($this->routes[$httpMethod] as $route => $action) {
                $paramNames = [];
                $pattern = '#^' . preg_replace_callback('#\{([^/]+)\}#', function ($m) use (&$paramNames) {
                    $paramNames[] = $m[1];
                    return '([^/]+)';
                }, $route) . '$#';
                if (preg_match($pattern, $path, $matches)) {
                    array_shift($matches);
                    $params = array_combine($paramNames, $matches);
                    list($controllerName, $method) = explode('@', $action);
                    $controllerFile = __DIR__ . '/../controllers/' . $controllerName . '.php';
                    if (file_exists($controllerFile)) {
                        $controller = new $controllerName();
                        if (method_exists($controller, $method)) {
                            call_user_func_array([$controller, $method], array_values($params));
                            return;
                        }
                    }
                }
            }
        }

        $segments = $path === '' ? [] : explode('/', $path);

        $controllerName = !empty($segments[0]) ? ucfirst($segments[0]) . 'Controller' : 'HomeController';
        $method = $segments[1] ?? 'index';
        $params = array_slice($segments, 2);

        $controllerFile = __DIR__ . '/../controllers/' . $controllerName . '.php';
        if (file_exists($controllerFile)) {
            $controller = new $controllerName();
            if (method_exists($controller, $method)) {
                call_user_func_array([$controller, $method], $params);
                return;
            }
        }

        header('HTTP/1.0 404 Not Found');
        echo '404 Not Found';
    }
}
