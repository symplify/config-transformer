<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Converter\KeyYamlToPhpFactory;

use Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter\KeyYamlToPhpFactoryInterface;
use Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter\ServiceKeyYamlToPhpFactoryInterface;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\ArgsNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\CommonNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\Service\ServiceOptionNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\ServicesPhpNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\SingleServicePhpNodeFactory;
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
 * services: <---
 */
final class ServicesKeyYamlToPhpFactory implements KeyYamlToPhpFactoryInterface
{
    /**
     * @var string
     */
    private const RESOURCE = 'resource';

    /**
     * @var string
     */
    private const CLASS_KEY = 'class';

    /**
     * @var string
     */
    private const ALIAS = 'alias';

    /**
     * @var string
     */
    private const SERVICES = 'services';

    /**
     * @var ServicesPhpNodeFactory
     */
    private $servicesPhpNodeFactory;

    /**
     * @var CommonNodeFactory
     */
    private $commonNodeFactory;

    /**
     * @var ArgsNodeFactory
     */
    private $argsNodeFactory;

    /**
     * @var SingleServicePhpNodeFactory
     */
    private $singleServicePhpNodeFactory;

    /**
     * @var ServiceKeyYamlToPhpFactoryInterface[]
     */
    private $serviceKeyYamlToPhpFactories = [];

    /**
     * @var ServiceOptionNodeFactory
     */
    private $serviceOptionNodeFactory;

    /**
     * @param ServiceKeyYamlToPhpFactoryInterface[] $serviceKeyYamlToPhpFactories
     */
    public function __construct(
        ServicesPhpNodeFactory $servicesPhpNodeFactory,
        CommonNodeFactory $commonNodeFactory,
        ArgsNodeFactory $argsNodeFactory,
        SingleServicePhpNodeFactory $singleServicePhpNodeFactory,
        ServiceOptionNodeFactory $serviceOptionNodeFactory,
        array $serviceKeyYamlToPhpFactories
    ) {
        $this->servicesPhpNodeFactory = $servicesPhpNodeFactory;
        $this->commonNodeFactory = $commonNodeFactory;
        $this->argsNodeFactory = $argsNodeFactory;
        $this->singleServicePhpNodeFactory = $singleServicePhpNodeFactory;
        $this->serviceKeyYamlToPhpFactories = $serviceKeyYamlToPhpFactories;
        $this->serviceOptionNodeFactory = $serviceOptionNodeFactory;
    }

    public function getKey(): string
    {
        return self::SERVICES;
    }

    /**
     * @return Node[]
     */
    public function convertYamlToNodes(array $services): array
    {
        $nodes = [];
        $nodes[] = $this->servicesPhpNodeFactory->createServicesInit();

        foreach ($services as $serviceKey => $serviceValues) {
            foreach ($this->serviceKeyYamlToPhpFactories as $serviceKeyYamlToPhpFactory) {
                if ($serviceKeyYamlToPhpFactory->getSubServiceKey() === $serviceKey) {
                    $freshNodes = $serviceKeyYamlToPhpFactory->convertYamlToNodes($serviceValues);
                    $nodes = array_merge($nodes, $freshNodes);
                    continue 2;
                }
            }

            if (isset($serviceValues[self::RESOURCE])) {
                $resourceNodes = $this->resolveResource($serviceKey, $serviceValues);
                $nodes = array_merge($nodes, $resourceNodes);
                continue;
            }

            if ($this->isAlias($serviceKey, $serviceValues)) {
                $aliasNodes = $this->addAliasNode($serviceKey, $serviceValues);
                $nodes = array_merge($nodes, $aliasNodes);
                continue;
            }

            if (isset($serviceValues[self::CLASS_KEY])) {
                $serviceNodes = $this->createService($serviceValues, $serviceKey);
                $nodes = array_merge($nodes, $serviceNodes);
                continue;
            }

            if ($serviceValues === null) {
                $setMethodCall = $this->singleServicePhpNodeFactory->createSetService($serviceKey);
            } else {
                $args = $this->argsNodeFactory->createFromValues([$serviceKey]);
                $setMethodCall = new MethodCall(new Variable(VariableName::SERVICES), 'set', $args);
                $setMethodCall = $this->serviceOptionNodeFactory->convertServiceOptionsToNodes(
                    $serviceValues,
                    $setMethodCall
                );
            }

            $nodes[] = new Expression($setMethodCall);
        }

        return $nodes;
    }

