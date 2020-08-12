<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Converter\ServiceOptionsKeyYamlToPhpFactory;

use Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use Migrify\ConfigTransformer\FormatSwitcher\Exception\NotImplementedYetException;
use PhpParser\Node\Expr\MethodCall;

final class SharedPublicServiceOptionKeyYamlToPhpFactory implements ServiceOptionsKeyYamlToPhpFactoryInterface
{
    public function decorateServiceMethodCall($key, $yaml, $values, MethodCall $methodCall): MethodCall
    {
        if ($key === 'public') {
            if ($yaml === false) {
                return new MethodCall($methodCall, 'private');
            }

            return new MethodCall($methodCall, 'public');
        }

        throw new NotImplementedYetException();
    }

    public function isMatch($key, $values): bool
    {
        return in_array($key, ['shared', 'public'], true);
    }
}
