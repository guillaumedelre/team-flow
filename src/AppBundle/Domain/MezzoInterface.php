<?php

namespace AppBundle\Domain;

interface MezzoInterface
{
    const APP_AUTHENTICATION = 'authentication';
    const APP_BAM = 'bam';
    const APP_COMMON = 'common';
    const APP_CONSUMER = 'consumer';
    const APP_CONTENT = 'content';
    const APP_CONVERSION = 'conversion';
    const APP_DISPATCHER = 'dispatcher';
    const APP_NOTIFY = 'notify';
    const APP_PRODUCT = 'product';
    const APP_SHORTY = 'shorty';

    const APPS = [
        self::APP_AUTHENTICATION,
        self::APP_BAM,
        self::APP_COMMON,
        self::APP_CONSUMER,
        self::APP_CONTENT,
        self::APP_CONVERSION,
        self::APP_DISPATCHER,
        self::APP_NOTIFY,
        self::APP_PRODUCT,
        self::APP_SHORTY,
    ];
}
