<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Converter;

use InvalidArgumentException;
use LogicException;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\ClosureNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\PhpNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\ServicesPhpNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\Printer\FluentMethodCallPrinter;
use Nette\Utils\Strings;
use PhpParser\Builder\Use_ as UseBuilder;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Node\Stmt\Nop;
use PhpParser\Node\Stmt\Return_;
use PhpParser\Node\Stmt\Use_;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Tag\TaggedValue;
use Symfony\Component\Yaml\Yaml;

/**
 * @source https://raw.githubusercontent.com/archeoprog/maker-bundle/make-convert-services/src/Util/PhpServicesCreator.php
 *
 * @see \Migrify\ConfigTransformer\FormatSwitcher\Tests\Converter\ConfigFormatConverter\YamlToPhpTest
 */
final class YamlToPhpConverter
{
    /**
     * @var string
     */
    private const CONTAINER_CONFIGURATOR_NAME = 'containerConfigurator';

    /**
     * @var string
     */
    private const EOL_CHAR = "\n";

    /**
     * @var Node[]
     */
    private $stmts = [];

    /**
     * @var string[]
     */
    private $useStatements = [];

    /**
     * @var Parser
     */
    private $yamlParser;

    /**
     * @var PhpNodeFactory
     */
    private $phpNodeFactory;

    /**
     * @var ServicesPhpNodeFactory
     */
    private $servicesPhpNodeFactory;

    /**
     * @var ClosureNodeFactory
     */
    private $closureNodeFactory;

    /**
     * @var FluentMethodCallPrinter
     */
    private $fluentMethodCallPrinter;

    public function __construct(
        Parser $yamlParser,
        PhpNodeFactory $phpNodeFactory,
        ServicesPhpNodeFactory $servicesPhpNodeFactory,
        ClosureNodeFactory $closureNodeFactory,
        FluentMethodCallPrinter $fluentMethodCallPrinter
    ) {
        $this->yamlParser = $yamlParser;
        $this->phpNodeFactory = $phpNodeFactory;
        $this->servicesPhpNodeFactory = $servicesPhpNodeFactory;
        $this->closureNodeFactory = $closureNodeFactory;
        $this->fluentMethodCallPrinter = $fluentMethodCallPrinter;
    }

    public function convert(string $yaml): string
    {
        $namespace = new Namespace_(new Name('Symfony\Component\DependencyInjection\Loader\Configurator'));

        $yamlArray = $this->yamlParser->parse($yaml, Yaml::PARSE_CUSTOM_TAGS);
        $closureStmts = $this->createClosureStmts($yamlArray, $namespace);

        $closure = $this->closureNodeFactory->createClosureFromStmts($closureStmts);
        $return = new Return_($closure);

        // add a blank line between the last use statement and the closure
        if ($this->useStatements !== []) {
            $namespace->stmts[] = new Nop();
        }

        $namespace->stmts[] = $return;

        return $this->fluentMethodCallPrinter->prettyPrintFile([$namespace]) . self::EOL_CHAR;
    }

    /**
     * @return Node[]
     */
    private function createClosureStmts(array $yamlData, Namespace_ $namespace): array
    {
        foreach ($yamlData as $key => $values) {
            if ($values === null) {
                // declare the variable ($parameters/$services) even if the key is written without values.
                $values = [];
            }
            switch ($key) {
                case 'parameters':
                    $this->addParametersNodes($values);
                    break;
                case 'imports':
                    $this->addImportsNodes($values);
                    break;
                case 'services':
                    $this->addServicesNodes($values);
                    break;
                default:
                    throw new LogicException(sprintf(
                        'The key %s is not supported by the converter: only service config can live in services.yaml for conversion.',
                        $key
                    ));
                    break;
            }
        }

        sort($this->useStatements);
        foreach ($this->useStatements as $className) {
            $useBuilder = new UseBuilder($className, Use_::TYPE_NORMAL);
            $namespace->stmts[] = $useBuilder->getNode();
        }

        // remove the last carriage return "\n" if exists.
        $lastStmt = $this->stmts[array_key_last($this->stmts)];

        if ($lastStmt instanceof Name) {
            $lastStmt->parts[0] = rtrim($lastStmt->parts[0], self::EOL_CHAR);
        }

        $lastKey = array_key_last($this->stmts);
        if ($this->stmts[$lastKey] instanceof Nop) {
            unset($this->stmts[$lastKey]);
        }

        return $this->stmts;
    }

