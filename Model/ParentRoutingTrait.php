<?php

namespace FDevs\RoutingBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Routing\Route;

trait ParentRoutingTrait
{

    /**
     * @var ArrayCollection
     */
    protected $routes;

    /**
     * @param Route $route
     *
     * @return self
     */
    public function setRoute(Route $route)
    {
        $this->routes = new ArrayCollection();

        return $this->addRoute($route);
    }

    /**
     * @return Route
     */
    public function getRoute()
    {
        return $this->routes ? $this->routes->first() : null;
    }

    /**
     * @param Route $route
     *
     * @return $this
     */
    public function addRoute($route)
    {
        if (!$this->routes) {
            $this->routes = new ArrayCollection();
        }

        $this->routes->add($route);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function removeRoute($route)
    {
        $this->routes->removeElement($route);

        return $this;
    }

    /**
     * @param RouteObjectInterface[] $routes
     *
     * @return $this
     */
    public function setRoutes(array $routes)
    {
        foreach ($routes as $route) {
            $this->addRoute($route);
        }

        return $this;
    }

    /**
     * @return RouteObjectInterface[]
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    public function getFirstRoute()
    {
        return $this->routes->first();
    }
}
