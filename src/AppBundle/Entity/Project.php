<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Project
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
     * @var Stage
     */
    private $localStage;

    /**
     * @var Stage
     */
    private $remoteStage;

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
     * @return Project
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
     * @return Project
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Stage
     */
    public function getLocalStage(): Stage
    {
        return $this->localStage;
    }

    /**
     * @param Stage $localStage
     */
    public function setLocalStage(Stage $localStage)
    {
        $this->localStage = $localStage;
    }

    /**
     * @return Stage
     */
    public function getRemoteStage(): Stage
    {
        return $this->remoteStage;
    }

    /**
     * @param Stage $remoteStage
     */
    public function setRemoteStage(Stage $remoteStage)
    {
        $this->remoteStage = $remoteStage;
    }
}
