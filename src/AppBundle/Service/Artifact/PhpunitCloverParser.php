<?php

namespace AppBundle\Service\Artifact;

use Symfony\Component\Finder\Finder;

class PhpunitCloverParser
{
    /**
     * @var Finder
     */
    private $finder;

    /**
     * @var string
     */
    private $artifactPath;

    /**
     * CloverParser constructor.
     *
     * @param Finder $finder
     * @param string $artifactPath
     */
    public function __construct(Finder $finder, string $artifactPath)
    {
        $this->finder = $finder;
        $this->artifactPath = $artifactPath;
    }

    public function parse()
    {
        $clovers = $this->finder
            ->files()
            ->in($this->artifactPath . '/mezzo/apps/*/var/build/phpunit')
            ->name('clover.xml');

        dump($clovers);
    }
}
