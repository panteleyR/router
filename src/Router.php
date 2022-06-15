<?php

declare(strict_types=1);

namespace Lilith\Router;

use Lilith\Http\Message\RequestInterface;

class Router implements RouterInterface
{
    protected array $routes = [];

    public function findRoute(string|RequestInterface $request): array
    {
        foreach ($this->routes as $route => $routeConfig) {
            if (is_string($request) && $route !== $request) {
                continue;
            }

            if ($routeConfig['uri'] !== $request->getUri()) {
                continue;
            }

            return explode('::', $routeConfig['handler']);
        }

        throw new \Exception('route not found');
    }

    public function setRoutes(array $routes): void
    {
        $this->routes = $routes;
    }
}
