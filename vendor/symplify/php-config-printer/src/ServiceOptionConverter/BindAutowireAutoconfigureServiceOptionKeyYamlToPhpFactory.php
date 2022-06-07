<?php

declare (strict_types=1);
namespace ConfigTransformer202206077\Symplify\PhpConfigPrinter\ServiceOptionConverter;

use ConfigTransformer202206077\PhpParser\Node\Arg;
use ConfigTransformer202206077\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202206077\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer202206077\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use ConfigTransformer202206077\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use ConfigTransformer202206077\Symplify\PhpConfigPrinter\ServiceOptionAnalyzer\ServiceOptionAnalyzer;
use ConfigTransformer202206077\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
use ConfigTransformer202206077\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey;
final class BindAutowireAutoconfigureServiceOptionKeyYamlToPhpFactory implements ServiceOptionsKeyYamlToPhpFactoryInterface
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
    public function __construct(CommonNodeFactory $commonNodeFactory, ArgsNodeFactory $argsNodeFactory, ServiceOptionAnalyzer $serviceOptionAnalyzer)
    {
        $this->commonNodeFactory = $commonNodeFactory;
        $this->argsNodeFactory = $argsNodeFactory;
        $this->serviceOptionAnalyzer = $serviceOptionAnalyzer;
    }
    /**
     * @param mixed $key
     * @param mixed $yaml
     * @param mixed $values
     */
    public function decorateServiceMethodCall($key, $yaml, $values, MethodCall $methodCall) : MethodCall
    {
        $method = $key;
        if ($key === 'shared') {
            $method = 'share';
        }
        if ($yaml === \false) {
            $methodCall = new MethodCall($methodCall, $method);
            $methodCall->args[] = new Arg($this->commonNodeFactory->createFalse());
            return $methodCall;
        }
        if ($yaml === \true) {
            $methodCall = new MethodCall($methodCall, $method);
            $methodCall->args[] = new Arg($this->commonNodeFactory->createTrue());
            return $methodCall;
        }
        if (!$this->serviceOptionAnalyzer->hasNamedArguments($yaml)) {
            $args = $this->argsNodeFactory->createFromValuesAndWrapInArray($yaml);
            return new MethodCall($methodCall, 'bind', $args);
        }
        foreach ($yaml as $key => $value) {
            $args = $this->argsNodeFactory->createFromValues([$key, $value], \false, \true);
            $methodCall = new MethodCall($methodCall, 'bind', $args);
        }
        return $methodCall;
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function isMatch($key, $values) : bool
    {
        return \in_array($key, [YamlServiceKey::BIND, YamlKey::AUTOWIRE, YamlKey::AUTOCONFIGURE], \true);
    }
}
