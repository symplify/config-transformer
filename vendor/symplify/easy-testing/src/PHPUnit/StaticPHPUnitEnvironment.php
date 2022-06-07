<?php

declare (strict_types=1);
namespace ConfigTransformer2022060710\Symplify\EasyTesting\PHPUnit;

/**
 * @api
 */
final class StaticPHPUnitEnvironment
{
    /**
     * Never ever used static methods if not neccesary, this is just handy for tests + src to prevent duplication.
     */
    public static function isPHPUnitRun() : bool
    {
        return \defined('ConfigTransformer2022060710\\PHPUNIT_COMPOSER_INSTALL') || \defined('ConfigTransformer2022060710\\__PHPUNIT_PHAR__');
    }
}
