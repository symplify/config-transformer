<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter;

use PhpParser\Node\Stmt\Expression;

interface CaseConverterInterface
{
    public function match(string $rootKey, $key, $values): bool;

    public function convertToMethodCall($key, $values): Expression;
}
