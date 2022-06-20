<?php

declare(strict_types=1);

namespace Lilith\Router;

use Lilith\DependencyInjection\ContainerInterface;
use Lilith\Http\Message\RequestInterface;
use Lilith\Http\Message\ResponseInterface;

interface RouterInterface
{
    public function findRoute(RequestInterface $request): array;
    public function execute(ContainerInterface $container, RequestInterface $request): ResponseInterface;
    public function setRoutes(array $routes): void;
}
