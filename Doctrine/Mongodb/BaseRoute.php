<?php

namespace FDevs\RoutingBundle\Doctrine\Mongodb;

use Symfony\Cmf\Bundle\RoutingBundle\Model\Route as RouteModel;

class BaseRoute extends RouteModel
{
    /** @var string */
    protected $name;

    /** @var Route */
    protected $parent;

    /**
     * @param Route $parent
     *
     * @return $this
     */
    public function setParent(Route $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Route
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name ?: 'New Route';
    }

}
