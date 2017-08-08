<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Project
{
    /**
     * @var int|null
     */
    private $gitlabId;

    /**
     * @var string
     */
    private $redmineId;

    /**
     * @var Stage|null
     */
    private $localStage;

    /**
     * @var Stage|null
     */
    private $remoteStage;

    /**
     * @var Service[]|ArrayCollection|Collection
     */
    private $backupServices;

    /**
     * @var Service[]|ArrayCollection|Collection
     */
    private $services;

    /**
     * Project constructor.
     */
    public function __construct()
    {
        $this->services = new ArrayCollection();
        $this->backupServices = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getGitlabId()
    {
        return $this->gitlabId;
    }

    /**
     * @param int|null $gitlabId
     *
     * @return Project
     */
    public function setGitlabId($gitlabId)
    {
        $this->gitlabId = $gitlabId;

        return $this;
    }

    /**
     * @return string
     */
    public function getRedmineId(): string
    {
        return $this->redmineId;
    }

    /**
     * @param string $redmineId
     *
     * @return Project
     */
    public function setRedmineId(string $redmineId)
    {
        $this->redmineId = $redmineId;

        return $this;
    }
    /**
     * @return Stage|null
     */
    public function getLocalStage()
    {
        return $this->localStage;
    }

    /**
     * @param Stage|null $localStage
     *
     * @return Project
     */
    public function setLocalStage($localStage)
    {
        $this->localStage = $localStage;

        return $this;
    }

    /**
     * @return Stage|null
     */
    public function getRemoteStage()
    {
        return $this->remoteStage;
    }

    /**
     * @param Stage|null $remoteStage
     *
     * @return Project
     */
    public function setRemoteStage($remoteStage)
    {
        $this->remoteStage = $remoteStage;

        return $this;
    }

    /**
     * @return Service[]|ArrayCollection|Collection
     */
    public function getBackupServices()
    {
        return $this->backupServices;
    }

    /**
     * @param Service[]
     *
     * @return Project
     */
    public function setBackupServices(array $backupServices)
    {
        $this->backupServices = new ArrayCollection();
        foreach ($backupServices as $service) {
            $this->backupServices->add($service);
        }

        return $this;
    }

    /**
     * @return Service[]|ArrayCollection|Collection
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * @param Service[] $services
     *
     * @return Project
     */
    public function setServices(array $services)
    {
        $this->services = new ArrayCollection();
        foreach ($services as $service) {
            $this->services->add($service);
        }

        return $this;
    }
}
