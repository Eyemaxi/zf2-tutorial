<?php

namespace Blog\Factory;

use Blog\Mapper\ZendDbSqlMapper;
use Blog\Model\Post;
use Zend\Db\Adapter\AdapterInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class ZendDbSqlMapperFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return ZendDbSqlMapper
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var AdapterInterface $dbAdapter */
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        return new ZendDbSqlMapper($dbAdapter, new ClassMethods(false), new Post());
    }
}