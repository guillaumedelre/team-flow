<?php

namespace AppBundle\Service\Artifact;

use AppBundle\Entity\Artifact\BehatClover;
use Symfony\Component\Finder\Finder;

class BehatCloverParser
{
    /**
     * @var string
     */
    private $artifactPath;

    /**
     * BehatLogParser constructor.
     *
     * @param string $artifactPath
     */
    public function __construct(string $artifactPath)
    {
        $this->artifactPath = $artifactPath;
    }

    /**
     * @param string $service
     *
     * @return BehatClover
     */
    public function parse(string $service)
    {
        $finder = new Finder();
        $clovers = \iterator_to_array(
            $finder
                ->files()
                ->in($this->artifactPath . "/mezzo/apps/$service/var/build/behat")
                ->name('behat.log')
        );

        $behatClover = new BehatClover();

        $contentParts = explode("\n", reset($clovers)->getContents());
        array_pop($contentParts); // remove last empty line

        // TIME + MEMORY
        $timeMemoryLine = array_pop($contentParts);
        $duration = 0;
        $bytes = 0;
        if (null !== $timeMemoryLine) {
            list($time, $memory) = explode(' ', $timeMemoryLine);
            // > TIME
            preg_match_all('#(\d*)(\w)(\d*\.\d*)(\w*)#i', $time, $matches);
            if ('m' === $matches[2][0] && 's' === $matches[4][0]) {
                $duration += $matches[1][0] * 60 + $matches[3][0];
            }
            $behatClover->setDuration($duration);
            // > MEMORY
            preg_match_all('#(\d*\.\d*)(\w*)#i', $memory, $matches);
            if ('Kb' === $matches[2][0]) {
                $bytes = floatval($matches[2][0]) * 1000;
            } elseif ('Mb' === $matches[2][0]) {
                $bytes = floatval($matches[2][0]) * 1000000;
            } elseif ('Gb' === $matches[2][0]) {
                $bytes = floatval($matches[2][0]) * 1000000000;
            }
            $behatClover->setBytes($bytes);
        }

        // STEPS
        $stepsLine = array_pop($contentParts);
        $totalsteps = 0;
        $passedsteps = 0;
        $skippedsteps = 0;
        $failedsteps = 0;
        if (null !== $stepsLine) {
            if (false !== preg_match_all('#(\d*) steps \(#i', $stepsLine, $matches)) {
                $totalsteps = $matches[1][0];
            }
            $behatClover->setStepTotal($totalsteps);
            if (false !== preg_match_all('#(\d*) passed#i', $stepsLine, $matches)
                && isset($matches[1][0])) {
                $passedsteps = $matches[1][0];
            }
            $behatClover->setStepPassed($passedsteps);
            if (false !== preg_match_all('#(\d*) skipped#i', $stepsLine, $matches)
                && isset($matches[1][0])) {
                $skippedsteps = $matches[1][0];
            }
            $behatClover->setStepSkipped($skippedsteps);
            if (false !== preg_match_all('#(\d*) failed#i', $stepsLine, $matches)
                && isset($matches[1][0])) {
                $failedsteps = $matches[1][0];
            }
            $behatClover->setStepFailed($failedsteps);
        }


        // SCENARIOS
        $scenariLine = array_pop($contentParts);
        $totalScenari = 0;
        $passedScenari = 0;
        $skippedScenari = 0;
        $failedScenari = 0;
        if (null !== $stepsLine) {
            if (false !== preg_match_all('#(\d*) scenarios \(#i', $scenariLine, $matches)
                && isset($matches[1][0])) {
                $totalScenari = $matches[1][0];
            }
            $behatClover->setScenarioTotal($totalScenari);
            if (false !== preg_match_all('#(\d*) passed#i', $scenariLine, $matches)
                && isset($matches[1][0])) {
                $passedScenari = $matches[1][0];
            }
            $behatClover->setScenarioPassed($passedScenari);
            if (false !== preg_match_all('#(\d*) skipped#i', $scenariLine, $matches)
                && isset($matches[1][0])) {
                $skippedScenari = $matches[1][0];
            }
            $behatClover->setScenarioSkipped($skippedScenari);
            if (false !== preg_match_all('#(\d*) failed#i', $scenariLine, $matches)
                && isset($matches[1][0])) {
                $failedScenari = $matches[1][0];
            }
            $behatClover->setScenarioFailed($failedScenari);
        }

        return $behatClover;
    }
}
