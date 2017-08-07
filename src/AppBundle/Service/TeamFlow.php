<?php

namespace AppBundle\Service;

use AppBundle\Entity\Artifact\PhpunitClover;
use AppBundle\Entity\Project;
use AppBundle\Entity\Service;
use AppBundle\Service\Gitlab\CiManager;
use AppBundle\Service\Lifx\Light;
use AppBundle\Service\Lifx\PayloadFactory;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\SerializerInterface;

class TeamFlow
{
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
     * @var CiManager
     */
    private $ciManager;

    /**
     * @var ArtifactManager
     */
    private $artifactManager;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var HistoryManager
     */
    private $history;

    /**
     * @var CiManager
     */
    private $ci;

    /**
     * TeamFlow constructor.
     *
     * @param string $redmineProjectId
     * @param int $gitlabProjectId
     * @param Light $lifxLight
     * @param ArtifactManager $artifactManager
     * @param SerializerInterface $serializer
     * @param Filesystem $filesystem
     * @param HistoryManager $history
     * @param CiManager $ciManager
     */
    public function __construct(
        string $redmineProjectId,
        int $gitlabProjectId,
        Light $lifxLight,
        ArtifactManager $artifactManager,
        SerializerInterface $serializer,
        Filesystem $filesystem,
        HistoryManager $history,
        CiManager $ciManager
    ) {
        $this->lifxLight = $lifxLight;
        $this->redmineProjectId = $redmineProjectId;
        $this->gitlabProjectId = $gitlabProjectId;
        $this->artifactManager = $artifactManager;
        $this->serializer = $serializer;
        $this->filesystem = $filesystem;
        $this->history = $history;
        $this->ci = $ciManager;
    }

    /**
     * @return Project
     */
    public function getProject(): Project
    {
        $project = (new Project())
            ->setGitlabId($this->gitlabProjectId)
            ->setRedmineId($this->redmineProjectId);

        if ($this->history->hasLocalProject()) {
            $_project = $this->history->getLocalProject();
            $project->setBackupServices($_project->getServices()->toArray());
        }

        // Remote Stage
        $project->setRemoteStage($this->ci->buildRemoteStage());

        // download artifact & compute metrics
        $services = $this->artifactManager->download($project->getRemoteStage());
        $project->setServices($services);

        // statify history
        $this->history->statify($project);

        $this->lifxLight->state(
            [
                'json' => PayloadFactory::getStateFromBuild($project->getRemoteStage()->getStatus()),
            ]
        );

        return $project;
    }
}
