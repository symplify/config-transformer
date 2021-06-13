<?php

declare (strict_types=1);
namespace ConfigTransformer202106139\Symplify\PhpConfigPrinter\ServiceOptionConverter;

use ConfigTransformer202106139\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202106139\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer202106139\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use ConfigTransformer202106139\Symplify\PhpConfigPrinter\ServiceOptionAnalyzer\ServiceOptionAnalyzer;
use ConfigTransformer202106139\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey;
final class ArgumentsServiceOptionKeyYamlToPhpFactory implements \ConfigTransformer202106139\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    /**
     * @var \Symplify\PhpConfigPrinter\ServiceOptionAnalyzer\ServiceOptionAnalyzer
     */
    private $serviceOptionAnalyzer;
    public function __construct(\ConfigTransformer202106139\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory, \ConfigTransformer202106139\Symplify\PhpConfigPrinter\ServiceOptionAnalyzer\ServiceOptionAnalyzer $serviceOptionAnalyzer)
    {
        $this->argsNodeFactory = $argsNodeFactory;
        $this->serviceOptionAnalyzer = $serviceOptionAnalyzer;
    }
    public function decorateServiceMethodCall($key, $yaml, $values, \ConfigTransformer202106139\PhpParser\Node\Expr\MethodCall $methodCall) : \ConfigTransformer202106139\PhpParser\Node\Expr\MethodCall
    {
        if (!$this->serviceOptionAnalyzer->hasNamedArguments($yaml)) {
            $args = $this->argsNodeFactory->createFromValuesAndWrapInArray($yaml);
            return new \ConfigTransformer202106139\PhpParser\Node\Expr\MethodCall($methodCall, 'args', $args);
        }
        foreach ($yaml as $key => $value) {
            $args = $this->argsNodeFactory->createFromValues([$key, $value], \false, \true);
            $methodCall = new \ConfigTransformer202106139\PhpParser\Node\Expr\MethodCall($methodCall, 'arg', $args);
        }
        return $methodCall;
    }
    public function isMatch($key, $values) : bool
    {
        return $key === \ConfigTransformer202106139\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey::ARGUMENTS;
    }
}
