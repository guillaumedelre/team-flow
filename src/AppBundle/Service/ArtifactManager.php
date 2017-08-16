<?php
/**
 * Created by PhpStorm.
 * User: gdelre
 * Date: 04/08/17
 * Time: 22:24
 */

namespace AppBundle\Service;


use AppBundle\Entity\Service;
use AppBundle\Entity\Stage;
use AppBundle\Service\Artifact\BehatCloverParser;
use AppBundle\Service\Artifact\PhpunitCloverParser;
use AppBundle\Service\Gitlab\Mezzo;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Process\Process;
use Symfony\Component\Serializer\SerializerInterface;

class ArtifactManager
{
    /**
     * @var string
     */
    private $artifactPath;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var Finder
     */
    private $finder;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var Mezzo
     */
    private $gitlabMezzo;

    /**
     * @var PhpunitCloverParser
     */
    private $phpunitCloverParser;

    /**
     * @var BehatCloverParser
     */
    private $behatCloverParser;

    /**
     * ArtifactManager constructor.
     *
     * @param string $artifactPath
     * @param Filesystem $filesystem
     * @param SerializerInterface $serializer
     * @param Mezzo $gitlabMezzo
     * @param PhpunitCloverParser $phpunitCloverParser
     * @param BehatCloverParser $behatCloverParser
     */
    public function __construct(
        string $artifactPath,
        Filesystem $filesystem,
        SerializerInterface $serializer,
        Mezzo $gitlabMezzo,
        PhpunitCloverParser $phpunitCloverParser,
        BehatCloverParser $behatCloverParser
    ) {
        $this->artifactPath = $artifactPath;
        $this->filesystem = $filesystem;
        $this->finder = new Finder();
        $this->serializer = $serializer;
        $this->gitlabMezzo = $gitlabMezzo;
        $this->phpunitCloverParser = $phpunitCloverParser;
        $this->behatCloverParser = $behatCloverParser;
    }

    /**
     * @param Stage $stage
     *
     * @return array|Service[]
     */
    public function download(Stage $stage)
    {
        $artifactFilename = $this->artifactPath . '/artifacts.zip';

        if ($this->filesystem->exists($this->artifactPath . '/mezzo/')) {
            $this->filesystem->remove($this->artifactPath . '/mezzo/');
        }

        $this->filesystem->dumpFile(
            $artifactFilename,
            $this->gitlabMezzo->downloadArtifact($stage->getBuildJob()->getId())->getBody()->getContents()
        );

        $process = new Process("unzip $artifactFilename -d " . $this->artifactPath);
        $process->run();
        $this->filesystem->remove($artifactFilename);

        $services = [];

        // catch each service
        // and parse each phpunit
        // todo behat
        $this->finder->directories()->depth(0)->in($this->artifactPath . '/mezzo/apps/');
        foreach ($this->finder as $directory)
        {
            $serviceName = $directory->getRelativePathname();
            $services[] = (new Service())
                    ->setName($serviceName)
                    ->setCreatedAt(new \DateTime())
                    ->setPhpunitClover($this->phpunitCloverParser->parse($serviceName))
                    ->setBehatClover($this->behatCloverParser->parse($serviceName))
            ;
        }

        return $services;
    }

}
