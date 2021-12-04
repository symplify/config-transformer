<?php

declare (strict_types=1);
namespace ConfigTransformer2021120410\PhpParser\Builder;

use ConfigTransformer2021120410\PhpParser;
use ConfigTransformer2021120410\PhpParser\BuilderHelpers;
use ConfigTransformer2021120410\PhpParser\Node;
use ConfigTransformer2021120410\PhpParser\Node\Identifier;
use ConfigTransformer2021120410\PhpParser\Node\Name;
use ConfigTransformer2021120410\PhpParser\Node\Stmt;
class Enum_ extends \ConfigTransformer2021120410\PhpParser\Builder\Declaration
{
    protected $name;
    protected $scalarType = null;
    protected $implements = [];
    protected $uses = [];
    protected $enumCases = [];
    protected $constants = [];
    protected $methods = [];
    /** @var Node\AttributeGroup[] */
    protected $attributeGroups = [];
    /**
     * Creates an enum builder.
     *
     * @param string $name Name of the enum
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }
    /**
     * Sets the scalar type.
     *
     * @param string|Identifier $type
     *
     * @return $this
     */
    public function setScalarType($scalarType)
    {
        $this->scalarType = \ConfigTransformer2021120410\PhpParser\BuilderHelpers::normalizeType($scalarType);
        return $this;
    }
    /**
     * Implements one or more interfaces.
     *
     * @param Name|string ...$interfaces Names of interfaces to implement
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function implement(...$interfaces)
    {
        foreach ($interfaces as $interface) {
            $this->implements[] = \ConfigTransformer2021120410\PhpParser\BuilderHelpers::normalizeName($interface);
        }
        return $this;
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
        $stmt = \ConfigTransformer2021120410\PhpParser\BuilderHelpers::normalizeNode($stmt);
        $targets = [\ConfigTransformer2021120410\PhpParser\Node\Stmt\TraitUse::class => &$this->uses, \ConfigTransformer2021120410\PhpParser\Node\Stmt\EnumCase::class => &$this->enumCases, \ConfigTransformer2021120410\PhpParser\Node\Stmt\ClassConst::class => &$this->constants, \ConfigTransformer2021120410\PhpParser\Node\Stmt\ClassMethod::class => &$this->methods];
        $class = \get_class($stmt);
        if (!isset($targets[$class])) {
            throw new \LogicException(\sprintf('Unexpected node of type "%s"', $stmt->getType()));
        }
        $targets[$class][] = $stmt;
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
        $this->attributeGroups[] = \ConfigTransformer2021120410\PhpParser\BuilderHelpers::normalizeAttribute($attribute);
        return $this;
    }
    /**
     * Returns the built class node.
     *
     * @return Stmt\Enum_ The built enum node
     */
    public function getNode() : \ConfigTransformer2021120410\PhpParser\Node
    {
        return new \ConfigTransformer2021120410\PhpParser\Node\Stmt\Enum_($this->name, ['scalarType' => $this->scalarType, 'implements' => $this->implements, 'stmts' => \array_merge($this->uses, $this->enumCases, $this->constants, $this->methods), 'attrGroups' => $this->attributeGroups], $this->attributes);
    }
}
