<?php

declare (strict_types=1);
namespace ConfigTransformer2022052410\Symplify\PhpConfigPrinter\Printer\ArrayDecorator;

use ConfigTransformer2022052410\Symplify\PhpConfigPrinter\Reflection\ConstantNameFromValueResolver;
final class ServiceConfigurationDecorator
{
    /**
     * @var \Symplify\PhpConfigPrinter\Reflection\ConstantNameFromValueResolver
     */
    private $constantNameFromValueResolver;
    public function __construct(\ConfigTransformer2022052410\Symplify\PhpConfigPrinter\Reflection\ConstantNameFromValueResolver $constantNameFromValueResolver)
    {
        $this->constantNameFromValueResolver = $constantNameFromValueResolver;
    }
    /**
     * @param mixed $configuration
     * @return mixed
     */
    public function decorate($configuration, string $class)
    {
        if (!\is_array($configuration)) {
            return $configuration;
        }
        return $this->decorateClassConstantKeys($configuration, $class);
    }
    /**
     * @param array<string, mixed> $configuration
     * @return mixed[]
     */
    public function decorateClassConstantKeys(array $configuration, string $class) : array
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
