<?php

namespace FDevs\RoutingBundle;

use Doctrine\Bundle\MongoDBBundle\DependencyInjection\Compiler\DoctrineMongoDBMappingsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FDevsRoutingBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $this->buildMongodbCompilerPass($container);
    }

    private function buildMongodbCompilerPass(ContainerBuilder $container)
    {
        $container->addCompilerPass(
            $this->buildBaseCompilerPass('Doctrine\Bundle\MongoDBBundle\DependencyInjection\Compiler\DoctrineMongoDBMappingsPass', 'Doctrine\ODM\MongoDB\Mapping\Driver\XmlDriver', 'mongodb')
        );
        $container->addCompilerPass(
            DoctrineMongoDBMappingsPass::createXmlMappingDriver(
                array(
                    realpath(__DIR__ . '/Resources/config/doctrine-model') => 'Symfony\Cmf\Bundle\RoutingBundle\Model',
                    realpath(__DIR__ . '/Resources/config/doctrine-mongodb') => 'FDevs\RoutingBundle\Doctrine\Mongodb',
                ),
                array('f_devs_routing.dynamic.persistence.mongodb.manager_name'),
                'f_devs_routing.backend_type_mongodb'
            )
        );
    }

    private function buildBaseCompilerPass($compilerClass, $driverClass, $type)
    {
        $arguments = array(array(realpath(__DIR__ . '/Resources/config/doctrine-base')), sprintf('.%s.xml', $type));
        $locator = new Definition('Doctrine\Common\Persistence\Mapping\Driver\DefaultFileLocator', $arguments);
        $driver = new Definition($driverClass, array($locator));

        return new $compilerClass(
            $driver,
            array('Symfony\Component\Routing'),
            array('f_devs_routing.dynamic.persistence.mongodb.manager_name'),
            'f_devs_routing.backend_type_mongodb'
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return 'CmfRoutingBundle';
    }

}
