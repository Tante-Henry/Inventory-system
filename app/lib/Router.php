<?php
class Router
{
    public function dispatch($uri)
    {
        $path = trim(parse_url($uri, PHP_URL_PATH), '/');
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
