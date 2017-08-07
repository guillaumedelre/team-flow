<?php

namespace AppBundle\Service\Artifact;

use AppBundle\Entity\Artifact\PhpunitClover;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

class PhpunitCloverParser
{
    /**
     * @var string
     */
    private $artifactPath;

    /**
     * @var XmlEncoder
     */
    private $xmlEncoder;

    /**
     * CloverParser constructor.
     *
     * @param string $artifactPath
     */
    public function __construct(string $artifactPath, XmlEncoder $xmlEncoder)
    {
        $this->artifactPath = $artifactPath;
        $this->xmlEncoder = $xmlEncoder;
    }

    /**
     * @param string $service
     *
     * @return PhpunitClover
     */
    public function parse(string $service)
    {
        $finder = new Finder();
        $clovers = \iterator_to_array(
            $finder
                ->files()
                ->in($this->artifactPath . "/mezzo/apps/$service/var/build/phpunit")
                ->name('clover.xml')
        );

        return $this->buildPhpunitClover(
            $this->xmlEncoder->decode(
                reset($clovers)->getContents(),
                'array'
            )
        );
    }

    /**
     * @param array $data
     *
     * @return PhpunitClover
     */
    private function buildPhpunitClover(array $data = []): PhpunitClover
    {
        return (new PhpunitClover())
            ->setFiles($data['project']['metrics']['@files'])
            ->setLoc($data['project']['metrics']['@loc'])
            ->setNcloc($data['project']['metrics']['@ncloc'])
            ->setClasses($data['project']['metrics']['@classes'])
            ->setMethods($data['project']['metrics']['@methods'])
            ->setCoveredmethods($data['project']['metrics']['@coveredmethods'])
            ->setConditionals($data['project']['metrics']['@conditionals'])
            ->setCoveredconditionals($data['project']['metrics']['@coveredconditionals'])
            ->setStatements($data['project']['metrics']['@statements'])
            ->setCoveredstatements($data['project']['metrics']['@coveredstatements'])
            ->setElements($data['project']['metrics']['@elements'])
            ->setCoveredelements($data['project']['metrics']['@coveredelements']);
    }
}
