<?php

declare (strict_types=1);
namespace ConfigTransformer202202213\Symplify\PhpConfigPrinter\Printer\ArrayDecorator;

use ConfigTransformer202202213\Symplify\PhpConfigPrinter\Reflection\ConstantNameFromValueResolver;
final class ServiceConfigurationDecorator
{
    /**
     * @var \Symplify\PhpConfigPrinter\Reflection\ConstantNameFromValueResolver
     */
    private $constantNameFromValueResolver;
    public function __construct(\ConfigTransformer202202213\Symplify\PhpConfigPrinter\Reflection\ConstantNameFromValueResolver $constantNameFromValueResolver)
    {
        $this->constantNameFromValueResolver = $constantNameFromValueResolver;
    }
    /**
     * @param mixed|mixed[] $configuration
     * @return mixed|mixed[]
     */
    public function decorate($configuration, string $class, bool $shouldUseConfigureMethod)
    {
        if (!\is_array($configuration)) {
            return $configuration;
        }
        return $this->decorateClassConstantKeys($configuration, $class);
    }
    /**
     * @param mixed[] $configuration
     * @return mixed[]
     */
    private function decorateClassConstantKeys(array $configuration, string $class) : array
    {
        foreach ($configuration as $key => $value) {
            $constantName = $this->constantNameFromValueResolver->resolveFromValueAndClass($key, $class);
            if ($constantName === null) {
                continue;
            }
            unset($configuration[$key]);
            $classConstantReference = $class . '::' . $constantName;
            $configuration[$classConstantReference] = $value;
        }
        return $configuration;
    }
}
