<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Artifact\PhpunitClover;

class Artifact
{
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
     * @return Artifact
     */
    public function setPhpunitClover(PhpunitClover $phpunitClover)
    {
        $this->phpunitClover = $phpunitClover;

        return $this;
    }

}
