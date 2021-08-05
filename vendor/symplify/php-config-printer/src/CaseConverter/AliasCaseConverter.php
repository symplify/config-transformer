<?php

declare (strict_types=1);
namespace ConfigTransformer202108055\Symplify\PhpConfigPrinter\CaseConverter;

use ConfigTransformer202108055\Nette\Utils\Strings;
use ConfigTransformer202108055\PhpParser\Node\Arg;
use ConfigTransformer202108055\PhpParser\Node\Expr\BinaryOp\Concat;
use ConfigTransformer202108055\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202108055\PhpParser\Node\Expr\Variable;
use ConfigTransformer202108055\PhpParser\Node\Scalar\String_;
use ConfigTransformer202108055\PhpParser\Node\Stmt\Expression;
use ConfigTransformer202108055\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use ConfigTransformer202108055\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use ConfigTransformer202108055\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use ConfigTransformer202108055\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use ConfigTransformer202108055\Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory;
use ConfigTransformer202108055\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use ConfigTransformer202108055\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use ConfigTransformer202108055\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
use ConfigTransformer202108055\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
final class AliasCaseConverter implements \ConfigTransformer202108055\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @see https://regex101.com/r/BwXkfO/2/
     * @var string
     */
    private const ARGUMENT_NAME_REGEX = '#\\$(?<argument_name>\\w+)#';
    /**
     * @see https://regex101.com/r/DDuuVM/1
     * @var string
     */
    private const NAMED_ALIAS_REGEX = '#\\w+\\s+\\$\\w+#';
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory
     */
    private $commonNodeFactory;
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory
     */
    private $serviceOptionNodeFactory;
    /**
     * @var \Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker
     */
    private $classLikeExistenceChecker;
    public function __construct(\ConfigTransformer202108055\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory, \ConfigTransformer202108055\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory, \ConfigTransformer202108055\Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory $serviceOptionNodeFactory, \ConfigTransformer202108055\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker $classLikeExistenceChecker)
    {
        $this->commonNodeFactory = $commonNodeFactory;
        $this->argsNodeFactory = $argsNodeFactory;
        $this->serviceOptionNodeFactory = $serviceOptionNodeFactory;
        $this->classLikeExistenceChecker = $classLikeExistenceChecker;
    }
    public function convertToMethodCall($key, $values) : \ConfigTransformer202108055\PhpParser\Node\Stmt\Expression
    {
        if (!\is_string($key)) {
            throw new \ConfigTransformer202108055\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
        }
        $servicesVariable = new \ConfigTransformer202108055\PhpParser\Node\Expr\Variable(\ConfigTransformer202108055\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES);
        if ($this->classLikeExistenceChecker->doesClassLikeExist($key)) {
            return $this->createFromClassLike($key, $values, $servicesVariable);
        }
        // handles: "SomeClass $someVariable: ..."
        $fullClassName = \ConfigTransformer202108055\Nette\Utils\Strings::before($key, ' $');
        if ($fullClassName !== null) {
            $methodCall = $this->createAliasNode($key, $fullClassName, $values);
            return new \ConfigTransformer202108055\PhpParser\Node\Stmt\Expression($methodCall);
        }
        if (\is_string($values) && $values[0] === '@') {
            $args = $this->argsNodeFactory->createFromValues([$key, $values], \true);
            $methodCall = new \ConfigTransformer202108055\PhpParser\Node\Expr\MethodCall($servicesVariable, \ConfigTransformer202108055\Symplify\PhpConfigPrinter\ValueObject\MethodName::ALIAS, $args);
            return new \ConfigTransformer202108055\PhpParser\Node\Stmt\Expression($methodCall);
        }
        if (\is_array($values)) {
            return $this->createFromArrayValues($values, $key, $servicesVariable);
        }
        throw new \ConfigTransformer202108055\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
    }
    /**
     * @param string $rootKey
     */
    public function match($rootKey, $key, $values) : bool
    {
        if ($rootKey !== \ConfigTransformer202108055\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            return \false;
        }
        if (isset($values[\ConfigTransformer202108055\Symplify\PhpConfigPrinter\ValueObject\YamlKey::ALIAS])) {
            return \true;
        }
        if (\ConfigTransformer202108055\Nette\Utils\Strings::match($key, self::NAMED_ALIAS_REGEX)) {
            return \true;
        }
        if (!\is_string($values)) {
            return \false;
        }
        return $values[0] === '@';
    }
    private function createAliasNode(string $key, string $fullClassName, $serviceValues) : \ConfigTransformer202108055\PhpParser\Node\Expr\MethodCall
    {
        $args = [];
        $classConstFetch = $this->commonNodeFactory->createClassReference($fullClassName);
        \ConfigTransformer202108055\Nette\Utils\Strings::match($key, self::ARGUMENT_NAME_REGEX);
        $argumentName = '$' . \ConfigTransformer202108055\Nette\Utils\Strings::after($key, '$');
        $concat = new \ConfigTransformer202108055\PhpParser\Node\Expr\BinaryOp\Concat($classConstFetch, new \ConfigTransformer202108055\PhpParser\Node\Scalar\String_(' ' . $argumentName));
        $args[] = new \ConfigTransformer202108055\PhpParser\Node\Arg($concat);
        $serviceName = \ltrim($serviceValues, '@');
        $args[] = new \ConfigTransformer202108055\PhpParser\Node\Arg(new \ConfigTransformer202108055\PhpParser\Node\Scalar\String_($serviceName));
        return new \ConfigTransformer202108055\PhpParser\Node\Expr\MethodCall(new \ConfigTransformer202108055\PhpParser\Node\Expr\Variable(\ConfigTransformer202108055\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES), \ConfigTransformer202108055\Symplify\PhpConfigPrinter\ValueObject\MethodName::ALIAS, $args);
    }
    /**
     * @param mixed $values
     */
    private function createFromClassLike(string $key, $values, \ConfigTransformer202108055\PhpParser\Node\Expr\Variable $servicesVariable) : \ConfigTransformer202108055\PhpParser\Node\Stmt\Expression
    {
        $classReference = $this->commonNodeFactory->createClassReference($key);
        $argValues = [];
        $argValues[] = $classReference;
        $argValues[] = $values[\ConfigTransformer202108055\Symplify\PhpConfigPrinter\ValueObject\MethodName::ALIAS] ?? $values;
        $args = $this->argsNodeFactory->createFromValues($argValues, \true);
        $methodCall = new \ConfigTransformer202108055\PhpParser\Node\Expr\MethodCall($servicesVariable, \ConfigTransformer202108055\Symplify\PhpConfigPrinter\ValueObject\MethodName::ALIAS, $args);
        return new \ConfigTransformer202108055\PhpParser\Node\Stmt\Expression($methodCall);
    }
    private function createFromAlias(string $serviceName, string $key, \ConfigTransformer202108055\PhpParser\Node\Expr\Variable $servicesVariable) : \ConfigTransformer202108055\PhpParser\Node\Expr\MethodCall
    {
        if ($this->classLikeExistenceChecker->doesClassLikeExist($serviceName)) {
            $classReference = $this->commonNodeFactory->createClassReference($serviceName);
            $args = $this->argsNodeFactory->createFromValues([$key, $classReference]);
        } else {
            $args = $this->argsNodeFactory->createFromValues([$key, $serviceName]);
        }
        return new \ConfigTransformer202108055\PhpParser\Node\Expr\MethodCall($servicesVariable, \ConfigTransformer202108055\Symplify\PhpConfigPrinter\ValueObject\MethodName::ALIAS, $args);
    }
    /**
     * @param mixed[] $values
     */
    private function createFromArrayValues(array $values, string $key, \ConfigTransformer202108055\PhpParser\Node\Expr\Variable $servicesVariable) : \ConfigTransformer202108055\PhpParser\Node\Stmt\Expression
    {
        if (isset($values[\ConfigTransformer202108055\Symplify\PhpConfigPrinter\ValueObject\MethodName::ALIAS])) {
            $methodCall = $this->createFromAlias($values[\ConfigTransformer202108055\Symplify\PhpConfigPrinter\ValueObject\MethodName::ALIAS], $key, $servicesVariable);
            unset($values[\ConfigTransformer202108055\Symplify\PhpConfigPrinter\ValueObject\MethodName::ALIAS]);
        } else {
            throw new \ConfigTransformer202108055\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
        }
        /** @var MethodCall $methodCall */
        $methodCall = $this->serviceOptionNodeFactory->convertServiceOptionsToNodes($values, $methodCall);
        return new \ConfigTransformer202108055\PhpParser\Node\Stmt\Expression($methodCall);
    }
}
