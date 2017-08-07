<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Artifact\PhpunitClover;

class Service
{
    private $name = '';

    /** @var PhpunitClover */
    private $phpunitClover;

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
}
