<?php

declare (strict_types=1);
namespace ConfigTransformer202205211\PhpParser\Node\Stmt;

use ConfigTransformer202205211\PhpParser\Node;
use ConfigTransformer202205211\PhpParser\Node\FunctionLike;
class Function_ extends \ConfigTransformer202205211\PhpParser\Node\Stmt implements \ConfigTransformer202205211\PhpParser\Node\FunctionLike
{
    /** @var bool Whether function returns by reference */
    public $byRef;
    /** @var Node\Identifier Name */
    public $name;
    /** @var Node\Param[] Parameters */
    public $params;
    /** @var null|Node\Identifier|Node\Name|Node\ComplexType Return type */
    public $returnType;
    /** @var Node\Stmt[] Statements */
    public $stmts;
    /** @var Node\AttributeGroup[] PHP attribute groups */
    public $attrGroups;
    /** @var Node\Name Namespaced name (if using NameResolver) */
    public $namespacedName;
    /**
     * Constructs a function node.
     *
     * @param string|Node\Identifier $name Name
     * @param array  $subNodes   Array of the following optional subnodes:
     *                           'byRef'      => false  : Whether to return by reference
     *                           'params'     => array(): Parameters
     *                           'returnType' => null   : Return type
     *                           'stmts'      => array(): Statements
     *                           'attrGroups' => array(): PHP attribute groups
     * @param array  $attributes Additional attributes
     */
    public function __construct($name, array $subNodes = [], array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->byRef = $subNodes['byRef'] ?? \false;
        $this->name = \is_string($name) ? new \ConfigTransformer202205211\PhpParser\Node\Identifier($name) : $name;
        $this->params = $subNodes['params'] ?? [];
        $returnType = $subNodes['returnType'] ?? null;
        $this->returnType = \is_string($returnType) ? new \ConfigTransformer202205211\PhpParser\Node\Identifier($returnType) : $returnType;
        $this->stmts = $subNodes['stmts'] ?? [];
        $this->attrGroups = $subNodes['attrGroups'] ?? [];
    }
    public function getSubNodeNames() : array
    {
        return ['attrGroups', 'byRef', 'name', 'params', 'returnType', 'stmts'];
    }
    public function returnsByRef() : bool
    {
        return $this->byRef;
    }
    public function getParams() : array
    {
        return $this->params;
    }
    public function getReturnType()
    {
        return $this->returnType;
    }
    public function getAttrGroups() : array
    {
        return $this->attrGroups;
    }
    /** @return Node\Stmt[] */
    public function getStmts() : ?array
    {
        return $this->stmts;
    }
    public function getType() : string
    {
        return 'Stmt_Function';
    }
}
