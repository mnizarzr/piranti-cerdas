<?php

namespace Src;


class Route
{

    public function handle($method, $path, $routes)
    {
        foreach ($routes as $route) {
            if ($route['method'] === $method && $route['path'] === $path) {
                return $route['handler']();
            }
        }

        http_response_code(404);
        echo 'Not Found';
    }
}
