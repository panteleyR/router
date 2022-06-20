<?php

declare(strict_types=1);

namespace Lilith\Router;

use Lilith\DependencyInjection\ContainerInterface;
use Lilith\Http\Message\RequestInterface;
use Lilith\Http\Message\ResponseInterface;
use Lilith\Http\Parser\HttpRequestParser;

class Router implements RouterInterface
{
    protected array $routes = [];

    public function execute(ContainerInterface $container, RequestInterface $request): ResponseInterface
    {
        [$class, $method, $args] = $this->findRoute($request);

        return $container->get($class)->{$method}($request, ...$args);
    }

    public function findRoute(RequestInterface $request): array
    {
        $uri = HttpRequestParser::parseUri($request);

        foreach ($this->routes as $route => $routeConfig) {
            $routePattern = '/' . addcslashes(preg_replace(
                '/\/:(\w+)/',
                '/(\w+)',
                $routeConfig
            ), '/') . '/';
            $foundCount = preg_match($routePattern, $uri->getPath(), $matches);
            unset($matches[0]);

            if ($request->getMethod() === $routeConfig['method'] && $foundCount === 1) {
                $route = explode('::', $routeConfig['handler']);
                $route[] = $matches;

                return $route;
            }
        }

        throw new \Exception('Route not found');
    }

    public function setRoutes(array $routes): void
    {
        $this->routes = $routes;
    }
}
