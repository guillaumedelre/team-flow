<?php

namespace AppBundle\Twig;

use AppBundle\Entity\Artifact\BehatClover;
use AppBundle\Entity\Project;
use AppBundle\Entity\Service;
use Doctrine\Common\Collections\ArrayCollection;

class TrendBehatExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('behatThumb', [$this, 'trendArrow']),
            new \Twig_SimpleFunction('behatBackground', [$this, 'trendBackground']),
            new \Twig_SimpleFunction('behatPercent', [$this, 'behatPercent']),
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
        $avg = $this->behatPercent($service, $project->getServices());

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
    public function behatPercent(Service $service, ArrayCollection $services)
    {
        /** @var BehatClover $behat */
        $behat = null;

        /** @var Service $_service */
        foreach ($services as $_service) {
            if ($service->getName() === $_service->getName()) {
                $behat = $_service->getBehatClover();
                break;
            }
        }

        $avg = 0;
        $divider = 0;
        if ($behat->getScenarioTotal() > 0) {
            $avg += $behat->getScenarioPassed() * 100 / $behat->getScenarioTotal();
            $divider++;
        }
        if ($behat->getStepTotal() > 0) {
            $avg += $behat->getStepPassed() * 100 / $behat->getStepTotal();
            $divider++;
        }

        return (0 === $divider) ? 0 : $avg / $divider;
    }

    /**
     * @param Service $service
     * @param Project $project
     *
     * @return mixed
     */
    public function trendBackground(Service $service, Project $project)
    {
        $avg = $this->behatPercent($service, $project->getServices());

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