    private function addParametersNodes(array $parameters): void
    {
        $assign = $this->phpNodeFactory->createAssignContainerCallToVariable('parameters', 'parameters');
        $this->addNodeAsExpression($assign);

        foreach ($parameters as $parameterName => $value) {
            $parametersSetMethodCall = $this->phpNodeFactory->createParameterSetMethodCall($parameterName, $value);
            $this->addNodeAsExpression($parametersSetMethodCall);
        }

        // separater parameters by empty space
        if (count($parameters)) {
            $this->addNode(new Nop());
        }
    }

    private function addImportsNodes(array $imports): void
    {
        foreach ($imports as $import) {
            if (is_array($import)) {
                $arguments = $this->sortArgumentsByKeyIfExists($import, ['resource', 'type', 'ignore_errors']);

                $methodCall = $this->phpNodeFactory->createImportMethodCall($arguments);
                $this->addNodeAsExpression($methodCall);
                continue;
            }

            $import = $this->createStringArgument($import);

            $line = sprintf('$%s->import(%s);', self::CONTAINER_CONFIGURATOR_NAME, $import);
            $this->addLineStmt($line, false);
        }

        if (count($imports)) {
            $this->addNode(new Nop());
        }
    }

    private function addServicesNodes(array $services): void
    {
        $line = sprintf('$services = $%s->services();', self::CONTAINER_CONFIGURATOR_NAME);
        $this->addLineStmt($line, true);

        foreach ($services as $serviceKey => $serviceValues) {
            if ($serviceKey === '_defaults') {
                $methodCall = new MethodCall(new Variable('services'), 'defaults');
                $this->addNode($methodCall);

                $this->convertServiceOptionsToNodes($serviceValues);
                $this->addLineStmt(';', true);

                continue;
            }

            if ($serviceKey === '_instanceof') {
                foreach ($serviceValues as $instanceKey => $instanceValues) {
                    $className = $this->addUseStatementIfNecessary($instanceKey);

                    $this->addLineStmt(sprintf('$services->instanceof(%s)', $className));

                    $this->convertServiceOptionsToNodes($instanceValues);

                    $this->addLineStmt(';', true);
                }

                continue;
            }

            if (isset($serviceValues['resource'])) {
                // Due to the yaml behavior that does not allow the declaration of several identical key names.
                if (isset($serviceValues['namespace'])) {
                    $serviceKey = $serviceValues['namespace'];
                    unset($serviceValues['namespace']);
                }

                $servicesLoadMethodCall = $this->servicesPhpNodeFactory->createServicesLoadMethodCall(
                    $serviceKey,
                    $serviceValues
                );

                $lastMethodCall = $servicesLoadMethodCall;

                $exclude = $serviceValues['exclude'] ?? [];
                foreach ($exclude as $singleExclude) {
                    $excludeMethodCall = new MethodCall($lastMethodCall, 'exclude');
                    $excludeMethodCall->args[] = $this->phpNodeFactory->createAbsoluteDirExpr($singleExclude);

                    $lastMethodCall = $excludeMethodCall;
                }

                $this->addNodeAsExpression($lastMethodCall);

                if (count($serviceValues) > 1) {
                    unset($serviceValues['resource']);
                    unset($serviceValues['exclude']);

                    $this->convertServiceOptionsToNodes($serviceValues);
                }

                continue;
            }

            if ($this->isAlias($serviceKey, $serviceValues)) {
                $this->addAliasNode($serviceKey, $serviceValues);

                continue;
            }

            if (isset($serviceValues['class'])) {
                $className = $this->addUseStatementIfNecessary($serviceValues['class']);

                $this->addLineStmt(sprintf(
                    '$services->set(%s, %s)',
                    $this->createStringArgument($serviceKey),
                    $className
                ));

                unset($serviceValues['class']);
                $this->convertServiceOptionsToNodes($serviceValues);
                $this->addLineStmt(';', true);

                continue;
            }

            $className = $this->addUseStatementIfNecessary($serviceKey);

            if ($serviceValues === null) {
                $this->addLineStmt(sprintf('$services->set(%s);', $className), true);
            } else {
                $this->addLineStmt(sprintf('$services->set(%s)', $className));
                $this->convertServiceOptionsToNodes($serviceValues);
                $this->addLineStmt(';', true);
            }
        }
    }

