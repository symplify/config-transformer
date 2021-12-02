<?php

declare (strict_types=1);
namespace ConfigTransformer2021120210\PhpParser\Builder;

use ConfigTransformer2021120210\PhpParser\Builder;
use ConfigTransformer2021120210\PhpParser\BuilderHelpers;
use ConfigTransformer2021120210\PhpParser\Node;
use ConfigTransformer2021120210\PhpParser\Node\Stmt;
class TraitUse implements \ConfigTransformer2021120210\PhpParser\Builder
{
    protected $traits = [];
    protected $adaptations = [];
    /**
     * Creates a trait use builder.
     *
     * @param Node\Name|string ...$traits Names of used traits
     */
    public function __construct(...$traits)
    {
        foreach ($traits as $trait) {
            $this->and($trait);
        }
    }
    /**
     * Adds used trait.
     *
     * @param Node\Name|string $trait Trait name
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function and($trait)
    {
        $this->traits[] = \ConfigTransformer2021120210\PhpParser\BuilderHelpers::normalizeName($trait);
        return $this;
    }
    /**
     * Adds trait adaptation.
     *
     * @param Stmt\TraitUseAdaptation|Builder\TraitUseAdaptation $adaptation Trait adaptation
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function with($adaptation)
    {
        $adaptation = \ConfigTransformer2021120210\PhpParser\BuilderHelpers::normalizeNode($adaptation);
        if (!$adaptation instanceof \ConfigTransformer2021120210\PhpParser\Node\Stmt\TraitUseAdaptation) {
            throw new \LogicException('Adaptation must have type TraitUseAdaptation');
        }
        $this->adaptations[] = $adaptation;
        return $this;
    }
    /**
     * Returns the built node.
     *
     * @return Node The built node
     */
    public function getNode() : \ConfigTransformer2021120210\PhpParser\Node
    {
        return new \ConfigTransformer2021120210\PhpParser\Node\Stmt\TraitUse($this->traits, $this->adaptations);
    }
}
