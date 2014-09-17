<?php

namespace FDevs\RoutingBundle\Doctrine\Mongodb;

use Doctrine\ODM\MongoDB\DocumentRepository;

class RouteRepository extends DocumentRepository
{
    public function findByStaticPrefix(array $candidates, array $sort = [])
    {
        return $this->createQueryBuilder()
            ->field('staticPrefix')->in($candidates)
            ->sort('staticPrefix', -1)
            ->getQuery()->execute();
    }
}
