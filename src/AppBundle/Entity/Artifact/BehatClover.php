<?php

namespace AppBundle\Entity\Artifact;

class BehatClover
{
    /**
     * @var int
     */
    private $scenarioTotal = 0;

    /**
     * @var int
     */
    private $scenarioPassed = 0;

    /**
     * @var int
     */
    private $scenarioSkipped = 0;

    /**
     * @var int
     */
    private $scenarioFailed = 0;

    /**
     * @var int
     */
    private $stepTotal = 0;

    /**
     * @var int
     */
    private $stepPassed = 0;

    /**
     * @var int
     */
    private $stepSkipped = 0;

    /**
     * @var int
     */
    private $stepFailed = 0;

    /**
     * @var int
     */
    private $duration = 0;

    /**
     * @var int
     */
    private $bytes = 0;

    /**
     * @return int
     */
    public function getScenarioTotal(): int
    {
        return $this->scenarioTotal;
    }

    /**
     * @param int $scenarioTotal
     *
     * @return BehatClover
     */
    public function setScenarioTotal(int $scenarioTotal)
    {
        $this->scenarioTotal = $scenarioTotal;

        return $this;
    }

    /**
     * @return int
     */
    public function getScenarioPassed(): int
    {
        return $this->scenarioPassed;
    }

    /**
     * @param int $scenarioPassed
     *
     * @return BehatClover
     */
    public function setScenarioPassed(int $scenarioPassed)
    {
        $this->scenarioPassed = $scenarioPassed;

        return $this;
    }

    /**
     * @return int
     */
    public function getScenarioSkipped(): int
    {
        return $this->scenarioSkipped;
    }

    /**
     * @param int $scenarioSkipped
     *
     * @return BehatClover
     */
    public function setScenarioSkipped(int $scenarioSkipped)
    {
        $this->scenarioSkipped = $scenarioSkipped;

        return $this;
    }

    /**
     * @return int
     */
    public function getScenarioFailed(): int
    {
        return $this->scenarioFailed;
    }

    /**
     * @param int $scenarioFailed
     *
     * @return BehatClover
     */
    public function setScenarioFailed(int $scenarioFailed)
    {
        $this->scenarioFailed = $scenarioFailed;

        return $this;
    }

    /**
     * @return int
     */
    public function getStepTotal(): int
    {
        return $this->stepTotal;
    }

    /**
     * @param int $stepTotal
     *
     * @return BehatClover
     */
    public function setStepTotal(int $stepTotal)
    {
        $this->stepTotal = $stepTotal;

        return $this;
    }

    /**
     * @return int
     */
    public function getStepPassed(): int
    {
        return $this->stepPassed;
    }

    /**
     * @param int $stepPassed
     *
     * @return BehatClover
     */
    public function setStepPassed(int $stepPassed)
    {
        $this->stepPassed = $stepPassed;

        return $this;
    }

    /**
     * @return int
     */
    public function getStepSkipped(): int
    {
        return $this->stepSkipped;
    }

    /**
     * @param int $stepSkipped
     *
     * @return BehatClover
     */
    public function setStepSkipped(int $stepSkipped)
    {
        $this->stepSkipped = $stepSkipped;

        return $this;
    }

    /**
     * @return int
     */
    public function getStepFailed(): int
    {
        return $this->stepFailed;
    }

    /**
     * @param int $stepFailed
     *
     * @return BehatClover
     */
    public function setStepFailed(int $stepFailed)
    {
        $this->stepFailed = $stepFailed;

        return $this;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @param int $duration
     *
     * @return BehatClover
     */
    public function setDuration(int $duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return int
     */
    public function getBytes(): int
    {
        return $this->bytes;
    }

    /**
     * @param int $bytes
     *
     * @return BehatClover
     */
    public function setBytes(int $bytes)
    {
        $this->bytes = $bytes;

        return $this;
    }

}
