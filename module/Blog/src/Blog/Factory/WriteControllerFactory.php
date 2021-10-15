<?php

namespace Blog\Factory;

use Blog\Controller\WriteController;
use Blog\Service\PostServiceInterface;
use Zend\Form\FormInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class WriteControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return WriteController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var ServiceLocatorInterface $realServiceLocator */
        $realServiceLocator = $serviceLocator->getServiceLocator();
        /* @var PostServiceInterface $postService */
        $postService        = $realServiceLocator->get('Blog\Service\PostServiceInterface');
        /* @var FormInterface $postInsertForm */
        $postInsertForm     = $realServiceLocator->get('FormElementManager')->get('Blog\Form\PostForm');

        return new WriteController($postService, $postInsertForm);
    }
}