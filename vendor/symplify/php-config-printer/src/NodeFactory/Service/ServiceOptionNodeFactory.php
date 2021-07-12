<?php

declare (strict_types=1);
namespace ConfigTransformer202107127\Symplify\PhpConfigPrinter\NodeFactory\Service;

use ConfigTransformer202107127\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202107127\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer202107127\Symplify\PhpConfigPrinter\ServiceOptionAnalyzer\ServiceOptionAnalyzer;
use ConfigTransformer202107127\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey;
final class ServiceOptionNodeFactory
{
    /**
     * @var \Symplify\PhpConfigPrinter\ServiceOptionAnalyzer\ServiceOptionAnalyzer
     */
    private $serviceOptionAnalyzer;
    /**
     * @var mixed[]
     */
    private $serviceOptionKeyYamlToPhpFactories;
    /**
     * @param ServiceOptionsKeyYamlToPhpFactoryInterface[] $serviceOptionKeyYamlToPhpFactories
     */
    public function __construct(\ConfigTransformer202107127\Symplify\PhpConfigPrinter\ServiceOptionAnalyzer\ServiceOptionAnalyzer $serviceOptionAnalyzer, array $serviceOptionKeyYamlToPhpFactories)
    {
        $this->serviceOptionAnalyzer = $serviceOptionAnalyzer;
        $this->serviceOptionKeyYamlToPhpFactories = $serviceOptionKeyYamlToPhpFactories;
    }
    /**
     * @param mixed[] $servicesValues
     */
    public function convertServiceOptionsToNodes(array $servicesValues, \ConfigTransformer202107127\PhpParser\Node\Expr\MethodCall $methodCall) : \ConfigTransformer202107127\PhpParser\Node\Expr\MethodCall
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
     * @return array<string, mixed>
     */
    private function unNestArguments(array $servicesValues) : array
    {
        if (!$this->serviceOptionAnalyzer->hasNamedArguments($servicesValues)) {
            return $servicesValues;
        }
        return [\ConfigTransformer202107127\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey::ARGUMENTS => $servicesValues];
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
