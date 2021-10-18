<?php

namespace Blog\Mapper;

use Blog\Model\PostInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

class DoctrineMapper implements PostMapperInterface
{
    /**
     * @var ObjectRepository
     */
    protected $repository;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
        $this->repository = $objectManager->getRepository('Blog\Model\Post');
    }

    /**
     * @inheritDoc
     */
    public function find($id)
    {
        return $this->repository->findOneBy(array('id' => $id));
    }

    /**
     * @inheritDoc
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @inheritDoc
     */
    public function save(PostInterface $postObject)
    {
        $this->objectManager->persist($postObject);
        return $postObject;
    }

    /**
     * @inheritDoc
     */
    public function delete(PostInterface $postObject)
    {
        $this->objectManager->remove($postObject);
        $this->objectManager->flush();
        return true;
    }
}