<?php

namespace Blog\Model;

interface PostInterface
{
    /**
     * Will return the ID of the blog post
     *
     * @return int
     */
    public function getId();

    /**
     * Setting the ID for a blog post
     *
     * @param int $id
     * @return PostInterface
     */
    public function setId($id);

    /**
     * Will return the TITLE of the blog post
     *
     * @return string
     */
    public function getTitle();

    /**
     * Setting the TITLE for a blog post
     *
     * @param string $title
     * @return PostInterface
     */
    public function setTitle($title);

    /**
     * Will return the TEXT of the blog post
     *
     * @return string
     */
    public function getText();

    /**
     * Setting the TEXT for a blog post
     *
     * @param string $text
     * @return PostInterface
     */
    public function setText($text);
}