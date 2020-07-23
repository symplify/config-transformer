<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Converter\ServiceKeyYamlToPhpFactory;

use Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter\ServiceKeyYamlToPhpFactoryInterface;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\ArgsNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\CommonNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\Service\ServiceOptionNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\MethodName;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\VariableName;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\BinaryOp\Concat;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Expression;

/**
 * Handles this part:
 *
 * services:
 *     Some: Other <---
 */
final class AliasServiceKeyYamlToPhpFactory implements ServiceKeyYamlToPhpFactoryInterface
{
    /**
     * @var CommonNodeFactory
     */
    private $commonNodeFactory;

    /**
     * @var ArgsNodeFactory
     */
    private $argsNodeFactory;

    /**
     * @var ServiceOptionNodeFactory
     */
    private $serviceOptionNodeFactory;

    public function __construct(
        CommonNodeFactory $commonNodeFactory,
        ArgsNodeFactory $argsNodeFactory,
        ServiceOptionNodeFactory $serviceOptionNodeFactory
    ) {
        $this->commonNodeFactory = $commonNodeFactory;
        $this->argsNodeFactory = $argsNodeFactory;
        $this->serviceOptionNodeFactory = $serviceOptionNodeFactory;
    }

    public function convertYamlToNode($key, $yaml): Node
    {
        $servicesVariable = new Variable('services');

        if (class_exists($key) || interface_exists($key)) {
            // $this->addUseStatementIfNecessary($values[self::ALIAS]); - @todo import alias

            $classReference = $this->commonNodeFactory->createClassReference($key);

            $argValues = [];
            $argValues[] = $classReference;
            $argValues[] = $yaml[MethodName::ALIAS] ?? $yaml;

            $args = $this->argsNodeFactory->createFromValues($argValues, true);
            $methodCall = new MethodCall($servicesVariable, MethodName::ALIAS, $args);
            return new Expression($methodCall);
        }

        // handles: "SomeClass $someVariable: ..."
        if ($fullClassName = strstr($key, ' $', true)) {
            $methodCall = $this->createAliasNode($key, $fullClassName, $yaml);
            return new Expression($methodCall);
        }

        if (isset($yaml[MethodName::ALIAS])) {
            $className = $yaml[MethodName::ALIAS];

            $classReference = $this->commonNodeFactory->createClassReference($className);
            $args = $this->argsNodeFactory->createFromValues([$key, $classReference]);
            $methodCall = new MethodCall($servicesVariable, MethodName::ALIAS, $args);

            unset($yaml[MethodName::ALIAS]);
        }

        /** @var string|mixed[] $yaml */
        if (is_string($yaml) && $yaml[0] === '@') {
            $args = $this->argsNodeFactory->createFromValues([$yaml], true);
            $methodCall = new MethodCall($servicesVariable, MethodName::ALIAS, $args);
        } elseif (is_array($yaml)) {
            /** @var MethodCall $methodCall */
            $methodCall = $this->serviceOptionNodeFactory->convertServiceOptionsToNodes($yaml, $methodCall);
        }

        return new Expression($methodCall);
    }

    public function isMatch($key, $values): bool
    {
        if (isset($values[MethodName::ALIAS])) {
            return true;
        }

        if (strstr($key, ' $', true)) {
            return true;
        }

        return is_string($values) && $values[0] === '@';
    }

    private function createAliasNode(string $key, string $fullClassName, $serviceValues): MethodCall
    {
        $args = [];

        $classConstFetch = $this->commonNodeFactory->createClassReference($fullClassName);
        $argumentName = strstr($key, '$');
        $concat = new Concat($classConstFetch, new String_(' ' . $argumentName));
        $args[] = new Arg($concat);

        $serviceName = ltrim($serviceValues, '@');
        $args[] = new Arg(new String_($serviceName));

        return new MethodCall(new Variable(VariableName::SERVICES), MethodName::ALIAS, $args);
    }
}
