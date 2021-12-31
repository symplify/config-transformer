<?php

declare (strict_types=1);
namespace ConfigTransformer202112319\Symplify\PhpConfigPrinter\RoutingCaseConverter;

use ConfigTransformer202112319\locale;
use ConfigTransformer202112319\PhpParser\Node\Arg;
use ConfigTransformer202112319\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202112319\PhpParser\Node\Expr\Variable;
use ConfigTransformer202112319\PhpParser\Node\Stmt\Expression;
use ConfigTransformer202112319\Symplify\PackageBuilder\Strings\StringFormatConverter;
use ConfigTransformer202112319\Symplify\PhpConfigPrinter\Contract\RoutingCaseConverterInterface;
use ConfigTransformer202112319\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use ConfigTransformer202112319\Symplify\PhpConfigPrinter\ValueObject\VariableName;
final class ImportRoutingCaseConverter implements \ConfigTransformer202112319\Symplify\PhpConfigPrinter\Contract\RoutingCaseConverterInterface
{
    /**
     * @var string[]|class-string<locale>[]
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
    public function __construct(\ConfigTransformer202112319\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
        $this->stringFormatConverter = new \ConfigTransformer202112319\Symplify\PackageBuilder\Strings\StringFormatConverter();
    }
    /**
     * @param mixed[] $values
     */
    public function match(string $key, $values) : bool
    {
        return isset($values[self::RESOURCE]);
    }
    /**
     * @param mixed $values
     */
    public function convertToMethodCall(string $key, $values) : \ConfigTransformer202112319\PhpParser\Node\Stmt\Expression
    {
        $variable = new \ConfigTransformer202112319\PhpParser\Node\Expr\Variable(\ConfigTransformer202112319\Symplify\PhpConfigPrinter\ValueObject\VariableName::ROUTING_CONFIGURATOR);
        $args = $this->createAddArgs(self::IMPORT_ARGS, $values);
        $methodCall = new \ConfigTransformer202112319\PhpParser\Node\Expr\MethodCall($variable, 'import', $args);
        // Handle prefix independently as it has specific args
        if (isset($values[self::PREFIX])) {
            $args = $this->createAddArgs(self::PREFIX_ARGS, $values);
            $methodCall = new \ConfigTransformer202112319\PhpParser\Node\Expr\MethodCall($methodCall, self::PREFIX, $args);
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
            $methodCall = new \ConfigTransformer202112319\PhpParser\Node\Expr\MethodCall($methodCall, $name, $args);
        }
        return new \ConfigTransformer202112319\PhpParser\Node\Stmt\Expression($methodCall);
    }
    /**
     * @param string[] $argsNames
     * @param mixed $values
     * @return Arg[]
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
