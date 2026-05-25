<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202605\PhpParser\Node\Stmt;

use ConfigTransformerPrefix202605\PhpParser\Node\UseItem;
require __DIR__ . '/../UseItem.php';
if (\false) {
    /**
     * For classmap-authoritative support.
     *
     * @deprecated use \PhpParser\Node\UseItem instead.
     */
    class UseUse extends UseItem
    {
    }
}
