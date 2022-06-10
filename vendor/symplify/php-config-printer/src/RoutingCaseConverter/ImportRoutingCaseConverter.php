<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\RoutingCaseConverter;

use ConfigTransformer20220610\PhpParser\Node\Arg;
use ConfigTransformer20220610\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer20220610\PhpParser\Node\Expr\Variable;
use ConfigTransformer20220610\PhpParser\Node\Stmt\Expression;
use ConfigTransformer20220610\Symplify\PackageBuilder\Strings\StringFormatConverter;
use Symplify\PhpConfigPrinter\Contract\RoutingCaseConverterInterface;
use Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use Symplify\PhpConfigPrinter\ValueObject\VariableName;
final class ImportRoutingCaseConverter implements RoutingCaseConverterInterface
{
    /**
     * @var string[]
     */
    private const NESTED_KEYS = ['name_prefix', 'defaults', 'requirements', 'options', 'utf8', 'condition', 'host', 'schemes', self::METHODS, 'controller', 'locale', 'format', 'stateless'];
    /**
     * @var string[]
     */
    private const IMPORT_ARGS = [self::RESOURCE, self::TYPE, self::EXCLUDE];
    /**
     * @var string[]
     */
    private const PREFIX_ARGS = [
        // Add prefix itself as first argument
        self::PREFIX,
        'trailing_slash_on_root',
    ];
    /**
     * @var string
     */
    private const PREFIX = 'prefix';
    /**
     * @var string
     */
    private const RESOURCE = 'resource';
    /**
     * @var string
     */
    private const TYPE = 'type';
    /**
     * @var string
     */
    private const EXCLUDE = 'exclude';
    /**
     * @var string
     */
    private const METHODS = 'methods';
    /**
     * @var \Symplify\PackageBuilder\Strings\StringFormatConverter
     */
    private $stringFormatConverter;
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    public function __construct(ArgsNodeFactory $argsNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
        $this->stringFormatConverter = new StringFormatConverter();
    }
    /**
     * @param mixed $values
     */
    public function match(string $key, $values) : bool
    {
        return isset($values[self::RESOURCE]);
    }
    /**
     * @param mixed $values
     */
    public function convertToMethodCall(string $key, $values) : Expression
    {
        $variable = new Variable(VariableName::ROUTING_CONFIGURATOR);
        $args = $this->createAddArgs(self::IMPORT_ARGS, $values);
        $methodCall = new MethodCall($variable, 'import', $args);
        // Handle prefix independently as it has specific args
        if (isset($values[self::PREFIX])) {
            $args = $this->createAddArgs(self::PREFIX_ARGS, $values);
            $methodCall = new MethodCall($methodCall, self::PREFIX, $args);
        }
        foreach (self::NESTED_KEYS as $nestedKey) {
            if (!isset($values[$nestedKey])) {
                continue;
            }
            $nestedValues = $values[$nestedKey];
            // Transform methods as string GET|HEAD to array
            if ($nestedKey === self::METHODS && \is_string($nestedValues)) {
                $nestedValues = \explode('|', $nestedValues);
            }
            $args = $this->argsNodeFactory->createFromValues([$nestedValues]);
            $name = $this->stringFormatConverter->underscoreAndHyphenToCamelCase($nestedKey);
            $methodCall = new MethodCall($methodCall, $name, $args);
        }
        return new Expression($methodCall);
    }
    /**
     * @param string[] $argsNames
     * @return Arg[]
     * @param mixed $values
     */
    private function createAddArgs(array $argsNames, $values) : array
    {
        $argumentValues = [];
        foreach ($argsNames as $argName) {
            if (isset($values[$argName])) {
                // Default $ignoreErrors to false before $exclude on import(), same behaviour as symfony
                if ($argName === self::EXCLUDE) {
                    $argumentValues[] = \false;
                }
                $argumentValues[] = $values[$argName];
            }
        }
        return $this->argsNodeFactory->createFromValues($argumentValues);
    }
}
