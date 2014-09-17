<?php

namespace FDevs\RoutingBundle\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Cmf\Bundle\RoutingBundle\Model\Route;

class RouteManager
{
    /** @var ObjectManager */
    private $manager;
    /** @var string */
    private $class;

    public function __construct(ObjectManager $manager, $class)
    {
        $this->class = $class;
        $this->manager = $manager;
    }

    public function persist(Route $route)
    {
        $this->manager->persist($route);

        return $this;
    }

    /**
     * remove
     *
     * @param Route $route
     *
     * @return $this
     */
    public function remove(Route $route)
    {
        $this->manager->remove($route);

        return $this;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @return Route
     */
    public function createRoute()
    {
        $class = $this->getClass();
        /** @var \FDevs\RoutingBundle\Doctrine\Mongodb\Route $route */
        $route = new $class();

        return $route;
    }

    public function findOneBy(array $criteria)
    {
        return $this->manager->getRepository($this->class)->findOneBy($criteria);
    }

}
