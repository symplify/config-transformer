<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\PhpParser\Printer;

use Nette\Utils\Strings;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\PrettyPrinter\Standard;

final class FluentMethodCallPrinter extends Standard
{
    protected function pExpr_MethodCall(MethodCall $methodCall): string
    {
        $printedMethodCall = parent::pExpr_MethodCall($methodCall);

        $nextCallIndentReplacement = ')' . PHP_EOL . Strings::indent('->', 8, ' ');

        return Strings::replace($printedMethodCall, '#\)->#', $nextCallIndentReplacement);
    }
}
