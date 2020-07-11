<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory;

use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\VariableName;
use PhpParser\BuilderHelpers;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Expression;

final class ImportNodeFactory
{
    /**
     * @var CommonFactory
     */
    private $commonFactory;

    public function __construct(CommonFactory $commonFactory)
    {
        $this->commonFactory = $commonFactory;
    }

    /**
     * @param mixed[] $arguments
     */
    public function createImportMethodCall(array $arguments): Expression
    {
        $containerConfiguratorVariable = new Variable(VariableName::CONTAINER_CONFIGURATOR);
        $methodCall = new MethodCall($containerConfiguratorVariable, 'import');

        foreach ($arguments as $argument) {
            if (is_bool($argument) || in_array($argument, ['annotations', 'directory', 'glob'], true)) {
                $expr = BuilderHelpers::normalizeValue($argument);
            } else {
                $expr = $this->commonFactory->createAbsoluteDirExpr($argument);
            }

            $methodCall->args[] = new Arg($expr);
        }

        return new Expression($methodCall);
    }
}
