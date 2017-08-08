<?php

namespace AppBundle\Service\Lifx;

use AppBundle\Service\HistoryManager;

class PayloadFactory
{
    const HUE_SUCCESS = 120;
    const HUE_ERROR = 0;
    const HUE_WARNING = 60;

    const DEFAULT_BRIGHTNESS = .8;
    const DEFAULT_DURATION = .5;
    const DEFAULT_SATURATION = 1;

    public static function getStateFromBuild($mezzoStatus)
    {
        switch ($mezzoStatus) {
            case HistoryManager::BUILD_ERROR:
                $state = [
                    'power'      => 'on',
                    'brightness' => self::DEFAULT_BRIGHTNESS,
                    'duration'   => self::DEFAULT_DURATION,
                    'color'      => [
                        'hue'        => self::HUE_ERROR,
                        'saturation' => self::DEFAULT_SATURATION,
                        'brightness' => null,
                        'kelvin'     => null,
                    ],
                ];
                break;
            case HistoryManager::BUILD_SUCCESS:
                $state = [
                    'power'      => 'on',
                    'brightness' => self::DEFAULT_BRIGHTNESS,
                    'duration'   => self::DEFAULT_DURATION,
                    'color'      => [
                        'hue'        => self::HUE_SUCCESS,
                        'saturation' => self::DEFAULT_SATURATION,
                        'brightness' => null,
                        'kelvin'     => null,
                    ],
                ];
                break;
            case HistoryManager::BUILD_WARNING:
                $state = [
                    'power'      => 'on',
                    'brightness' => self::DEFAULT_BRIGHTNESS,
                    'duration'   => self::DEFAULT_DURATION,
                    'color'      => [
                        'hue'        => self::HUE_WARNING,
                        'saturation' => self::DEFAULT_SATURATION,
                        'brightness' => null,
                        'kelvin'     => null,
                    ],
                ];
                break;
        }

        return $state;
    }
}
