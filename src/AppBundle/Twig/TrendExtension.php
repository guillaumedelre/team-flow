<?php

namespace AppBundle\Twig;

use AppBundle\Entity\Artifact\PhpunitClover;
use AppBundle\Entity\Project;
use AppBundle\Entity\Service;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class TrendExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('trendArrow', array($this, 'trendArrow')),
            new \Twig_SimpleFunction('trendBackground', array($this, 'trendBackground')),
            new \Twig_SimpleFunction('phpunitPercent', array($this, 'phpunitPercent')),
        );
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

        foreach ($services as $_service) {
            if ($service->getName() === $_service->getName()) {
                $phpunit = $_service->getPhpunitClover();
                break;
            }
        }

        return $phpunit->getCoveredmethods() * 100 / $phpunit->getMethods();
    }

    /**
     * @param Service $service
     * @param Project $project
     *
     * @return string
     */
    public function trendArrow(Service $service, Project $project): string
    {
        /** @var Service $old */
        $old = $this->phpunitPercent($service, $project->getBackupServices());

        /** @var Service $new */
        $new = $this->phpunitPercent($service, $project->getServices());

        $return = 'fa-arrow-down';
        if ($new > $old) {
            $return = 'fa-arrow-up';
        }
        if ($new < $old) {
            $return = 'fa-arrow-down';
        }
        if ($new == $old) {
            $return = 'fa-arrow-right';
        }

        return $return;
    }

    /**
     * @param Service $service
     * @param Project $project
     *
     * @return mixed
     */
    public function trendBackground(Service $service, Project $project)
    {
        /** @var Service $new */
        $new = $this->phpunitPercent($service, $project->getServices());

        $return = 'bg-aqua';
        if ($new > 90) {
            $return = 'bg-green';
        }
        if ($new > 50 && $new <90) {
            $return = 'bg-yellow';
        }
        if ($new < 50) {
            $return = 'bg-red';
        }

        return $return;
    }
}
