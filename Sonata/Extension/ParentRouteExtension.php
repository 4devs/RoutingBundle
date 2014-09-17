<?php

namespace FDevs\RoutingBundle\Sonata\Extension;

use Cocur\Slugify\Slugify;
use FDevs\PageBundle\Service\ChoiceText;
use FDevs\RoutingBundle\Model\ParentRoutingInterface;
use FDevs\RoutingBundle\Service\RouteManager;
use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class ParentRouteExtension extends AdminExtension
{

    /** @var RouteManager */
    private $routeManager;

    private $requirementsRoute = [];

    /**
     * {@inheritDoc}
     */
    public function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('form.group_routes', ['translation_domain' => 'FDevsRoutingBundle'])
            ->add(
                'routes',
                'collection',
                ['type' => 'fdevs_route', 'allow_add' => true, 'label' => false, 'options' => ['label' => false]]
            )
            ->end()
        ;
        $formMapper->getFormBuilder()
            ->addEventListener(
                FormEvents::PRE_SUBMIT,
                function (FormEvent $event) {
                    $data = $event->getData();
                    if (!empty($data['page']) && !empty($data['page']['title'])) {
                        $sl = new Slugify();
                        $name = $sl->slugify(ChoiceText::getFirstText($data['page']['title']));
                        foreach ($data['routes'] as $key => $routes) {
                            if (empty($routes['name'])) {
                                $data['routes'][$key]['name'] = $name;
                            }
                        }
                        $event->setData($data);
                    }
                }
            );
    }

    /**
     * {@inheritDoc}
     */
    public function alterNewInstance(AdminInterface $admin, $object)
    {
        /** @var \Symfony\Cmf\Bundle\RoutingBundle\Model\Route $route */
        $route = $this->routeManager->createRoute();
        $route->setOption('add_locale_pattern', true);
        $route->setOption('add_format_pattern', true);
        $route->setRequirement('_format', 'html');
        $object->addRoute($route);

        $route->setContent($object);
    }

    /**
     * {@inheritDoc}
     */
    public function prePersist(AdminInterface $admin, $object)
    {
        $this->updateRoutes($object);
    }

    /**
     * {@inheritDoc}
     */
    public function preRemove(AdminInterface $admin, $object)
    {
        $this->removeRoutes($object);
    }

    /**
     * {@inheritDoc}
     */
    public function preUpdate(AdminInterface $admin, $object)
    {
        $this->updateRoutes($object);
    }

    /**
     * {@inheritDoc}
     */
    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('routes', null, array('associated_property' => 'path'));
    }

    /**
     * set Requirements Locale
     *
     * @param string $locale
     *
     * @return $this
     */
    public function setRequirementsLocale($locale)
    {
        $this->requirementsRoute['_locale'] = $locale;

        return $this;
    }

    /**
     * set Class Name
     *
     * @param RouteManager $routeManager
     *
     * @return $this
     */
    public function setRouteManager(RouteManager $routeManager)
    {
        $this->routeManager = $routeManager;

        return $this;
    }

    private function removeRoutes(ParentRoutingInterface $object)
    {
        $routeList = $object->getRoutes();
        foreach ($routeList as $route) {
            if ($route->getId()) {
                $this->routeManager->remove($route);
            }
        }
    }

    private function updateRoutes(ParentRoutingInterface $object)
    {
        /** @var \FDevs\RoutingBundle\Doctrine\Mongodb\Route $route */
        $routeList = $object->getRoutes();
        foreach ($routeList as $route) {
            $requirements = $route->getRequirements();
            $route->setRequirements(array_replace($requirements, $this->requirementsRoute));
            if (!$route->getId()) {
                $route->setContent($object);
                $this->routeManager->persist($route);
            }
            $parent = $route->getParent();

            $route->setVariablePattern(($parent ? '/' : '') . $route->getName());
            $route->setStaticPrefix(
                ($parent ? rtrim($parent->getStaticPrefix(), '/') . '/' . $parent->getVariablePattern() : '/')
            );
            $defaults = array_filter($route->getDefaults());
            $route->setDefaults($defaults);
        }
    }
}
