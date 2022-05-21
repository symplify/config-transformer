<?php

declare (strict_types=1);
namespace ConfigTransformer202205211\Symplify\PhpConfigPrinter\NodeFactory\Service;

use ConfigTransformer202205211\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202205211\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer202205211\Symplify\PhpConfigPrinter\ServiceOptionAnalyzer\ServiceOptionAnalyzer;
use ConfigTransformer202205211\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey;
final class ServiceOptionNodeFactory
{
    /**
     * @var \Symplify\PhpConfigPrinter\ServiceOptionAnalyzer\ServiceOptionAnalyzer
     */
    private $serviceOptionAnalyzer;
    /**
     * @var ServiceOptionsKeyYamlToPhpFactoryInterface[]
     */
    private $serviceOptionKeyYamlToPhpFactories;
    /**
     * @param ServiceOptionsKeyYamlToPhpFactoryInterface[] $serviceOptionKeyYamlToPhpFactories
     */
    public function __construct(\ConfigTransformer202205211\Symplify\PhpConfigPrinter\ServiceOptionAnalyzer\ServiceOptionAnalyzer $serviceOptionAnalyzer, array $serviceOptionKeyYamlToPhpFactories)
    {
        $this->serviceOptionAnalyzer = $serviceOptionAnalyzer;
        $this->serviceOptionKeyYamlToPhpFactories = $serviceOptionKeyYamlToPhpFactories;
    }
    /**
     * @param mixed[] $servicesValues
     */
    public function convertServiceOptionsToNodes(array $servicesValues, \ConfigTransformer202205211\PhpParser\Node\Expr\MethodCall $methodCall) : \ConfigTransformer202205211\PhpParser\Node\Expr\MethodCall
    {
        $servicesValues = $this->unNestArguments($servicesValues);
        foreach ($servicesValues as $key => $value) {
            if ($this->shouldSkip($key)) {
                continue;
            }
            foreach ($this->serviceOptionKeyYamlToPhpFactories as $serviceOptionKeyYamlToPhpFactory) {
                if (!$serviceOptionKeyYamlToPhpFactory->isMatch($key, $value)) {
                    continue;
                }
                $methodCall = $serviceOptionKeyYamlToPhpFactory->decorateServiceMethodCall($key, $value, $servicesValues, $methodCall);
                continue 2;
            }
        }
        return $methodCall;
    }
    /**
     * @param array<string, mixed> $servicesValues
     * @return array<string, mixed>|array<string, array<string, mixed>>
     */
    private function unNestArguments(array $servicesValues) : array
    {
        if (!$this->serviceOptionAnalyzer->hasNamedArguments($servicesValues)) {
            return $servicesValues;
        }
        return [\ConfigTransformer202205211\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey::ARGUMENTS => $servicesValues];
    }
    private function shouldSkip(string $key) : bool
    {
        // options started by decoration_<option> are used as options of the method decorate().
        if (\strncmp($key, 'decoration_', \strlen('decoration_')) === 0) {
            return \true;
        }
        return $key === 'alias';
    }
}