    private function convertServiceOptionsToNodes(array $servicesValues): void
    {
        foreach ($servicesValues as $serviceConfigKey => $value) {
            // options started by decoration_<option> are used as options of the method decorate().
            if (strstr($serviceConfigKey, 'decoration_')) {
                continue;
            }

            switch ($serviceConfigKey) {
                case 'decorates':
                    $this->addLineStmt($this->createDecorateMethod($servicesValues));

                    break;

                case 'deprecated':
                    $this->addLineStmt($this->createDeprecateMethod($value));

                    break;

                // simple "key: value" options
                case 'shared':
                case 'public':
                    if (is_array($value)) {
                        if ($this->isAssociativeArray($value)) {
                            throw new InvalidArgumentException(sprintf(
                                'The config key "%s" does not support an associative array',
                                $serviceConfigKey
                            ));
                        }

                        $this->addLineStmt($this->createMethod(
                            $serviceConfigKey,
                            // the handles converting all formats of the single arg
                            $this->toString($value)
                        ));

                        break;
                    }
                    // no break
                case 'autowire':
                case 'autoconfigure':
                    if (is_array($value)) {
                        throw new InvalidArgumentException(sprintf(
                            'The "%s" service option does not support being set to an array value.',
                            $serviceConfigKey
                        ));
                    }

                    $method = $serviceConfigKey;
                    if ($serviceConfigKey === 'shared') {
                        $method = 'share';
                    }

                    $this->addLineStmt($this->createMethod($method, $this->toString($value)));

                    break;

                case 'factory':
                case 'configurator':
                    if (is_array($value) && $this->isAssociativeArray($value)) {
                        throw new InvalidArgumentException(sprintf(
                            'The config key "%s" does not support an associative array',
                            $serviceConfigKey
                        ));
                    }

                    $this->addLineStmt($this->createMethod(
                        $serviceConfigKey,
                        // the handles converting all formats of the single arg
                        $this->toString($value)
                    ));

                    break;

                case 'tags':
                    if (is_array($value) && $this->isAssociativeArray($value)) {
                        throw new InvalidArgumentException('Unexpected associative array value for "tags"');
                    }

                    foreach ($value as $argValue) {
                        $this->addLineStmt($this->createTagMethod($argValue));
                    }

                    break;

                case 'calls':
                    if ($this->isAssociativeArray($value)) {
                        throw new InvalidArgumentException('Unexpected associative array for "calls" config.');
                    }

                    foreach ($value as $argValue) {
                        $this->addLineStmt($this->createCallMethod($argValue));
                    }

                    break;

                case 'arguments':
                    if ($this->isAssociativeArray($value)) {
                        foreach ($value as $argKey => $argValue) {
                            $this->addLineStmt($this->createMethod(
                                'arg',
                                $this->createStringArgument($argKey),
                                $this->toString($argValue)
                            ));
                        }
                    } else {
                        $this->addLineStmt($this->createMethod('args', $this->createSequentialArray($value)));
                    }

                    break;

                default:
                    throw new InvalidArgumentException(sprintf(
                        'Unexpected service configuration option: "%s".',
                        $serviceConfigKey
                    ));
            }
        }
    }

