<?php

declare (strict_types=1);
namespace ConfigTransformer202111013\PhpParser\Builder;

use ConfigTransformer202111013\PhpParser\Builder;
use ConfigTransformer202111013\PhpParser\BuilderHelpers;
use ConfigTransformer202111013\PhpParser\Node;
use ConfigTransformer202111013\PhpParser\Node\Stmt;
class TraitUse implements \ConfigTransformer202111013\PhpParser\Builder
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
        $this->traits[] = \ConfigTransformer202111013\PhpParser\BuilderHelpers::normalizeName($trait);
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
        $adaptation = \ConfigTransformer202111013\PhpParser\BuilderHelpers::normalizeNode($adaptation);
        if (!$adaptation instanceof \ConfigTransformer202111013\PhpParser\Node\Stmt\TraitUseAdaptation) {
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
    public function getNode() : \ConfigTransformer202111013\PhpParser\Node
    {
        return new \ConfigTransformer202111013\PhpParser\Node\Stmt\TraitUse($this->traits, $this->adaptations);
    }
}
