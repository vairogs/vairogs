<?php declare(strict_types = 1);

namespace Vairogs\Component\Functions\Web;

use Symfony\Component\Routing\RouterInterface;

trait _RouteExists
{
    public function routeExists(
        RouterInterface $router,
        string $route,
    ): bool {
        return null !== $router->getRouteCollection()->get(name: $route);
    }
}
