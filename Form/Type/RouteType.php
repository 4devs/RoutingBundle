<?php

namespace FDevs\RoutingBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RouteType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', ['required' => false])
            ->add('parent', 'f_devs_parent_route', ['required' => false]);
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'translation_domain' => 'FDevsRoutingBundle',
                'data_class' => 'FDevs\RoutingBundle\Doctrine\Mongodb\Route'
            ]
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'fdevs_route';
    }
}
