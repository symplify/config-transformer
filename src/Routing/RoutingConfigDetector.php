<?php

declare (strict_types=1);
namespace Symplify\ConfigTransformer\Routing;

/**
 * @see \Symplify\ConfigTransformer\Tests\Routing\RoutingConfigDetectorTest
 */
final class RoutingConfigDetector
{
    public function isRoutingFilePath(string $filePath) : bool
    {
        if (\strpos($filePath, \DIRECTORY_SEPARATOR . 'packages' . \DIRECTORY_SEPARATOR) !== \false) {
            return \false;
        }
        // if the paths contains this keyword, we assume it contains routes
        if (\strpos($filePath, 'routing') !== \false) {
            return \true;
        }
        return \strpos($filePath, 'routes') !== \false;
    }
}
