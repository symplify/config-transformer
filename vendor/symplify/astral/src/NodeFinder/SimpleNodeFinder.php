<?php

declare (strict_types=1);
namespace ConfigTransformer202203157\Symplify\Astral\NodeFinder;

use ConfigTransformer202203157\PhpParser\Node;
use ConfigTransformer202203157\PhpParser\NodeFinder;
use ConfigTransformer202203157\Symplify\Astral\ValueObject\AttributeKey;
final class SimpleNodeFinder
{
    /**
     * @var \PhpParser\NodeFinder
     */
    private $nodeFinder;
    public function __construct(\ConfigTransformer202203157\PhpParser\NodeFinder $nodeFinder)
    {
        $this->nodeFinder = $nodeFinder;
    }
    /**
     * @template T of Node
     * @param class-string<T> $nodeClass
     * @return \PhpParser\Node|null
     */
    public function findFirstByType(\ConfigTransformer202203157\PhpParser\Node $node, string $nodeClass)
    {
        return $this->nodeFinder->findFirstInstanceOf($node, $nodeClass);
    }
    /**
     * @template T of Node
     * @param class-string<T> $nodeClass
     * @return T[]
     */
    public function findByType(\ConfigTransformer202203157\PhpParser\Node $node, string $nodeClass) : array
    {
        return $this->nodeFinder->findInstanceOf($node, $nodeClass);
    }
    /**
     * @template T of Node
     * @param array<class-string<T>> $nodeClasses
     */
    public function hasByTypes(\ConfigTransformer202203157\PhpParser\Node $node, array $nodeClasses) : bool
    {
        foreach ($nodeClasses as $nodeClass) {
            $foundNodes = $this->findByType($node, $nodeClass);
            if ($foundNodes !== []) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @see https://phpstan.org/blog/generics-in-php-using-phpdocs for template
     *
     * @template T of Node
     * @param class-string<T> $nodeClass
     * @return T|null
     */
    public function findFirstParentByType(\ConfigTransformer202203157\PhpParser\Node $node, string $nodeClass) : ?\ConfigTransformer202203157\PhpParser\Node
    {
        $node = $node->getAttribute(\ConfigTransformer202203157\Symplify\Astral\ValueObject\AttributeKey::PARENT);
        while ($node instanceof \ConfigTransformer202203157\PhpParser\Node) {
            if (\is_a($node, $nodeClass, \true)) {
                return $node;
            }
            $node = $node->getAttribute(\ConfigTransformer202203157\Symplify\Astral\ValueObject\AttributeKey::PARENT);
        }
        return null;
    }
    /**
     * @template T of Node
     * @param array<class-string<T>&class-string<Node>> $nodeTypes
     * @return T|null
     */
    public function findFirstParentByTypes(\ConfigTransformer202203157\PhpParser\Node $node, array $nodeTypes) : ?\ConfigTransformer202203157\PhpParser\Node
    {
        $node = $node->getAttribute(\ConfigTransformer202203157\Symplify\Astral\ValueObject\AttributeKey::PARENT);
        while ($node instanceof \ConfigTransformer202203157\PhpParser\Node) {
            foreach ($nodeTypes as $nodeType) {
                if (\is_a($node, $nodeType)) {
                    return $node;
                }
            }
            $node = $node->getAttribute(\ConfigTransformer202203157\Symplify\Astral\ValueObject\AttributeKey::PARENT);
        }
        return null;
    }
}
