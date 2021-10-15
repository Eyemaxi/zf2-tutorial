<?php

namespace Blog\Factory;

use Blog\Controller\ListController;
use Blog\Service\PostServiceInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ListControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return ListController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var ServiceLocatorInterface $realServiceLocator */
        $realServiceLocator = $serviceLocator->getServiceLocator();
        /* @var PostServiceInterface $postService */
        $postService        = $realServiceLocator->get('Blog\Service\PostServiceInterface');

        return new ListController($postService);
    }
}