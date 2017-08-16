<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Artifact\BehatClover;
use AppBundle\Entity\Artifact\PhpunitClover;

class Service
{
    /**
     * @var string
     */
    private $name = '';

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var PhpunitClover
     */
    private $phpunitClover;

    /**
     * @var BehatClover
     */
    private $behatClover;

    /**
     * Service constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @return PhpunitClover
     */
    public function getPhpunitClover(): PhpunitClover
    {
        return $this->phpunitClover;
    }

    /**
     * @param PhpunitClover $phpunitClover
     *
     * @return Service
     */
    public function setPhpunitClover(PhpunitClover $phpunitClover)
    {
        $this->phpunitClover = $phpunitClover;

        return $this;
    }

    /**
     * @return BehatClover
     */
    public function getBehatClover(): BehatClover
    {
        return $this->behatClover;
    }

    /**
     * @param BehatClover $behatClover
     *
     * @return Service
     */
    public function setBehatClover(BehatClover $behatClover)
    {
        $this->behatClover = $behatClover;

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
     * @return Service
     */
    public function setName(string $name)
    {
        $this->name = $name;

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
     * @return Service
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
