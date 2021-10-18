<?php

namespace Blog\Factory;

use Blog\Controller\IndexController;
use Blog\Service\PostServiceInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IndexControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return IndexController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if ($serviceLocator instanceof ServiceLocatorAwareInterface) {
            /** @var ServiceLocatorInterface $serviceLocator */
            $serviceLocator = $serviceLocator->getServiceLocator();
        }
        /** @var PostServiceInterface $postService */
        $postService = $serviceLocator->get('Blog\Service\PostServiceInterface');

        return new IndexController($postService);
    }
}