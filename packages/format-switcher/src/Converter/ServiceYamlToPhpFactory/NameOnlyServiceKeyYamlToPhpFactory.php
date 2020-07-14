<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Converter\ServiceYamlToPhpFactory;

use Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter\ServiceKeyYamlToPhpFactoryInterface;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\CommonNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\VariableName;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Expression;

/**
 * Handles this part:
 *
 * services:
 *     SomeNamespace\SomeClass: null <---
 */
final class NameOnlyServiceKeyYamlToPhpFactory implements ServiceKeyYamlToPhpFactoryInterface
{
    /**
     * @var CommonNodeFactory
     */
    private $commonNodeFactory;

    public function __construct(CommonNodeFactory $commonNodeFactory)
    {
        $this->commonNodeFactory = $commonNodeFactory;
    }

    /**
     * @return Expression[]
     */
    public function convertYamlToNodes($key, $yaml): array
    {
        $classReference = $this->commonNodeFactory->createClassReference($key);
        $setMethodCall = new MethodCall(new Variable(VariableName::SERVICES), 'set', [new Arg($classReference)]);

        return [new Expression($setMethodCall)];
    }

    public function isMatch($key, $values): bool
    {
        return $values === null || $values === [];
    }
}
