<?php

declare (strict_types=1);
namespace ConfigTransformer2021120210\Symplify\PhpConfigPrinter\Printer\ArrayDecorator;

use ConfigTransformer2021120210\PhpParser\Node\Arg;
use ConfigTransformer2021120210\PhpParser\Node\Expr\Array_;
use ConfigTransformer2021120210\PhpParser\Node\Expr\ArrayItem;
use ConfigTransformer2021120210\PhpParser\Node\Expr\StaticCall;
use ConfigTransformer2021120210\PhpParser\Node\Name\FullyQualified;
use ConfigTransformer2021120210\Symplify\PhpConfigPrinter\NodeFactory\NewValueObjectFactory;
use ConfigTransformer2021120210\Symplify\PhpConfigPrinter\Reflection\ConstantNameFromValueResolver;
use ConfigTransformer2021120210\Symplify\SymfonyPhpConfig\ValueObjectInliner;
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
    public function __construct(\ConfigTransformer2021120210\Symplify\PhpConfigPrinter\Reflection\ConstantNameFromValueResolver $constantNameFromValueResolver, \ConfigTransformer2021120210\Symplify\PhpConfigPrinter\NodeFactory\NewValueObjectFactory $newValueObjectFactory)
    {
        $this->constantNameFromValueResolver = $constantNameFromValueResolver;
        $this->newValueObjectFactory = $newValueObjectFactory;
    }
    /**
     * @param mixed|mixed[] $configuration
     * @return mixed|mixed[]
     */
    public function decorate($configuration, string $class)
    {
        if (!\is_array($configuration)) {
            return $configuration;
        }
        $configuration = $this->decorateClassConstantKeys($configuration, $class);
        foreach ($configuration as $key => $value) {
            if ($this->isArrayOfObjects($value)) {
                $configuration = $this->configureArrayOfObjects($configuration, $value, $key);
            } elseif (\is_object($value)) {
                $configuration[$key] = $this->decorateValueObject($value);
            }
        }
        return $configuration;
    }
    /**
     * @param mixed[] $value
     * @return mixed[]
     * @param int|string $key
     */
    private function configureArrayOfObjects(array $configuration, array $value, $key) : array
    {
        foreach ($value as $keyValue => $singleValue) {
            if (\is_string($keyValue)) {
                $configuration[$key] = \array_merge($configuration[$key], [$keyValue => $this->decorateValueObject($singleValue)]);
            }
            if (\is_numeric($keyValue)) {
                $configuration[$key] = $this->decorateValueObjects([$singleValue]);
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
     * @param object $value
     */
    private function decorateValueObject($value) : \ConfigTransformer2021120210\PhpParser\Node\Expr\StaticCall
    {
        $new = $this->newValueObjectFactory->create($value);
        $args = [new \ConfigTransformer2021120210\PhpParser\Node\Arg($new)];
        return $this->createInlineStaticCall($args);
    }
    /**
     * @param mixed[] $values
     */
    private function decorateValueObjects(array $values) : \ConfigTransformer2021120210\PhpParser\Node\Expr\StaticCall
    {
        $arrayItems = [];
        foreach ($values as $value) {
            $new = $this->newValueObjectFactory->create($value);
            $arrayItems[] = new \ConfigTransformer2021120210\PhpParser\Node\Expr\ArrayItem($new);
        }
        $array = new \ConfigTransformer2021120210\PhpParser\Node\Expr\Array_($arrayItems);
        $args = [new \ConfigTransformer2021120210\PhpParser\Node\Arg($array)];
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
    private function createInlineStaticCall(array $args) : \ConfigTransformer2021120210\PhpParser\Node\Expr\StaticCall
    {
        $fullyQualified = new \ConfigTransformer2021120210\PhpParser\Node\Name\FullyQualified(\ConfigTransformer2021120210\Symplify\SymfonyPhpConfig\ValueObjectInliner::class);
        return new \ConfigTransformer2021120210\PhpParser\Node\Expr\StaticCall($fullyQualified, 'inline', $args);
    }
}
