<?php

declare (strict_types=1);
namespace ConfigTransformer2022022410\PhpParser\Builder;

use ConfigTransformer2022022410\PhpParser;
use ConfigTransformer2022022410\PhpParser\BuilderHelpers;
use ConfigTransformer2022022410\PhpParser\Node;
use ConfigTransformer2022022410\PhpParser\Node\Stmt;
class Trait_ extends \ConfigTransformer2022022410\PhpParser\Builder\Declaration
{
    protected $name;
    protected $uses = [];
    protected $properties = [];
    protected $methods = [];
    /** @var Node\AttributeGroup[] */
    protected $attributeGroups = [];
    /**
     * Creates an interface builder.
     *
     * @param string $name Name of the interface
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }
    /**
     * Adds a statement.
     *
     * @param Stmt|PhpParser\Builder $stmt The statement to add
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function addStmt($stmt)
    {
        $stmt = \ConfigTransformer2022022410\PhpParser\BuilderHelpers::normalizeNode($stmt);
        if ($stmt instanceof \ConfigTransformer2022022410\PhpParser\Node\Stmt\Property) {
            $this->properties[] = $stmt;
        } elseif ($stmt instanceof \ConfigTransformer2022022410\PhpParser\Node\Stmt\ClassMethod) {
            $this->methods[] = $stmt;
        } elseif ($stmt instanceof \ConfigTransformer2022022410\PhpParser\Node\Stmt\TraitUse) {
            $this->uses[] = $stmt;
        } else {
            throw new \LogicException(\sprintf('Unexpected node of type "%s"', $stmt->getType()));
        }
        return $this;
    }
    /**
     * Adds an attribute group.
     *
     * @param Node\Attribute|Node\AttributeGroup $attribute
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function addAttribute($attribute)
    {
        $this->attributeGroups[] = \ConfigTransformer2022022410\PhpParser\BuilderHelpers::normalizeAttribute($attribute);
        return $this;
    }
    /**
     * Returns the built trait node.
     *
     * @return Stmt\Trait_ The built interface node
     */
    public function getNode() : \ConfigTransformer2022022410\PhpParser\Node
    {
        return new \ConfigTransformer2022022410\PhpParser\Node\Stmt\Trait_($this->name, ['stmts' => \array_merge($this->uses, $this->properties, $this->methods), 'attrGroups' => $this->attributeGroups], $this->attributes);
    }
}
