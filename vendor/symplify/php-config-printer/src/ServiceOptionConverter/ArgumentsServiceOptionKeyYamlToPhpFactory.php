<?php

declare (strict_types=1);
namespace ConfigTransformer202110235\Symplify\PhpConfigPrinter\ServiceOptionConverter;

use ConfigTransformer202110235\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202110235\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer202110235\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use ConfigTransformer202110235\Symplify\PhpConfigPrinter\ServiceOptionAnalyzer\ServiceOptionAnalyzer;
use ConfigTransformer202110235\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey;
final class ArgumentsServiceOptionKeyYamlToPhpFactory implements \ConfigTransformer202110235\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    /**
     * @var \Symplify\PhpConfigPrinter\ServiceOptionAnalyzer\ServiceOptionAnalyzer
     */
    private $serviceOptionAnalyzer;
    public function __construct(\ConfigTransformer202110235\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory, \ConfigTransformer202110235\Symplify\PhpConfigPrinter\ServiceOptionAnalyzer\ServiceOptionAnalyzer $serviceOptionAnalyzer)
    {
        $this->argsNodeFactory = $argsNodeFactory;
        $this->serviceOptionAnalyzer = $serviceOptionAnalyzer;
    }
    /**
     * @param \PhpParser\Node\Expr\MethodCall $methodCall
     */
    public function decorateServiceMethodCall($key, $yaml, $values, $methodCall) : \ConfigTransformer202110235\PhpParser\Node\Expr\MethodCall
    {
        if (!$this->serviceOptionAnalyzer->hasNamedArguments($yaml)) {
            $args = $this->argsNodeFactory->createFromValuesAndWrapInArray($yaml);
            return new \ConfigTransformer202110235\PhpParser\Node\Expr\MethodCall($methodCall, 'args', $args);
        }
        foreach ($yaml as $key => $value) {
            $args = $this->argsNodeFactory->createFromValues([$key, $value], \false, \true);
            $methodCall = new \ConfigTransformer202110235\PhpParser\Node\Expr\MethodCall($methodCall, 'arg', $args);
        }
        return $methodCall;
    }
    public function isMatch($key, $values) : bool
    {
        return $key === \ConfigTransformer202110235\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey::ARGUMENTS;
    }
}
