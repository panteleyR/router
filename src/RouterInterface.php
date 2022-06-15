<?php

declare(strict_types=1);

namespace Lilith\Router;

use Lilith\Http\Message\RequestInterface;

interface RouterInterface
{
    public function findRoute(string|RequestInterface $request): array;
    public function setRoutes(array $routes): void;
}
