<?php

namespace AppBundle\Entity\Gitlab;

class Runner
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $description;

    /**
     * @var bool
     */
    private $active;

    /**
     * @var bool
     */
    private $isShared;

    /**
     * @var string
     */
    private $name;

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
     * @return Runner
     */
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return Runner
     */
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     *
     * @return Runner
     */
    public function setActive(bool $active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return bool
     */
    public function isShared(): bool
    {
        return $this->isShared;
    }

    /**
     * @param bool $isShared
     *
     * @return Runner
     */
    public function setIsShared(bool $isShared)
    {
        $this->isShared = $isShared;

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
     * @return Runner
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }
}
