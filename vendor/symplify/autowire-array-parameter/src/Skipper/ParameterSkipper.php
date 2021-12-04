<?php

declare (strict_types=1);
namespace ConfigTransformer2021120410\Symplify\AutowireArrayParameter\Skipper;

use ReflectionMethod;
use ReflectionNamedType;
use ReflectionParameter;
use ConfigTransformer2021120410\Symfony\Component\DependencyInjection\Definition;
use ConfigTransformer2021120410\Symplify\AutowireArrayParameter\TypeResolver\ParameterTypeResolver;
final class ParameterSkipper
{
    /**
     * Classes that create circular dependencies
     *
     * @var string[]
     */
    private const DEFAULT_EXCLUDED_FATAL_CLASSES = ['ConfigTransformer2021120410\\Symfony\\Component\\Form\\FormExtensionInterface', 'ConfigTransformer2021120410\\Symfony\\Component\\Asset\\PackageInterface', 'ConfigTransformer2021120410\\Symfony\\Component\\Config\\Loader\\LoaderInterface', 'ConfigTransformer2021120410\\Symfony\\Component\\VarDumper\\Dumper\\ContextProvider\\ContextProviderInterface', 'ConfigTransformer2021120410\\EasyCorp\\Bundle\\EasyAdminBundle\\Form\\Type\\Configurator\\TypeConfiguratorInterface', 'ConfigTransformer2021120410\\Sonata\\CoreBundle\\Model\\Adapter\\AdapterInterface', 'ConfigTransformer2021120410\\Sonata\\Doctrine\\Adapter\\AdapterChain', 'ConfigTransformer2021120410\\Sonata\\Twig\\Extension\\TemplateExtension'];
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
    public function __construct(\ConfigTransformer2021120410\Symplify\AutowireArrayParameter\TypeResolver\ParameterTypeResolver $parameterTypeResolver, array $excludedFatalClasses)
    {
        $this->parameterTypeResolver = $parameterTypeResolver;
        $this->excludedFatalClasses = \array_merge(self::DEFAULT_EXCLUDED_FATAL_CLASSES, $excludedFatalClasses);
    }
    public function shouldSkipParameter(\ReflectionMethod $reflectionMethod, \ConfigTransformer2021120410\Symfony\Component\DependencyInjection\Definition $definition, \ReflectionParameter $reflectionParameter) : bool
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
        if (!$reflectionParameterType instanceof \ReflectionNamedType) {
            return \false;
        }
        return $reflectionParameterType->getName() === 'array';
    }
}
