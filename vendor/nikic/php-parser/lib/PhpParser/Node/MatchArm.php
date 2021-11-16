<?php

declare (strict_types=1);
namespace ConfigTransformer202111164\PhpParser\Node;

use ConfigTransformer202111164\PhpParser\Node;
use ConfigTransformer202111164\PhpParser\NodeAbstract;
class MatchArm extends \ConfigTransformer202111164\PhpParser\NodeAbstract
{
    /** @var null|Node\Expr[] */
    public $conds;
    /** @var Node\Expr */
    public $body;
    /**
     * @param null|Node\Expr[] $conds
     */
    public function __construct($conds, \ConfigTransformer202111164\PhpParser\Node\Expr $body, array $attributes = [])
    {
        $this->conds = $conds;
        $this->body = $body;
        $this->attributes = $attributes;
    }
    public function getSubNodeNames() : array
    {
        return ['conds', 'body'];
    }
    public function getType() : string
    {
        return 'MatchArm';
    }
}
