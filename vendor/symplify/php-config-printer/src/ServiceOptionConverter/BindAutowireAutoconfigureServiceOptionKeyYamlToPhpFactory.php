<?php

declare (strict_types=1);
namespace ConfigTransformer2021120210\Symplify\PhpConfigPrinter\ServiceOptionConverter;

use ConfigTransformer2021120210\PhpParser\Node\Arg;
use ConfigTransformer2021120210\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer2021120210\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer2021120210\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use ConfigTransformer2021120210\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use ConfigTransformer2021120210\Symplify\PhpConfigPrinter\ServiceOptionAnalyzer\ServiceOptionAnalyzer;
use ConfigTransformer2021120210\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
use ConfigTransformer2021120210\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey;
final class BindAutowireAutoconfigureServiceOptionKeyYamlToPhpFactory implements \ConfigTransformer2021120210\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory
     */
    private $commonNodeFactory;
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    /**
     * @var \Symplify\PhpConfigPrinter\ServiceOptionAnalyzer\ServiceOptionAnalyzer
     */
    private $serviceOptionAnalyzer;
    public function __construct(\ConfigTransformer2021120210\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory, \ConfigTransformer2021120210\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory, \ConfigTransformer2021120210\Symplify\PhpConfigPrinter\ServiceOptionAnalyzer\ServiceOptionAnalyzer $serviceOptionAnalyzer)
    {
        $this->commonNodeFactory = $commonNodeFactory;
        $this->argsNodeFactory = $argsNodeFactory;
        $this->serviceOptionAnalyzer = $serviceOptionAnalyzer;
    }
    /**
     * @param \PhpParser\Node\Expr\MethodCall $methodCall
     */
    public function decorateServiceMethodCall($key, $yaml, $values, $methodCall) : \ConfigTransformer2021120210\PhpParser\Node\Expr\MethodCall
    {
        $method = $key;
        if ($key === 'shared') {
            $method = 'share';
        }
        if ($yaml === \false) {
            $methodCall = new \ConfigTransformer2021120210\PhpParser\Node\Expr\MethodCall($methodCall, $method);
            $methodCall->args[] = new \ConfigTransformer2021120210\PhpParser\Node\Arg($this->commonNodeFactory->createFalse());
            return $methodCall;
        }
        if ($yaml === \true) {
            $methodCall = new \ConfigTransformer2021120210\PhpParser\Node\Expr\MethodCall($methodCall, $method);
            $methodCall->args[] = new \ConfigTransformer2021120210\PhpParser\Node\Arg($this->commonNodeFactory->createTrue());
            return $methodCall;
        }
        if (!$this->serviceOptionAnalyzer->hasNamedArguments($yaml)) {
            $args = $this->argsNodeFactory->createFromValuesAndWrapInArray($yaml);
            return new \ConfigTransformer2021120210\PhpParser\Node\Expr\MethodCall($methodCall, 'bind', $args);
        }
        foreach ($yaml as $key => $value) {
            $args = $this->argsNodeFactory->createFromValues([$key, $value], \false, \true);
            $methodCall = new \ConfigTransformer2021120210\PhpParser\Node\Expr\MethodCall($methodCall, 'bind', $args);
        }
        return $methodCall;
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function isMatch($key, $values) : bool
    {
        return \in_array($key, [\ConfigTransformer2021120210\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey::BIND, \ConfigTransformer2021120210\Symplify\PhpConfigPrinter\ValueObject\YamlKey::AUTOWIRE, \ConfigTransformer2021120210\Symplify\PhpConfigPrinter\ValueObject\YamlKey::AUTOCONFIGURE], \true);
    }
}
