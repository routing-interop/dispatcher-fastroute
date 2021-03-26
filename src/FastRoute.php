<?php

namespace Interop\Routing\FastRoute;

use FastRoute\DataGenerator\GroupCountBased;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use FastRoute\RouteParser\Std;
use Interop\Routing\DispatcherInterface;
use Interop\Routing\Route\RouteCollection;
use Psr\Http\Message\ServerRequestInterface;

use function FastRoute\simpleDispatcher;

final class FastRoute implements DispatcherInterface
{
    private Dispatcher $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function addRoutes(RouteCollection $routes): self
    {
        $this->dispatcher = simpleDispatcher(function(RouteCollector $r) use ($routes) {
            foreach ($routes as $route) {
                foreach ($route->getMethods() as $method) {
                    $r->addRoute($method, $route->getPath(), $route->getHandler());
                }
            }
        });

        return $this;
    }

    public function dispatch(ServerRequestInterface $request): callable
    {
        return $this->dispatcher->dispatch($request->getMethod(), $request->getUri())[1];
    }
}
