<?php

declare (strict_types=1);
namespace ConfigTransformer202207\Symplify\Astral\NodeAnalyzer;

use ConfigTransformer202207\Latte\Engine;
use ConfigTransformer202207\Nette\Application\UI\Template;
use ConfigTransformer202207\PhpParser\Node\Expr;
use ConfigTransformer202207\PhpParser\Node\Expr\PropertyFetch;
use ConfigTransformer202207\PHPStan\Analyser\Scope;
use ConfigTransformer202207\Symplify\Astral\Naming\SimpleNameResolver;
use ConfigTransformer202207\Symplify\Astral\TypeAnalyzer\ContainsTypeAnalyser;
/**
 * @api
 */
final class NetteTypeAnalyzer
{
    /**
     * @var array<class-string<Engine|Template>>
     */
    private const TEMPLATE_TYPES = ['ConfigTransformer202207\\Latte\\Engine', 'ConfigTransformer202207\\Nette\\Application\\UI\\Template', 'ConfigTransformer202207\\Nette\\Application\\UI\\ITemplate', 'ConfigTransformer202207\\Nette\\Bridges\\ApplicationLatte\\Template', 'ConfigTransformer202207\\Nette\\Bridges\\ApplicationLatte\\DefaultTemplate'];
    /**
     * @var \Symplify\Astral\Naming\SimpleNameResolver
     */
    private $simpleNameResolver;
    /**
     * @var \Symplify\Astral\TypeAnalyzer\ContainsTypeAnalyser
     */
    private $containsTypeAnalyser;
    public function __construct(SimpleNameResolver $simpleNameResolver, ContainsTypeAnalyser $containsTypeAnalyser)
    {
        $this->simpleNameResolver = $simpleNameResolver;
        $this->containsTypeAnalyser = $containsTypeAnalyser;
    }
    /**
     * E.g. $this->template->key
     */
    public function isTemplateMagicPropertyType(Expr $expr, Scope $scope) : bool
    {
        if (!$expr instanceof PropertyFetch) {
            return \false;
        }
        if (!$expr->var instanceof PropertyFetch) {
            return \false;
        }
        return $this->isTemplateType($expr->var, $scope);
    }
    /**
     * E.g. $this->template
     */
    public function isTemplateType(Expr $expr, Scope $scope) : bool
    {
        return $this->containsTypeAnalyser->containsExprTypes($expr, $scope, self::TEMPLATE_TYPES);
    }
    /**
     * This type has getComponent() method
     */
    public function isInsideComponentContainer(Scope $scope) : bool
    {
        $className = $this->simpleNameResolver->getClassNameFromScope($scope);
        if ($className === null) {
            return \false;
        }
        // this type has getComponent() method
        return \is_a($className, 'ConfigTransformer202207\\Nette\\ComponentModel\\Container', \true);
    }
    public function isInsideControl(Scope $scope) : bool
    {
        $className = $this->simpleNameResolver->getClassNameFromScope($scope);
        if ($className === null) {
            return \false;
        }
        return \is_a($className, 'ConfigTransformer202207\\Nette\\Application\\UI\\Control', \true);
    }
}
