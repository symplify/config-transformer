<?php

declare (strict_types=1);
namespace ConfigTransformer202109230\Symplify\AutowireArrayParameter\Skipper;

use ReflectionMethod;
use ReflectionParameter;
use ConfigTransformer202109230\Symfony\Component\DependencyInjection\Definition;
use ConfigTransformer202109230\Symplify\AutowireArrayParameter\TypeResolver\ParameterTypeResolver;
final class ParameterSkipper
{
    /**
     * Classes that create circular dependencies
     *
     * @var string[]
     */
    private const DEFAULT_EXCLUDED_FATAL_CLASSES = ['ConfigTransformer202109230\\Symfony\\Component\\Form\\FormExtensionInterface', 'ConfigTransformer202109230\\Symfony\\Component\\Asset\\PackageInterface', 'ConfigTransformer202109230\\Symfony\\Component\\Config\\Loader\\LoaderInterface', 'ConfigTransformer202109230\\Symfony\\Component\\VarDumper\\Dumper\\ContextProvider\\ContextProviderInterface', 'ConfigTransformer202109230\\EasyCorp\\Bundle\\EasyAdminBundle\\Form\\Type\\Configurator\\TypeConfiguratorInterface', 'ConfigTransformer202109230\\Sonata\\CoreBundle\\Model\\Adapter\\AdapterInterface', 'ConfigTransformer202109230\\Sonata\\Doctrine\\Adapter\\AdapterChain', 'ConfigTransformer202109230\\Sonata\\Twig\\Extension\\TemplateExtension'];
    /**
     * @var string[]
     */
    private $excludedFatalClasses = [];
    /**
     * @var \Symplify\AutowireArrayParameter\TypeResolver\ParameterTypeResolver
     */
    private $parameterTypeResolver;
    /**
     * @param string[] $excludedFatalClasses
     */
    public function __construct(\ConfigTransformer202109230\Symplify\AutowireArrayParameter\TypeResolver\ParameterTypeResolver $parameterTypeResolver, array $excludedFatalClasses)
    {
        $this->parameterTypeResolver = $parameterTypeResolver;
        $this->excludedFatalClasses = \array_merge(self::DEFAULT_EXCLUDED_FATAL_CLASSES, $excludedFatalClasses);
    }
    public function shouldSkipParameter(\ReflectionMethod $reflectionMethod, \ConfigTransformer202109230\Symfony\Component\DependencyInjection\Definition $definition, \ReflectionParameter $reflectionParameter) : bool
    {
        if (!$this->isArrayType($reflectionParameter)) {
            return \true;
        }
        // already set
        $argumentName = '$' . $reflectionParameter->getName();
        if (isset($definition->getArguments()[$argumentName])) {
            return \true;
        }
        $parameterType = $this->parameterTypeResolver->resolveParameterType($reflectionParameter->getName(), $reflectionMethod);
        if ($parameterType === null) {
            return \true;
        }
        if (\in_array($parameterType, $this->excludedFatalClasses, \true)) {
            return \true;
        }
        if (!\class_exists($parameterType) && !\interface_exists($parameterType)) {
            return \true;
        }
        // prevent circular dependency
        if ($definition->getClass() === null) {
            return \false;
        }
        return \is_a($definition->getClass(), $parameterType, \true);
    }
    private function isArrayType(\ReflectionParameter $reflectionParameter) : bool
    {
        if ($reflectionParameter->getType() === null) {
            return \false;
        }
        $reflectionParameterType = $reflectionParameter->getType();
        return $reflectionParameterType->getName() === 'array';
    }
}
