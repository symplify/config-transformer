<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Contract;

use PhpParser\Node\Stmt\Expression;

interface NestedCaseConverterInterface
{
    public function match(string $rootKey, string $subKey): bool;

    public function convertToMethodCall($key, $values): Expression;
}
