<?php

namespace AppBundle\Entity\Gitlab;

class User
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $state;

    /**
     * @var string|null
     */
    private $avatarUrl;

    /**
     * @var string|null
     */
    private $webUrl;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var bool
     */
    private $isAdmin;

    /**
     * @var string|null
     */
    private $bio;

    /**
     * @var string|null
     */
    private $location;

    /**
     * @var string|null
     */
    private $skype;

    /**
     * @var string|null
     */
    private $linkedin;

    /**
     * @var string|null
     */
    private $twitter;

    /**
     * @var string|null
     */
    private $websiteUrl;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return User
     */
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return User
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return User
     */
    public function setUsername(string $username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @param string $state
     *
     * @return User
     */
    public function setState(string $state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getAvatarUrl()
    {
        return $this->avatarUrl;
    }

    /**
     * @param null|string $avatarUrl
     *
     * @return User
     */
    public function setAvatarUrl($avatarUrl)
    {
        $this->avatarUrl = $avatarUrl;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getWebUrl()
    {
        return $this->webUrl;
    }

    /**
     * @param null|string $webUrl
     *
     * @return User
     */
    public function setWebUrl($webUrl)
    {
        $this->webUrl = $webUrl;

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
     * @return User
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    /**
     * @param bool $isAdmin
     *
     * @return User
     */
    public function setIsAdmin(bool $isAdmin)
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * @param null|string $bio
     *
     * @return User
     */
    public function setBio($bio)
    {
        $this->bio = $bio;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param null|string $location
     *
     * @return User
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getSkype()
    {
        return $this->skype;
    }

    /**
     * @param null|string $skype
     *
     * @return User
     */
    public function setSkype($skype)
    {
        $this->skype = $skype;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getLinkedin()
    {
        return $this->linkedin;
    }

    /**
     * @param null|string $linkedin
     *
     * @return User
     */
    public function setLinkedin($linkedin)
    {
        $this->linkedin = $linkedin;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * @param null|string $twitter
     *
     * @return User
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getWebsiteUrl()
    {
        return $this->websiteUrl;
    }

    /**
     * @param null|string $websiteUrl
     *
     * @return User
     */
    public function setWebsiteUrl($websiteUrl)
    {
        $this->websiteUrl = $websiteUrl;

        return $this;
    }

}
