<?php

namespace Blog\Factory;

use Blog\Controller\DeleteController;
use Blog\Service\PostServiceInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DeleteControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return DeleteController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var ServiceLocatorInterface $realServiceLocator */
        $realServiceLocator = $serviceLocator->getServiceLocator();
        /* @var PostServiceInterface $postService */
        $postService        = $realServiceLocator->get('Blog\Service\PostServiceInterface');

        return new DeleteController($postService);
    }
}