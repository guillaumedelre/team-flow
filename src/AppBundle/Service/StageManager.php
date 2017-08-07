<?php
/**
 * Created by PhpStorm.
 * User: gdelre
 * Date: 04/08/17
 * Time: 21:55
 */

namespace AppBundle\Service;

use AppBundle\Entity\Artifact;
use AppBundle\Entity\Gitlab\Build;
use AppBundle\Entity\Stage;
use AppBundle\Service\Artifact\PhpunitCloverParser;
use AppBundle\Service\Gitlab\Mezzo;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class StageManager
{
    const BUILD_STATUS_SUCCESS = 'success';
    const BUILD_STATUS_FAILED = 'failed';

    const BUILD_STAGE_BUILD = 'buid';
    const BUILD_STAGE_PACKAGE = 'package';
    const BUILD_STAGE_DEPLOY = 'deploy';

    const BUILD_SUCCESS = 0b001;
    const BUILD_WARNING = 0b010;
    const BUILD_ERROR = 0b000;

    /**
     * @var string
     */
    private $historyPath;

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
     * @var Stage|null
     */
    private $localStage = null;

    /**
     * @var Stage|null
     */
    private $remoteStage = null;

    /**
     * @var Mezzo
     */
    private $gitlabMezzo;

    /**
     * @var PhpunitCloverParser
     */
    private $phpunitCloverParser;

    /**
     * History constructor.
     *
     * @param string $historyPath
     * @param Filesystem $filesystem
     * @param SerializerInterface $serializer
     * @param Mezzo $gitlabMezzo
     * @param PhpunitCloverParser $phpunitCloverParser
     */
    public function __construct(
        string $historyPath,
        Filesystem $filesystem,
        SerializerInterface $serializer,
        Mezzo $gitlabMezzo,
        PhpunitCloverParser $phpunitCloverParser
    ) {
        $this->historyPath = $historyPath;
        $this->filesystem = $filesystem;
        $this->finder = new Finder();
        $this->serializer = $serializer;
        $this->gitlabMezzo = $gitlabMezzo;
        $this->phpunitCloverParser = $phpunitCloverParser;
    }

    /**
     * @throws \Exception
     */
    public function loadStages()
    {
        // LOAD LOCAL STAGE
        $this->localStage = $this->buildLocalStage();

        // LOAD REMOTE STAGE
        $this->remoteStage = $this->buildRemoteStage();
    }

    /**
     * @return Stage
     * @throws \Exception
     */
    private function buildLocalStage(): Stage
    {
        if (!$this->filesystem->exists($this->historyPath)) {
            $message = sprintf('Path not found `%s`.', $this->historyPath);
            throw new \Exception($message);
        }

        $this->finder->files()->in($this->historyPath)->name('*.json')->sortByModifiedTime();
        if (0 === $this->finder->count()) {
            throw new \Exception('No history found.');
        }

        /** @var SplFileInfo $stageFile */
        $stageFile = null;
        foreach ($this->finder as $file) {
            $stageFile = $file;
            break;
        }

        return $this->serializer->deserialize(
            $stageFile->getContents(),
            Stage::class,
            JsonEncoder::FORMAT
        );
    }

    /**
     * @return Stage
     */
    private function buildRemoteStage(): Stage
    {
        $return = [];
        $builds = $this->gitlabMezzo->builds();
        foreach ($builds as $i => $build) {
            if (self::BUILD_STAGE_DEPLOY === $build->getStage()) {
                $return[] = $builds[$i];
                $return[] = $builds[$i + 1];
                $return[] = $builds[$i + 2];
                break;
            }
        }

        /**
         * @var Build $deploy
         * @var Build $package
         * @var Build $build
         */
        list($deploy, $package, $build) = $return;

        $isSuccessful = self::BUILD_STATUS_SUCCESS === $deploy->getStatus()
            && self::BUILD_STATUS_SUCCESS === $package->getStatus()
            && self::BUILD_STATUS_SUCCESS === $build->getStatus();

        $hasWarning = self::BUILD_STATUS_SUCCESS === $deploy->getStatus()
            && (self::BUILD_STATUS_FAILED === $package->getStatus()
                || self::BUILD_STATUS_FAILED === $build->getStatus());

        $status = $isSuccessful ? self::BUILD_SUCCESS : ($hasWarning ? self::BUILD_WARNING : self::BUILD_ERROR);

        return (new Stage())
            ->setBuildJob($build)
            ->setPackageJob($package)
            ->setDeployJob($deploy)
            ->setStatus($status);
    }

    /**
     * @return Stage|null
     */
    public function getLocalStage()
    {
        return $this->localStage;
    }

    /**
     * @return Stage|null
     */
    public function getRemoteStage()
    {
        return $this->remoteStage;
    }
}
