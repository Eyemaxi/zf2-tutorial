<?php

namespace Blog\Controller;

use Blog\Service\PostServiceInterface;
use InvalidArgumentException;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    /**
     * @var PostServiceInterface
     */
    protected $postService;

    /**
     * @param PostServiceInterface $postService
     */
    public function __construct(PostServiceInterface $postService)
    {
        $this->postService = $postService;
    }

    public function indexAction()
    {
        return new ViewModel(array(
            'posts' => $this->postService->findAllPosts()
        ));
    }

    public function viewAction()
    {
        $id = $this->params()->fromRoute('id');

        try {
            $post = $this->postService->findPost($id);
        } catch (InvalidArgumentException $ex) {
            return $this->redirect()->toRoute('blog');
        }

        return new ViewModel(array('post' => $post));
    }

    public function deleteAction()
    {
        try {
            $post = $this->postService->findPost($this->params('id'));
        } catch (InvalidArgumentException $e) {
            return $this->redirect()->toRoute('blog');
        }

        $request = $this->getRequest();

        if ($request->isPost()) {
            $del = $request->getPost('delete_confirmation', 'no');

            if ($del === 'yes') {
                $this->postService->deletePost($post);
            }

            return $this->redirect()->toRoute('blog');
        }

        return new ViewModel(array(
            'post' => $post
        ));
    }
}