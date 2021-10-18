<?php

namespace Blog\Factory;

use Blog\Mapper\DoctrineMapper;
use Doctrine\ORM\EntityManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DoctrineMapperFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return DoctrineMapper
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var EntityManager $objectManager */
        $objectManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
        return new DoctrineMapper($objectManager);
    }
}