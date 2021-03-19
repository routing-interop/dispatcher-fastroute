<?php

namespace Interop\Routing\FastRoute;

use FastRoute\Dispatcher;
use Interop\Routing\DispatcherInterface;
use Psr\Http\Message\ServerRequestInterface;

final class FastRoute implements DispatcherInterface
{
    private Dispatcher $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function dispatch(ServerRequestInterface $request): callable
    {
        return $this->dispatcher->dispatch($request->getMethod(), $request->getUri())[1];
    }
}