    private function addAliasNode($serviceKey, $serviceValues): void
    {
        if (class_exists($serviceKey) || interface_exists($serviceKey)) {
            $shortClassName = $this->addUseStatementIfNecessary($serviceKey);
            // extract '@' before calling method createStringArgument() because service() is not necessary.
            $alias = $this->createStringArgument($serviceValues['alias']);

            $this->addLineStmt(sprintf('$services->alias(%s, %s);', $shortClassName, $alias), true);
            return;
        }

        if ($fullClassName = strstr($serviceKey, ' $', true)) {
            $argument = strstr($serviceKey, '$');
            $shortClassName = $this->addUseStatementIfNecessary($fullClassName) . ".' " . $argument . "'";
            // extract '@' before calling method createStringArgument() because service() is not necessary.
            $alias = $this->createStringArgument(substr($serviceValues, 1));

            $this->addLineStmt(sprintf('$services->alias(%s, %s);', $shortClassName, $alias), true);

            return;
        }

        if (isset($serviceValues['alias'])) {
            $className = $this->addUseStatementIfNecessary($serviceValues['alias']);

            $this->addLineStmt(sprintf(
                '$services->alias(%s, %s)',
                $this->createStringArgument($serviceKey),
                $className
            ));

            unset($serviceValues['alias']);
        }

        if (is_string($serviceValues) && $serviceValues[0] === '@') {
            $className = $this->addUseStatementIfNecessary($serviceKey);
            $value = $this->createStringArgument(substr($serviceValues, 1));
            $this->addLineStmt(sprintf('$services->alias(%s, %s);', $className, $value), true);
        }

        if (is_array($serviceValues)) {
            $this->convertServiceOptionsToNodes($serviceValues);
            $this->addLineStmt(';', true);
        }
    }

    private function createMethod(string $method, ...$argumentStrings): string
    {
        if ($method === 'public' && $argumentStrings[0] === 'false') {
            $method = 'private';
            $argumentStrings[0] = null;
        }

        if ($method === 'arguments') {
            $method = 'args';
        }

        return self::tab() . sprintf('->%s(%s)', $method, implode(', ', $argumentStrings));
    }

    private function createDecorateMethod(array $value): string
    {
        $arguments = $this->sortArgumentsByKeyIfExists($value, [
            'decoration_inner_name' => null,
            'decoration_priority' => 0,
            'decoration_on_invalid' => null,
        ]);

        if (isset($arguments['decoration_on_invalid'])) {
            $this->addUseStatementIfNecessary(ContainerInterface::class);
            $arguments['decoration_on_invalid'] = $arguments['decoration_on_invalid'] === 'exception'
                ? 'ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE'
                : 'ContainerInterface::IGNORE_ON_INVALID_REFERENCE';
        }

        // Don't write the next arguments if they are null.
        if ($arguments['decoration_on_invalid'] === null && $arguments['decoration_priority'] === 0) {
            unset($arguments['decoration_on_invalid'], $arguments['decoration_priority']);

            if ($arguments['decoration_inner_name'] === null) {
                unset($arguments['decoration_inner_name']);
            }
        }
        array_unshift($arguments, $value['decorates']);

        return sprintf(self::tab() . '->decorate(%s)', $this->createListFromArray($arguments));
    }

    private function createCallMethod($values): string
    {
        if (isset($values['method'])) {
            $method = $values['method'];

            if (isset($values['arguments'])) {
                $values[1] = $values['arguments'];
            }

            if (isset($values['returns_clone'])) {
                $values[2] = $values['returns_clone'];
            }
        } elseif (is_string(array_key_first($values))) {
            // if the first index is a string, it means that it is the name of the called method.
            $method = array_key_first($values);
        } else {
            // else, the name of the method is the value.
            $method = $values[0];
        }

        if (isset($values['withLogger'])) {
            $values[1] = $values['withLogger']->getValue();
            $values[2] = $values['withLogger']->getTag() === 'returns_clone';
        } elseif (isset($values[$method])) {
            $values[1] = $values[$method];
        }

        $value = sprintf(
            self::tab() . '->call(%s, %s',
            $this->createStringArgument($method),
            $this->toString($values[1])
        );

        if (isset($values[2]) && is_bool($values[2])) {
            $value .= $values[2] ? ', true' : ', false';
        }

        return $value . ')';
    }

