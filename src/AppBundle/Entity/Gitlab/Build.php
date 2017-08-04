<?php

namespace AppBundle\Entity\Gitlab;

class Build
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $stage;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $ref;

    /**
     * @var bool
     */
    private $tag;

    /**
     * @var string|null
     */
    private $coverage;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $startedAt;

    /**
     * @var \DateTime
     */
    private $finishedAt;

    /**
     * @var User
     */
    private $user;

    /**
     * @var Commit
     */
    private $commit;

    /**
     * @var Runner
     */
    private $runner;

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
     * @return Build
     */
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return Build
     */
    public function setStatus(string $status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getStage(): string
    {
        return $this->stage;
    }

    /**
     * @param string $stage
     *
     * @return Build
     */
    public function setStage(string $stage)
    {
        $this->stage = $stage;

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
     * @return Build
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getRef(): string
    {
        return $this->ref;
    }

    /**
     * @param string $ref
     *
     * @return Build
     */
    public function setRef(string $ref)
    {
        $this->ref = $ref;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTag(): bool
    {
        return $this->tag;
    }

    /**
     * @param bool $tag
     *
     * @return Build
     */
    public function setTag(bool $tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCoverage()
    {
        return $this->coverage;
    }

    /**
     * @param string|null $coverage
     *
     * @return Build
     */
    public function setCoverage(string $coverage = null)
    {
        $this->coverage = $coverage;

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
     * @return Build
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStartedAt(): \DateTime
    {
        return $this->startedAt;
    }

    /**
     * @param \DateTime $startedAt
     *
     * @return Build
     */
    public function setStartedAt(\DateTime $startedAt)
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getFinishedAt(): \DateTime
    {
        return $this->finishedAt;
    }

    /**
     * @param \DateTime $finishedAt
     *
     * @return Build
     */
    public function setFinishedAt(\DateTime $finishedAt)
    {
        $this->finishedAt = $finishedAt;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return Build
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Commit
     */
    public function getCommit(): Commit
    {
        return $this->commit;
    }

    /**
     * @param Commit $commit
     *
     * @return Build
     */
    public function setCommit(Commit $commit)
    {
        $this->commit = $commit;

        return $this;
    }

    /**
     * @return Runner
     */
    public function getRunner(): Runner
    {
        return $this->runner;
    }

    /**
     * @param Runner $runner
     *
     * @return Build
     */
    public function setRunner(Runner $runner)
    {
        $this->runner = $runner;

        return $this;
    }
}
