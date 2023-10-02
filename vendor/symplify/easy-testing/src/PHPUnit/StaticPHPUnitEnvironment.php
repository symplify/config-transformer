<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202310\Symplify\EasyTesting\PHPUnit;

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
        return \defined('ConfigTransformerPrefix202310\\PHPUNIT_COMPOSER_INSTALL') || \defined('ConfigTransformerPrefix202310\\__PHPUNIT_PHAR__');
    }
}
