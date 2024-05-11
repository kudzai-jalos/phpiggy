<?php

declare(strict_types=1);

namespace Framework;

class Router {
    private array $routes = [];

    public function add(string $method, string $path, array $controller) {
        $path = $this->normilizePath($path);
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'controller' => $controller
        ];
    }

    private function normilizePath(string $path): string {
        $path = "/{$path}/";;
        $path = preg_replace("#[/]{2,5}#","/",$path);
        
        return $path;
    }

    public function dispatch(string $path, string $method) {
        $path = $this->normilizePath($path);
        $method = strtoupper($method);

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method || !preg_match("#^{$route['path']}$#", $path)) {
                continue;
            }

            [$class, $function] = $route['controller'];

            $controllerInstance = new $class;
            $controllerInstance->{$function}();
        }

    }
}
