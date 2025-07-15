<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\NodeFactory\Service;

use ConfigTransformerPrefix202507\PhpParser\Node\Expr\MethodCall;
use Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use Symplify\PhpConfigPrinter\ServiceOptionAnalyzer\ServiceOptionAnalyzer;
use Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey;
use ConfigTransformerPrefix202507\Webmozart\Assert\Assert;
final class ServiceOptionNodeFactory
{
    /**
     * @readonly
     * @var \Symplify\PhpConfigPrinter\ServiceOptionAnalyzer\ServiceOptionAnalyzer
     */
    private $serviceOptionAnalyzer;
    /**
     * @var ServiceOptionsKeyYamlToPhpFactoryInterface[]
     * @readonly
     */
    private $serviceOptionKeyYamlToPhpFactories;
    /**
     * @param ServiceOptionsKeyYamlToPhpFactoryInterface[] $serviceOptionKeyYamlToPhpFactories
     */
    public function __construct(ServiceOptionAnalyzer $serviceOptionAnalyzer, iterable $serviceOptionKeyYamlToPhpFactories)
    {
        $this->serviceOptionAnalyzer = $serviceOptionAnalyzer;
        $this->serviceOptionKeyYamlToPhpFactories = $serviceOptionKeyYamlToPhpFactories;
        Assert::notEmpty($serviceOptionKeyYamlToPhpFactories);
        Assert::allIsInstanceOf($serviceOptionKeyYamlToPhpFactories, ServiceOptionsKeyYamlToPhpFactoryInterface::class);
    }
    /**
     * @param mixed[] $servicesValues
     */
    public function convertServiceOptionsToNodes(array $servicesValues, MethodCall $methodCall) : MethodCall
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
        return [YamlServiceKey::ARGUMENTS => $servicesValues];
    }
    /**
     * @param string|int $key
     */
    private function shouldSkip($key) : bool
    {
        if (\is_int($key)) {
            return \false;
        }
        // options started by decoration_<option> are used as options of the method decorate().
        if (\strncmp($key, 'decoration_', \strlen('decoration_')) === 0) {
            return \true;
        }
        return $key === 'alias';
    }
}