    private function createTagMethod($value): string
    {
        if (! is_array($value)) {
            $value = ['name' => $value];
        }

        $name = $this->toString($value['name']);
        unset($value['name']);

        if (empty($value)) {
            return $this->createMethod('tag', $name);
        }

        return $this->createMethod('tag', $name, $this->createAssociativeArray($value));
    }

    private function createDeprecateMethod($value): string
    {
        // the old, simple format
        if (! is_array($value)) {
            return $this->createMethod('deprecate', $this->toString($value));
        }

        $package = $value['package'] ?? '';
        $version = $value['version'] ?? '';
        $message = $value['message'] ?? '';

        return $this->createMethod(
            'deprecate',
            $this->toString($package),
            $this->toString($version),
            $this->toString($message)
        );
    }

    /**
     * @param $value
     */
    private function toString($value, bool $preserveValueIfTrueBoolean = false): string
    {
        if ($value instanceof TaggedValue) {
            return $this->createTaggedValue($value);
        }

        switch (gettype($value)) {
            case 'array':
                return $this->createArrayArgument($value);
            case 'string':
                return strstr($value, '::') ? $value : $this->createStringArgument($value);
            case 'boolean':
                // The convertor preserve the boolean values only if it's necessary. >>>
                if ($preserveValueIfTrueBoolean && $value === true) {
                    return 'true';
                }
                // >>> Because most of the methods don't need to pass true as an argument.
                return $value === true ? '' : 'false';
            case 'NULL':
                return 'null';
            default:
                return $value;
        }
    }

    private function createTaggedValue($value): string
    {
        if ($value->getTag() === 'service') {
            $className = $this->addUseStatementIfNecessary($value->getValue()['class']);

            return 'inline_service(' . $className . ')';
        }

        if (is_array($value->getValue())) {
            $argumentsInOrder = $this->sortArgumentsByKeyIfExists(
                $value->getValue(),
                ['tag', 'index_by', 'default_index_method']
            );

            $args = $this->createListFromArray($argumentsInOrder);
        } else {
            $args = $this->toString($value->getValue());
        }

        return $value->getTag() . '(' . $args . ')';
    }

    private function createArrayArgument(array $values): string
    {
        return $this->isAssociativeArray($values)
            ? $this->createAssociativeArray($values)
            : $this->createSequentialArray($values);
    }

    private function createSequentialArray(array $array, bool $transformInList = false): string
    {
        if ($this->isIndentationRequired($array)) {
            $stringArray = self::EOL_CHAR;
            foreach ($array as $subValue) {
                $stringArray .= self::tab(3) . $this->toString($subValue, true) . ',' . self::EOL_CHAR;
            }

            if ($transformInList) {
                $stringArray = substr_replace($stringArray, '', -2, 1);
            }
            $stringArray .= self::tab(2);

            return $transformInList ? $stringArray : '[' . $stringArray . ']';
        }

        $stringArray = $transformInList ? '' : '[';

        foreach ($array as $value) {
            $stringArray .= $this->toString($value, true) . ', ';
        }
        $stringArray = rtrim($stringArray, ', ');

        return $transformInList ? $stringArray : $stringArray . ']';
    }

