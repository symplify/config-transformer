<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter;

use PhpParser\Node\Expr\MethodCall;

interface ServiceOptionsKeyYamlToPhpFactoryInterface
{
    public function decorateServiceMethodCall($key, $yaml, $values, MethodCall $serviceMethodCall): MethodCall;

    public function isMatch($key, $values): bool;
}
