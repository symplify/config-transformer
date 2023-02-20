<?php

declare (strict_types=1);
namespace Symplify\ConfigTransformer\NodeVisitor;

use ConfigTransformerPrefix202302\PhpParser\Node;
use ConfigTransformerPrefix202302\PhpParser\Node\Expr\Array_;
use ConfigTransformerPrefix202302\PhpParser\Node\Expr\ArrayItem;
use ConfigTransformerPrefix202302\PhpParser\Node\Expr\MethodCall;
use ConfigTransformerPrefix202302\PhpParser\Node\Identifier;
use ConfigTransformerPrefix202302\PhpParser\Node\Scalar\String_;
use ConfigTransformerPrefix202302\PhpParser\NodeVisitorAbstract;
use Symplify\PhpConfigPrinter\Contract\NodeVisitor\PrePrintNodeVisitorInterface;
final class EscapeRoutingRequirementsPrePrintNodeVisitor extends NodeVisitorAbstract implements PrePrintNodeVisitorInterface
{
    public function enterNode(Node $node) : ?Node
    {
        if (!$node instanceof MethodCall) {
            return null;
        }
        if (!$node->name instanceof Identifier) {
            return null;
        }
        if ($node->name->toString() !== 'requirements') {
            return null;
        }
        $firstArg = $node->getArgs()[0];
        if (!$firstArg->value instanceof Array_) {
            return null;
        }
        foreach ($firstArg->value->items as $arrayItem) {
            if (!$arrayItem instanceof ArrayItem) {
                continue;
            }
            if (!$arrayItem->value instanceof String_) {
                continue;
            }
            $possiblyEscapedString = $arrayItem->value;
            // handle in more optimal way :)
            if ($possiblyEscapedString->value === 'd+') {
                $possiblyEscapedString->value = '\\d+';
            }
        }
        return $node;
    }
}