    private function createAssociativeArray(array $array): string
    {
        if ($this->isIndentationRequired($array)) {
            $stringArray = "[\n";
            foreach ($array as $key => $value) {
                $stringArray .= self::tab(4) . $this->toString($key) . ' => ' . $this->toString($value, true);
                $stringArray .= count($array) > 1 ? ",\n" : self::EOL_CHAR;
            }

            return $stringArray . self::tab(3) . ']';
        }

        $stringArray = '[';
        foreach ($array as $key => $value) {
            $stringArray .= $this->toString($key) . ' => ' . $this->toString($value, true);
            $stringArray .= next($array) ? ', ' : '';
        }

        return $stringArray . ']';
    }

    private function createListFromArray(array $array): string
    {
        return $this->createSequentialArray($array, $transformInList = true);
    }

    private function createStringArgument(string $value): string
    {
        [$expression, $value] = $this->extractStringValue($value);

        if ($expression === 'expr') {
            if (strstr($value, '"')) {
                return 'expr(\'' . str_replace('\\\\', '\\', $value) . '\')';
            }

            return 'expr("' . $value . '")';
        }

        if (class_exists($value) || interface_exists($value)) {
            $value = $this->addUseStatementIfNecessary($value);
            if ($expression === 'ref') {
                return 'service(' . $value . ')';
            }
        }

        if ($expression === 'ref') {
            return "service('" . $value . "')";
        }

        return $value;
    }

    /**
     * @param array $inOrderKeys Pass an array of keys to sort if exists
     *                           or an associative array following this logic [$key => $valueIfNotExists]
     *
     * @return array
     */
    private function sortArgumentsByKeyIfExists(array $arrayToSort, array $inOrderKeys)
    {
        $argumentsInOrder = [];

        if ($this->isAssociativeArray($inOrderKeys)) {
            foreach ($inOrderKeys as $key => $valueIfNotExists) {
                $argumentsInOrder[$key] = $arrayToSort[$key] ?? $valueIfNotExists;
            }

            return $argumentsInOrder;
        }

        foreach ($inOrderKeys as $key) {
            if (isset($arrayToSort[$key])) {
                $argumentsInOrder[] = $arrayToSort[$key];
            }
        }

        return $argumentsInOrder;
    }

    private function extractStringValue(string $value): array
    {
        if (substr($value, 0, 2) === '@=') {
            return ['expr', substr($value, 2)];
        }

        if ($value[0] === '@') {
            return ['ref', trim($value, '@')];
        }

        if (class_exists($value)) {
            return [null, $value];
        }

        if ($value[-1] === '\\') {
            $value = str_replace('\\', '\\\\', $value);
        }

        return [null, "'" . $value . "'"];
    }

    private function addUseStatementIfNecessary(string $className): string
    {
        if (! in_array($className, $this->useStatements, true)) {
            $this->useStatements[] = $className;
        }

        $shortClassName = Strings::after($className, '\\', -1);
        return $shortClassName . '::class';
    }

    private function addNode(Node $node): void
    {
        $this->stmts[] = $node;
    }

    private function addLineStmt(string $line, ?bool $addBlankLine = null): void
    {
        $addBlankLine = $addBlankLine ? self::EOL_CHAR : null;
        $this->addNode(new Name($line . $addBlankLine));
    }

    private function isAlias($serviceKey, $serviceValues): bool
    {
        return isset($serviceValues['alias'])
            || strstr($serviceKey, ' $', true)
            || is_string($serviceValues) && $serviceValues[0] === '@';
    }

    private function isAssociativeArray(array $array): bool
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }

    private function isIndentationRequired(array $array): bool
    {
        $nbChars = 0;
        if ($this->isAssociativeArray($array)) {
            foreach ($array as $key => $value) {
                $nbChars += strlen($this->toString($key)) + strlen($this->toString($value));
            }
        } else {
            foreach ($array as $value) {
                $nbChars += strlen($this->toString($value));
            }
        }

        return $nbChars > 70;
    }

    private function tab(int $count = 1): string
    {
        return str_repeat(' ', $count * 4);
    }

    private function addNodeAsExpression(Node $node): void
    {
        $this->addNode(new Expression($node));
    }
}
