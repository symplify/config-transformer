<?php

declare (strict_types=1);
namespace ConfigTransformer202110105\Symplify\PhpConfigPrinter\ServiceOptionAnalyzer;

final class ServiceOptionAnalyzer
{
    public function hasNamedArguments(array $data) : bool
    {
        if ($data === []) {
            return \false;
        }
        foreach (\array_keys($data) as $key) {
            if (\strncmp((string) $key, '$', \strlen('$')) !== 0) {
                return \false;
            }
        }
        return \true;
    }
}
