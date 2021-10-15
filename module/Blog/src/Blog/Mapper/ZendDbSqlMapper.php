<?php

namespace Blog\Mapper;

use Blog\Model\PostInterface;
use Exception;
use InvalidArgumentException;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Delete;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Update;
use Zend\Stdlib\Hydrator\HydratorInterface;

class ZendDbSqlMapper implements PostMapperInterface
{
    const BLOG_POST_TABLE = 'post';

    /**
     * @var AdapterInterface
     */
    protected $dbAdapter;

    /**
     * @var HydratorInterface
     */
    protected $hydrator;

    /**
     * @var PostInterface
     */
    protected $postPrototype;

    /**
     * @param AdapterInterface $dbAdapter
     * @param HydratorInterface $hydrator
     * @param PostInterface $postPrototype
     */
    public function __construct(
        AdapterInterface $dbAdapter,
        HydratorInterface $hydrator,
        PostInterface $postPrototype
    ) {
        $this->dbAdapter      = $dbAdapter;
        $this->hydrator       = $hydrator;
        $this->postPrototype  = $postPrototype;
    }

    /**
     * @param int|string $id
     *
     * @return object
     * @throws InvalidArgumentException
     */
    public function find($id)
    {
        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select(self::BLOG_POST_TABLE);
        $select->where(array('id = ?' => $id));

        $stmt   = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), $this->postPrototype);
        }

        throw new InvalidArgumentException("Post with given ID:{$id} not found.");
    }

    /**
     * @return array|PostInterface[]|ResultSet
     */
    public function findAll()
    {
        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select(self::BLOG_POST_TABLE);

        $stmt   = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult()) {
            $resultSet = new HydratingResultSet($this->hydrator, $this->postPrototype);

            return $resultSet->initialize($result);
        }

        return array();
    }

    /**
     * @param PostInterface $postObject
     *
     * @return PostInterface
     * @throws Exception
     */
    public function save(PostInterface $postObject)
    {
        $postData = $this->hydrator->extract($postObject);
        unset($postData['id']); // Neither Insert nor Update needs the ID in the array

        if ($postObject->getId()) {
            // ID present, it's an Update
            $action = new Update(self::BLOG_POST_TABLE);
            $action->set($postData);
            $action->where(array('id = ?' => $postObject->getId()));
        } else {
            // ID NOT present, it's an Insert
            $action = new Insert(self::BLOG_POST_TABLE);
            $action->values($postData);
        }

        $sql    = new Sql($this->dbAdapter);
        $stmt   = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface) {
            if ($newId = $result->getGeneratedValue()) {
                // When a value has been generated, set it on the object
                $postObject->setId($newId);
            }

            return $postObject;
        }

        throw new Exception("Database error");
    }

    /**
     * @inheritDoc
     */
    public function delete(PostInterface $postObject)
    {
        $action = new Delete(self::BLOG_POST_TABLE);
        $action->where(array('id = ?' => $postObject->getId()));

        $sql    = new Sql($this->dbAdapter);
        $stmt   = $sql->prepareStatementForSqlObject($action);
        $result = $stmt->execute();

        return (bool)$result->getAffectedRows();
    }
}