<?php

namespace AppBundle\Service;

use AppBundle\Entity\Project;
use AppBundle\Service\Lifx\Light;
use AppBundle\Service\Lifx\PayloadFactory;

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
     * @var StageManager
     */
    private $stageManager;

    /**
     * @var ArtifactManager
     */
    private $artifactManager;

    /**
     * TeamFlow constructor.
     *
     * @param string $redmineProjectId
     * @param int $gitlabProjectId
     * @param Light $lifxLight
     * @param StageManager $stageManager
     * @param ArtifactManager $artifactManager
     */
    public function __construct(
        string $redmineProjectId,
        int $gitlabProjectId,
        Light $lifxLight,
        StageManager $stageManager,
        ArtifactManager $artifactManager
    ) {
        $this->lifxLight = $lifxLight;
        $this->redmineProjectId = $redmineProjectId;
        $this->gitlabProjectId = $gitlabProjectId;
        $this->stageManager = $stageManager;
        $this->artifactManager = $artifactManager;
    }

    /**
     * @return Project
     */
    public function getProject(): Project
    {
        $project = (new Project())->setName(ucfirst($this->redmineProjectId));

        $this->stageManager->loadStages();

        $project->setLocalStage($this->stageManager->getLocalStage());
        $project->setRemoteStage($this->stageManager->getRemoteStage());

        $this->artifactManager->download($this->stageManager->getRemoteStage());

        $this->lifxLight->state(
            [
                'json' => PayloadFactory::getStateFromBuild($this->stageManager->getRemoteStage()->getStatus()),
            ]
        );

        return $project;
    }
}
