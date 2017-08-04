<?php

namespace AppBundle\Entity\Gitlab;

class Commit
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $shortId;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $authorName;

    /**
     * @var string
     */
    private $authorEmail;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var string
     */
    private $message;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return Commit
     */
    public function setId(string $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getShortId(): string
    {
        return $this->shortId;
    }

    /**
     * @param string $shortId
     *
     * @return Commit
     */
    public function setShortId(string $shortId)
    {
        $this->shortId = $shortId;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return Commit
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getAuthorName(): string
    {
        return $this->authorName;
    }

    /**
     * @param string $authorName
     *
     * @return Commit
     */
    public function setAuthorName(string $authorName)
    {
        $this->authorName = $authorName;

        return $this;
    }

    /**
     * @return string
     */
    public function getAuthorEmail(): string
    {
        return $this->authorEmail;
    }

    /**
     * @param string $authorEmail
     *
     * @return Commit
     */
    public function setAuthorEmail(string $authorEmail)
    {
        $this->authorEmail = $authorEmail;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return Commit
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     *
     * @return Commit
     */
    public function setMessage(string $message)
    {
        $this->message = $message;

        return $this;
    }
}
