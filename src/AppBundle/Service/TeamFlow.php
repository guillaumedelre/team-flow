<?php

namespace AppBundle\Service;

use AppBundle\Entity\Gitlab\Build;
use AppBundle\Entity\Project;
use AppBundle\Entity\Stage;
use AppBundle\Service\Gitlab\Mezzo;
use AppBundle\Service\Lifx\Light;
use AppBundle\Service\Lifx\PayloadFactory;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class TeamFlow
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
     * @var Project
     */
    private $project;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var Mezzo
     */
    private $gitlabMezzo;
    /**
     * @var Light
     */
    private $lifxLight;

    /**
     * @var string
     */
    private $redmineProjectId;

    /**
     * @var int
     */
    private $gitlabProjectId;

    /**
     * @var string
     */
    private $artifactPath;

    /**
     * TeamFlow constructor.
     *
     * @param string $redmineProjectId
     * @param int $gitlabProjectId
     * @param Mezzo $gitlabMezzo
     * @param Light $lifxLight
     * @param Filesystem $filesystem
     * @param string $artifactPath
     */
    public function __construct(
        string $redmineProjectId,
        int $gitlabProjectId,
        Mezzo $gitlabMezzo,
        Light $lifxLight,
        Filesystem $filesystem,
        string $artifactPath
    )
    {
        $this->redmineProjectId = $redmineProjectId;
        $this->gitlabProjectId = $gitlabProjectId;

        $this->gitlabMezzo = $gitlabMezzo;
        $this->lifxLight = $lifxLight;

        $this->filesystem = $filesystem;
        $this->artifactPath = $artifactPath;
    }

    /**
     * @param Stage $stage
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function downloadArtifacts(Stage $stage)
    {
        $artifactFilename = $this->artifactPath . '/artifacts.zip';

        if ($this->filesystem->exists($this->artifactPath)) {
            $this->filesystem->remove($this->artifactPath);
        }

        $this->filesystem->dumpFile(
            $artifactFilename,
            $this->gitlabMezzo->downloadArtifact($stage->getBuildJob()->getId())->getBody()->getContents()
        );

        $process = new Process("unzip $artifactFilename -d " . $this->artifactPath);
        $process->run();
        $this->filesystem->remove($artifactFilename);

        return $this->gitlabMezzo->downloadArtifact($stage->getBuildJob()->getId());
    }

    /**
     * @return Project
     */
    public function run(): Project
    {
        $stage = $this->buildStage();

        $this->downloadArtifacts($stage);

        return (new Project())
            ->setName(ucfirst($this->redmineProjectId))
            ->setStage($stage)
        ;
    }

    /**
     * @return Stage
     */
    private function buildStage(): Stage
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
        $this->lifxLight->state(['json' => PayloadFactory::getStateFromBuild($status)]);

        return (new Stage())
            ->setBuildJob($build)
            ->setPackageJob($package)
            ->setDeployJob($deploy)
            ->setStatus($status);
    }
}
