<?php

namespace AppBundle\Service\Lifx;

use AppBundle\Service\Orchestrator;

class PayloadFactory
{
    public static function getStateFromBuild($mezzoStatus)
    {
        switch ($mezzoStatus) {
            case Orchestrator::BUILD_ERROR:
                $state = [
                    'power'      => 'on',
                    'brightness' => Orchestrator::DEFAULT_BRIGHTNESS,
                    'duration'   => .5,
                    'color'      => [
                        'hue'        => Orchestrator::HUE_ERROR,
                        'saturation' => 1,
                        'brightness' => null,
                        'kelvin'     => null,
                    ],
                ];
                break;
            case Orchestrator::BUILD_SUCCESS:
                $state = [
                    'power'      => 'on',
                    'brightness' => Orchestrator::DEFAULT_BRIGHTNESS,
                    'duration'   => .5,
                    'color'      => [
                        'hue'        => Orchestrator::HUE_SUCCESS,
                        'saturation' => 1,
                        'brightness' => null,
                        'kelvin'     => null,
                    ],
                ];
                break;
            case Orchestrator::BUILD_WARNING:
                $state = [
                    'power'      => 'on',
                    'brightness' => Orchestrator::DEFAULT_BRIGHTNESS,
                    'duration'   => .5,
                    'color'      => [
                        'hue'        => Orchestrator::HUE_WARNING,
                        'saturation' => 1,
                        'brightness' => null,
                        'kelvin'     => null,
                    ],
                ];
                break;
        }

        return $state;
    }
}
