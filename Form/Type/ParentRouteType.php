<?php

namespace FDevs\RoutingBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ParentRouteType extends AbstractType
{
    /**
     * @var string
     */
    private $className;

    /** @var string */
    private $parent;

    /**
     * init
     *
     * @param string $className
     */
    public function __construct($className, $parent)
    {
        $this->className = $className;
        $this->parent = $parent;
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'translation_domain' => 'FDevsRoutingBundle',
                'class' => $this->className
            ]
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'f_devs_parent_route';
    }
}
