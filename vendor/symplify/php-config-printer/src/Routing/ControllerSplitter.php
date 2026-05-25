<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\Routing;

use Symplify\PhpConfigPrinter\Enum\RouteOption;
use Symplify\PhpConfigPrinter\ValueObject\Routing\RouteDefaults;
final class ControllerSplitter
{
    /**
     * @return string[]|string
     */
    public function splitControllerClassAndMethod(string $controllerValue)
    {
        if (\strpos($controllerValue, '::') === \false) {
            return $controllerValue;
        }
        return \explode('::', $controllerValue);
    }
    /**
     * @param mixed $nestedValues
     */
    public function hasControllerDefaults(string $nestedKey, $nestedValues) : bool
    {
        if ($nestedKey !== RouteOption::DEFAULTS) {
            return \false;
        }
        return \array_key_exists(RouteDefaults::CONTROLLER, $nestedValues);
    }
}
