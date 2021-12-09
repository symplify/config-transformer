<?php

declare (strict_types=1);
namespace ConfigTransformer202112090\Symplify\PhpConfigPrinter\Printer\ArrayDecorator;

use ConfigTransformer202112090\PhpParser\Node\Arg;
use ConfigTransformer202112090\PhpParser\Node\Expr\Array_;
use ConfigTransformer202112090\PhpParser\Node\Expr\ArrayItem;
use ConfigTransformer202112090\PhpParser\Node\Expr\New_;
use ConfigTransformer202112090\PhpParser\Node\Expr\StaticCall;
use ConfigTransformer202112090\PhpParser\Node\Name\FullyQualified;
use ConfigTransformer202112090\Symplify\PhpConfigPrinter\NodeFactory\NewValueObjectFactory;
use ConfigTransformer202112090\Symplify\PhpConfigPrinter\Reflection\ConstantNameFromValueResolver;
use ConfigTransformer202112090\Symplify\SymfonyPhpConfig\ValueObjectInliner;
final class ServiceConfigurationDecorator
{
    /**
     * @var \Symplify\PhpConfigPrinter\Reflection\ConstantNameFromValueResolver
     */
    private $constantNameFromValueResolver;
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\NewValueObjectFactory
     */
    private $newValueObjectFactory;
    public function __construct(\ConfigTransformer202112090\Symplify\PhpConfigPrinter\Reflection\ConstantNameFromValueResolver $constantNameFromValueResolver, \ConfigTransformer202112090\Symplify\PhpConfigPrinter\NodeFactory\NewValueObjectFactory $newValueObjectFactory)
    {
        $this->constantNameFromValueResolver = $constantNameFromValueResolver;
        $this->newValueObjectFactory = $newValueObjectFactory;
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
        $configuration = $this->decorateClassConstantKeys($configuration, $class);
        foreach ($configuration as $key => $value) {
            if ($this->isArrayOfObjects($value)) {
                $configuration = $this->configureArrayOfObjects($configuration, $value, $key, $shouldUseConfigureMethod);
            } elseif (\is_object($value)) {
                $configuration[$key] = $this->decorateValueObject($value, $shouldUseConfigureMethod);
            }
        }
        return $configuration;
    }
    /**
     * @param mixed[] $value
     * @return mixed[]
     * @param int|string $key
     */
    private function configureArrayOfObjects(array $configuration, array $value, $key, bool $shouldUseConfigureMethod) : array
    {
        foreach ($value as $keyValue => $singleValue) {
            if (\is_string($keyValue)) {
                $configuration[$key] = \array_merge($configuration[$key], [$keyValue => $this->decorateValueObject($singleValue, $shouldUseConfigureMethod)]);
            }
            if (\is_numeric($keyValue)) {
                $configuration[$key] = $this->decorateValueObjects([$singleValue], $shouldUseConfigureMethod);
            }
        }
        return $configuration;
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
    /**
     * @return \PhpParser\Node\Expr\New_|\PhpParser\Node\Expr\StaticCall
     * @param object $value
     */
    private function decorateValueObject($value, bool $shouldUseConfigureMethod)
    {
        $new = $this->newValueObjectFactory->create($value);
        if ($shouldUseConfigureMethod) {
            return $new;
        }
        $args = [new \ConfigTransformer202112090\PhpParser\Node\Arg($new)];
        return $this->createInlineStaticCall($args);
    }
    /**
     * @param mixed[] $values
     * @return \PhpParser\Node\Expr\Array_|\PhpParser\Node\Expr\StaticCall
     */
    private function decorateValueObjects(array $values, bool $shouldUseConfigureMethod)
    {
        $arrayItems = [];
        foreach ($values as $value) {
            $new = $this->newValueObjectFactory->create($value);
            $arrayItems[] = new \ConfigTransformer202112090\PhpParser\Node\Expr\ArrayItem($new);
        }
        $array = new \ConfigTransformer202112090\PhpParser\Node\Expr\Array_($arrayItems);
        if ($shouldUseConfigureMethod) {
            return $array;
        }
        $args = [new \ConfigTransformer202112090\PhpParser\Node\Arg($array)];
        return $this->createInlineStaticCall($args);
    }
    /**
     * @param mixed $values
     */
    private function isArrayOfObjects($values) : bool
    {
        if (!\is_array($values)) {
            return \false;
        }
        if ($values === []) {
            return \false;
        }
        foreach ($values as $value) {
            if (!\is_object($value)) {
                return \false;
            }
        }
        return \true;
    }
    /**
     * Depends on symplify/symfony-php-config
     *
     * @param Arg[] $args
     */
    private function createInlineStaticCall(array $args) : \ConfigTransformer202112090\PhpParser\Node\Expr\StaticCall
    {
        $fullyQualified = new \ConfigTransformer202112090\PhpParser\Node\Name\FullyQualified(\ConfigTransformer202112090\Symplify\SymfonyPhpConfig\ValueObjectInliner::class);
        return new \ConfigTransformer202112090\PhpParser\Node\Expr\StaticCall($fullyQualified, 'inline', $args);
    }
}
