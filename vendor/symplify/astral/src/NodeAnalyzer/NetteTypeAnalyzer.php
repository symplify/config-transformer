<?php

declare (strict_types=1);
namespace ConfigTransformer2021101110\Symplify\Astral\NodeAnalyzer;

use ConfigTransformer2021101110\Nette\Application\UI\Template;
use ConfigTransformer2021101110\PhpParser\Node\Expr;
use ConfigTransformer2021101110\PhpParser\Node\Expr\PropertyFetch;
use ConfigTransformer2021101110\PHPStan\Analyser\Scope;
use ConfigTransformer2021101110\Symplify\Astral\Naming\SimpleNameResolver;
use ConfigTransformer2021101110\Symplify\Astral\TypeAnalyzer\ContainsTypeAnalyser;
final class NetteTypeAnalyzer
{
    /**
     * @var array<class-string<Template>>
     */
    private const TEMPLATE_TYPES = ['ConfigTransformer2021101110\\Nette\\Application\\UI\\Template', 'ConfigTransformer2021101110\\Nette\\Application\\UI\\ITemplate', 'ConfigTransformer2021101110\\Nette\\Bridges\\ApplicationLatte\\Template', 'ConfigTransformer2021101110\\Nette\\Bridges\\ApplicationLatte\\DefaultTemplate'];
    /**
     * @var \Symplify\Astral\Naming\SimpleNameResolver
     */
    private $simpleNameResolver;
    /**
     * @var \Symplify\Astral\TypeAnalyzer\ContainsTypeAnalyser
     */
    private $containsTypeAnalyser;
    public function __construct(\ConfigTransformer2021101110\Symplify\Astral\Naming\SimpleNameResolver $simpleNameResolver, \ConfigTransformer2021101110\Symplify\Astral\TypeAnalyzer\ContainsTypeAnalyser $containsTypeAnalyser)
    {
        $this->simpleNameResolver = $simpleNameResolver;
        $this->containsTypeAnalyser = $containsTypeAnalyser;
    }
    /**
     * E.g. $this->template->key
     */
    public function isTemplateMagicPropertyType(\ConfigTransformer2021101110\PhpParser\Node\Expr $expr, \ConfigTransformer2021101110\PHPStan\Analyser\Scope $scope) : bool
    {
        if (!$expr instanceof \ConfigTransformer2021101110\PhpParser\Node\Expr\PropertyFetch) {
            return \false;
        }
        if (!$expr->var instanceof \ConfigTransformer2021101110\PhpParser\Node\Expr\PropertyFetch) {
            return \false;
        }
        return $this->isTemplateType($expr->var, $scope);
    }
    /**
     * E.g. $this->template
     */
    public function isTemplateType(\ConfigTransformer2021101110\PhpParser\Node\Expr $expr, \ConfigTransformer2021101110\PHPStan\Analyser\Scope $scope) : bool
    {
        return $this->containsTypeAnalyser->containsExprTypes($expr, $scope, self::TEMPLATE_TYPES);
    }
    /**
     * This type has getComponent() method
     */
    public function isInsideComponentContainer(\ConfigTransformer2021101110\PHPStan\Analyser\Scope $scope) : bool
    {
        $className = $this->simpleNameResolver->getClassNameFromScope($scope);
        if ($className === null) {
            return \false;
        }
        // this type has getComponent() method
        return \is_a($className, 'ConfigTransformer2021101110\\Nette\\ComponentModel\\Container', \true);
    }
    public function isInsideControl(\ConfigTransformer2021101110\PHPStan\Analyser\Scope $scope) : bool
    {
        $className = $this->simpleNameResolver->getClassNameFromScope($scope);
        if ($className === null) {
            return \false;
        }
        return \is_a($className, 'ConfigTransformer2021101110\\Nette\\Application\\UI\\Control', \true);
    }
}
