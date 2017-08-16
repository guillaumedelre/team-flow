<?php

namespace AppBundle\Twig;

use AppBundle\Entity\Artifact\PhpunitClover;
use AppBundle\Entity\Project;
use AppBundle\Entity\Service;
use Doctrine\Common\Collections\ArrayCollection;

class TrendPhpunitExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('phpunitThumb', [$this, 'trendArrow']),
            new \Twig_SimpleFunction('phpunitBackground', [$this, 'trendBackground']),
            new \Twig_SimpleFunction('phpunitPercent', [$this, 'phpunitPercent']),
        ];
    }

    /**
     * @param Service $service
     * @param Project $project
     *
     * @return string
     */
    public function trendArrow(Service $service, Project $project): string
    {
        $avg = $this->phpunitPercent($service, $project->getServices());

        $return = 'fa-thumbs-down';

        if ($avg >= 90) {
            $return = 'fa-thumbs-up';
        }

        return $return;
    }

    /**
     * @param Service $service
     * @param ArrayCollection $services
     *
     * @return float|int
     */
    public function phpunitPercent(Service $service, ArrayCollection $services)
    {
        /** @var PhpunitClover $phpunit */
        $phpunit = null;

        /** @var Service $_service */
        foreach ($services as $_service) {
            if ($service->getName() === $_service->getName()) {
                $phpunit = $_service->getPhpunitClover();
                break;
            }
        }

        $avg = 0;
        $divider = 0;
        if ($phpunit->getMethods() > 0) {
            $avg += $phpunit->getCoveredmethods() * 100 / $phpunit->getMethods();
            $divider++;
        }
        if ($phpunit->getConditionals() > 0) {
            $avg += $phpunit->getCoveredconditionals() * 100 / $phpunit->getConditionals();
            $divider++;
        }
        if ($phpunit->getStatements() > 0) {
            $avg += $phpunit->getCoveredstatements() * 100 / $phpunit->getStatements();
            $divider++;
        }
        if ($phpunit->getElements() > 0) {
            $avg += $phpunit->getCoveredelements() * 100 / $phpunit->getElements();
            $divider++;
        }

        return $avg / $divider;
    }

    /**
     * @param Service $service
     * @param Project $project
     *
     * @return mixed
     */
    public function trendBackground(Service $service, Project $project)
    {
        $avg = $this->phpunitPercent($service, $project->getServices());

        $return = 'bg-aqua';

        if ($avg >= 90) {
            $return = 'bg-green';
        }

        if ($avg >= 50 && $avg < 90) {
            $return = 'bg-yellow';
        }

        if ($avg < 50) {
            $return = 'bg-red';
        }

        return $return;
    }
}
