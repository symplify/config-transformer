<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Converter\ServiceKeyYamlToPhpFactory;

use Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter\ServiceKeyYamlToPhpFactoryInterface;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\ArgsNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\CommonNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\Service\ServiceOptionNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\VariableName;
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
     * @var string
     */
    private const ALIAS = 'alias';

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

    public function convertYamlToNodes($key, $yaml): array
    {
        $nodes = [];

        $servicesVariable = new Variable('services');

        if (class_exists($key) || interface_exists($key)) {
            // $this->addUseStatementIfNecessary($values[self::ALIAS]); - @todo import alias

            $classReference = $this->commonNodeFactory->createClassReference($key);

            $argValues = [];
            $argValues[] = $classReference;
            $argValues[] = $yaml[self::ALIAS] ?? $yaml;

            $args = $this->argsNodeFactory->createFromValues($argValues, true);
            $methodCall = new MethodCall($servicesVariable, self::ALIAS, $args);
            return [new Expression($methodCall)];
        }

        // handles: "SomeClass $someVariable: ..."
        if ($fullClassName = strstr($key, ' $', true)) {
            $methodCall = $this->createAliasNode($key, $fullClassName, $yaml);
            return [new Expression($methodCall)];
        }

        if (isset($yaml[self::ALIAS])) {
            $className = $yaml[self::ALIAS];

            $classReference = $this->commonNodeFactory->createClassReference($className);
            $args = $this->argsNodeFactory->createFromValues([$key, $classReference]);
            $methodCall = new MethodCall($servicesVariable, self::ALIAS, $args);

            unset($yaml[self::ALIAS]);
        }

        /** @var string|mixed[] $yaml */
        if (is_string($yaml) && $yaml[0] === '@') {
            $args = $this->argsNodeFactory->createFromValues([$yaml], true);
            $methodCall = new MethodCall($servicesVariable, self::ALIAS, $args);
        } elseif (is_array($yaml)) {
            /** @var MethodCall $methodCall */
            $methodCall = $this->serviceOptionNodeFactory->convertServiceOptionsToNodes($yaml, $methodCall);
        }

        $nodes[] = new Expression($methodCall);

        return $nodes;
    }

    public function isMatch($key, $values): bool
    {
        if (isset($values[self::ALIAS])) {
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

        $classConstReference = $this->commonNodeFactory->createClassReference($fullClassName);
        $argumentName = strstr($key, '$');
        $concat = new Concat($classConstReference, new String_(' ' . $argumentName));
        $args[] = new Arg($concat);

        $serviceName = ltrim($serviceValues, '@');
        $args[] = new Arg(new String_($serviceName));

        return new MethodCall(new Variable(VariableName::SERVICES), self::ALIAS, $args);
    }
}
