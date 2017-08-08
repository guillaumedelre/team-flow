<?php
/**
 * Created by PhpStorm.
 * User: gdelre
 * Date: 04/08/17
 * Time: 21:55
 */

namespace AppBundle\Service\Gitlab;

use AppBundle\Entity\Gitlab\Build;
use AppBundle\Entity\Stage;

class CiManager
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
     * @var Mezzo
     */
    private $gitlabMezzo;

    /**
     * History constructor.
     *
     * @param Mezzo $gitlabMezzo
     */
    public function __construct(Mezzo $gitlabMezzo)
    {
        $this->gitlabMezzo = $gitlabMezzo;
    }

    /**
     * @return Stage
     */
    public function buildRemoteStage(): Stage
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
}
