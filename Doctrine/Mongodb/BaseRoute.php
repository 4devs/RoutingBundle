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

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize([
            'host'             => $this->getHost(),
            'defaults'         => $this->getDefaults(),
            'requirements'     => $this->getRequirements(),
            'options'          => $this->getOptions(),
            'schemes'          => $this->getSchemes(),
            'methods'          => $this->getMethods(),
            'condition'        => $this->getCondition(),
            'name'             => $this->getName(),
            'static_prefix'    => $this->getStaticPrefix(),
            'variable_pattern' => $this->getVariablePattern(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        $data = unserialize($serialized);
        $this->getVariablePattern($data['variable_pattern']);
        $this->setStaticPrefix($data['static_prefix']);
        $this->setHost($data['host']);
        $this->setDefaults($data['defaults']);
        $this->setRequirements($data['requirements']);
        $this->setOptions($data['options']);
        $this->setSchemes($data['schemes']);
        $this->setMethods($data['methods']);
        $this->setName($data['name']);

        if (isset($data['condition'])) {
            $this->setCondition($data['condition']);
        }
    }

}
