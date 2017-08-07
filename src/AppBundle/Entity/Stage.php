<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Gitlab\Build;

class Stage
{
    /**
     * @var Build
     */
    private $buildJob;

    /**
     * @var Build
     */
    private $packageJob;

    /**
     * @var Build
     */
    private $deployJob;

    /**
     * @var int
     */
    private $status;

    /**
     * @return Build
     */
    public function getBuildJob(): Build
    {
        return $this->buildJob;
    }

    /**
     * @param Build $buildJob
     *
     * @return Stage
     */
    public function setBuildJob(Build $buildJob)
    {
        $this->buildJob = $buildJob;

        return $this;
    }

    /**
     * @return Build
     */
    public function getPackageJob(): Build
    {
        return $this->packageJob;
    }

    /**
     * @param Build $packageJob
     *
     * @return Stage
     */
    public function setPackageJob(Build $packageJob)
    {
        $this->packageJob = $packageJob;

        return $this;
    }

    /**
     * @return Build
     */
    public function getDeployJob(): Build
    {
        return $this->deployJob;
    }

    /**
     * @param Build $deployJob
     *
     * @return Stage
     */
    public function setDeployJob(Build $deployJob)
    {
        $this->deployJob = $deployJob;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     *
     * @return Stage
     */
    public function setStatus(int $status)
    {
        $this->status = $status;

        return $this;
    }
}
