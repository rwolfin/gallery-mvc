<?php
class Router {
    public function route() {
        $action = $_GET['action'] ?? 'index';
        $controller = $_GET['controller'] ?? 'Gallery';

        $controllerClass = $controller . 'Controller';
        $controllerFile = '../app/controllers/' . $controllerClass . '.php';

        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            
            if (class_exists($controllerClass)) {
                $controllerInstance = new $controllerClass();
                
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $method = strtolower($_POST['method'] ?? $action);
                } else {
                    $method = $action;
                }
                
                if (method_exists($controllerInstance, $method)) {
                    $controllerInstance->$method();
                    return;
                }
            }
        }

        // Обработка 404
        header("HTTP/1.0 404 Not Found");
        echo 'Страница не найдена';
        exit;
    }
}