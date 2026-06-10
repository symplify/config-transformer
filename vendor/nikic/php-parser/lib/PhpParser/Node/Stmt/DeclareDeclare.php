<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202606\PhpParser\Node\Stmt;

use ConfigTransformerPrefix202606\PhpParser\Node\DeclareItem;
require __DIR__ . '/../DeclareItem.php';
if (\false) {
    /**
     * For classmap-authoritative support.
     *
     * @deprecated use \PhpParser\Node\DeclareItem instead.
     */
    class DeclareDeclare extends DeclareItem
    {
    }
}
