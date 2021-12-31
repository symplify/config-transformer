<?php

declare (strict_types=1);
namespace ConfigTransformer2021123110\Symplify\PhpConfigPrinter\ServiceOptionConverter;

use ConfigTransformer2021123110\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer2021123110\Symfony\Component\DependencyInjection\ContainerInterface;
use ConfigTransformer2021123110\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer2021123110\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use ConfigTransformer2021123110\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use ConfigTransformer2021123110\Symplify\PhpConfigPrinter\Sorter\YamlArgumentSorter;
use ConfigTransformer2021123110\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey;
final class DecoratesServiceOptionKeyYamlToPhpFactory implements \ConfigTransformer2021123110\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @var string
     */
    private const DECORATION_ON_INVALID = 'decoration_on_invalid';
    /**
     * @var string
     */
    private const DECORATION_INNER_NAME = 'decoration_inner_name';
    /**
     * @var string
     */
    private const DECORATION_PRIORITY = 'decoration_priority';
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    /**
     * @var \Symplify\PhpConfigPrinter\Sorter\YamlArgumentSorter
     */
    private $yamlArgumentSorter;
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory
     */
    private $commonNodeFactory;
    public function __construct(\ConfigTransformer2021123110\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory, \ConfigTransformer2021123110\Symplify\PhpConfigPrinter\Sorter\YamlArgumentSorter $yamlArgumentSorter, \ConfigTransformer2021123110\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
        $this->yamlArgumentSorter = $yamlArgumentSorter;
        $this->commonNodeFactory = $commonNodeFactory;
    }
    public function decorateServiceMethodCall($key, $yaml, $values, \ConfigTransformer2021123110\PhpParser\Node\Expr\MethodCall $methodCall) : \ConfigTransformer2021123110\PhpParser\Node\Expr\MethodCall
    {
        $arguments = $this->yamlArgumentSorter->sortArgumentsByKeyIfExists($values, [self::DECORATION_INNER_NAME => null, self::DECORATION_PRIORITY => 0, self::DECORATION_ON_INVALID => null]);
        if (isset($arguments[self::DECORATION_ON_INVALID])) {
            $arguments[self::DECORATION_ON_INVALID] = $arguments[self::DECORATION_ON_INVALID] === 'exception' ? $this->commonNodeFactory->createConstFetch(\ConfigTransformer2021123110\Symfony\Component\DependencyInjection\ContainerInterface::class, 'EXCEPTION_ON_INVALID_REFERENCE') : $this->commonNodeFactory->createConstFetch(\ConfigTransformer2021123110\Symfony\Component\DependencyInjection\ContainerInterface::class, 'IGNORE_ON_INVALID_REFERENCE');
        }
        // Don't write the next arguments if they are null.
        if ($arguments[self::DECORATION_ON_INVALID] === null && $arguments[self::DECORATION_PRIORITY] === 0) {
            unset($arguments[self::DECORATION_ON_INVALID], $arguments[self::DECORATION_PRIORITY]);
            if ($arguments[self::DECORATION_INNER_NAME] === null) {
                unset($arguments[self::DECORATION_INNER_NAME]);
            }
        }
        \array_unshift($arguments, $values['decorates']);
        $args = $this->argsNodeFactory->createFromValues($arguments);
        return new \ConfigTransformer2021123110\PhpParser\Node\Expr\MethodCall($methodCall, 'decorate', $args);
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function isMatch($key, $values) : bool
    {
        return $key === \ConfigTransformer2021123110\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey::DECORATES;
    }
}
