<?php

namespace FDevs\RoutingBundle\Model;

use Symfony\Cmf\Component\Routing\RouteReferrersInterface;

interface ParentRoutingInterface extends RouteReferrersInterface
{
    /**
     * @return \FDevs\RoutingBundle\Doctrine\Mongodb\Route
     */
    public function getRoute();

    /**
     * @return \FDevs\RoutingBundle\Doctrine\Mongodb\Route[]
     */
    public function getRoutes();

    /**
     * @param array $routes
     *
     * @return self
     */
    public function setRoutes(array $routes);
}
