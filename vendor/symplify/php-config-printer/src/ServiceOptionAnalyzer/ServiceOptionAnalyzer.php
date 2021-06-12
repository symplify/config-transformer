<?php

declare (strict_types=1);
namespace ConfigTransformer2021061210\Symplify\PhpConfigPrinter\ServiceOptionAnalyzer;

use ConfigTransformer2021061210\Nette\Utils\Strings;
final class ServiceOptionAnalyzer
{
    public function hasNamedArguments(array $data) : bool
    {
        if ($data === []) {
            return \false;
        }
        foreach (\array_keys($data) as $key) {
            if (!\ConfigTransformer2021061210\Nette\Utils\Strings::startsWith((string) $key, '$')) {
                return \false;
            }
        }
        return \true;
    }
}