    /**
     * @return Node[]
     */
    private function addAliasNode($serviceKey, $serviceValues): array
    {
        $nodes = [];

        $servicesVariable = new Variable('services');

        if (class_exists($serviceKey) || interface_exists($serviceKey)) {
            // $this->addUseStatementIfNecessary($serviceValues[self::ALIAS]); - @todo import alias

            $classReference = $this->commonNodeFactory->createClassReference($serviceKey);

            $values = [$classReference];
            $values[] = $serviceValues[self::ALIAS] ?? $serviceValues;

            $args = $this->argsNodeFactory->createFromValues($values, true);

            $methodCall = new MethodCall($servicesVariable, 'alias', $args);
            return [new Expression($methodCall)];
        }

        if ($fullClassName = strstr($serviceKey, ' $', true)) {
            $methodCall = $this->createAliasNode($serviceKey, $fullClassName, $serviceValues);
            return [new Expression($methodCall)];
        }

        if (isset($serviceValues[self::ALIAS])) {
            $className = $serviceValues[self::ALIAS];

            $classReference = $this->commonNodeFactory->createClassReference($className);
            $args = $this->argsNodeFactory->createFromValues([$serviceKey, $classReference]);
            $methodCall = new MethodCall($servicesVariable, self::ALIAS, $args);
            unset($serviceValues[self::ALIAS]);
        }

        if (is_string($serviceValues) && $serviceValues[0] === '@') {
            $args = $this->argsNodeFactory->createFromValues([$serviceValues], true);
            $methodCall = new MethodCall($servicesVariable, self::ALIAS, $args);
        }

        if (is_array($serviceValues)) {
            /** @var MethodCall $methodCall */
            $methodCall = $this->serviceOptionNodeFactory->convertServiceOptionsToNodes($serviceValues, $methodCall);
        }

        $nodes[] = new Expression($methodCall);

        return $nodes;
    }

    private function isAlias(string $serviceKey, $serviceValues): bool
    {
        return isset($serviceValues[self::ALIAS])
            || strstr($serviceKey, ' $', true)
            || is_string($serviceValues) && $serviceValues[0] === '@';
    }

    /**
     * @return Node[]
     */
    private function createService(array $serviceValues, string $serviceKey): array
    {
        $nodes = [];

        $args = $this->argsNodeFactory->createFromValues([$serviceKey, $serviceValues[self::CLASS_KEY]]);
        $setMethodCall = new MethodCall(new Variable(VariableName::SERVICES), 'set', $args);

        unset($serviceValues[self::CLASS_KEY]);

        $setMethodCall = $this->serviceOptionNodeFactory->convertServiceOptionsToNodes($serviceValues, $setMethodCall);
        $nodes[] = new Expression($setMethodCall);

        return $nodes;
    }

    private function createAliasNode($serviceKey, string $fullClassName, $serviceValues): MethodCall
    {
        $argument = strstr($serviceKey, '$');

        $methodCall = new MethodCall(new Variable(VariableName::SERVICES), self::ALIAS);

        $classConstReference = $this->commonNodeFactory->createClassReference($fullClassName);
        $concat = new Concat($classConstReference, new String_(' ' . $argument));

        $methodCall->args[] = new Arg($concat);

        $serviceName = ltrim($serviceValues, '@');
        $methodCall->args[] = new Arg(new String_($serviceName));

        return $methodCall;
    }

    /**
     * @return Node[]
     */
    private function resolveResource($serviceKey, $serviceValues): array
    {
        // Due to the yaml behavior that does not allow the declaration of several identical key names.
        if (isset($serviceValues['namespace'])) {
            $serviceKey = $serviceValues['namespace'];
            unset($serviceValues['namespace']);
        }

        $resource = $this->servicesPhpNodeFactory->createResource($serviceKey, $serviceValues);
        return [$resource];
    }
}
