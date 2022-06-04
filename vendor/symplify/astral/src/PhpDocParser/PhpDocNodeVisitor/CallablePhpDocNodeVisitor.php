<?php

declare (strict_types=1);
namespace ConfigTransformer202206045\Symplify\Astral\PhpDocParser\PhpDocNodeVisitor;

use ConfigTransformer202206045\PHPStan\PhpDocParser\Ast\Node;
final class CallablePhpDocNodeVisitor extends \ConfigTransformer202206045\Symplify\Astral\PhpDocParser\PhpDocNodeVisitor\AbstractPhpDocNodeVisitor
{
    /**
     * @var callable(Node, string|null): (int|null|Node)
     */
    private $callable;
    /**
     * @var string|null
     */
    private $docContent;
    /**
     * @param callable(Node $callable, string|null $docContent): (int|null|Node) $callable
     */
    public function __construct(callable $callable, ?string $docContent)
    {
        $this->docContent = $docContent;
        $this->callable = $callable;
    }
    /**
     * @return int|\PHPStan\PhpDocParser\Ast\Node|null
     */
    public function enterNode(\ConfigTransformer202206045\PHPStan\PhpDocParser\Ast\Node $node)
    {
        $callable = $this->callable;
        return $callable($node, $this->docContent);
    }
}
