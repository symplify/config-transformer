<?php

declare (strict_types=1);
namespace ConfigTransformer20220608\Symplify\EasyTesting\PHPUnit;

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
        return \defined('ConfigTransformer20220608\\PHPUNIT_COMPOSER_INSTALL') || \defined('ConfigTransformer20220608\\__PHPUNIT_PHAR__');
    }
}
