<?php

declare (strict_types=1);
namespace ConfigTransformer202202161\Symplify\PhpConfigPrinter\Sorter;

use ConfigTransformer202202161\Symplify\PhpConfigPrinter\ValueObject\FullyQualifiedImport;
use ConfigTransformer202202161\Symplify\PhpConfigPrinter\ValueObject\ImportType;
final class FullyQualifiedImportSorter
{
    /**
     * @var array<string, int>
     */
    private const TYPE_ORDER = [\ConfigTransformer202202161\Symplify\PhpConfigPrinter\ValueObject\ImportType::CLASS_TYPE => 0, \ConfigTransformer202202161\Symplify\PhpConfigPrinter\ValueObject\ImportType::CONSTANT_TYPE => 1, \ConfigTransformer202202161\Symplify\PhpConfigPrinter\ValueObject\ImportType::FUNCTION_TYPE => 2];
    /**
     * @param FullyQualifiedImport[] $imports
     *
     * @return FullyQualifiedImport[]
     */
    public function sortImports(array $imports) : array
    {
        $sortByFullQualifiedCallback = static function (\ConfigTransformer202202161\Symplify\PhpConfigPrinter\ValueObject\FullyQualifiedImport $left, \ConfigTransformer202202161\Symplify\PhpConfigPrinter\ValueObject\FullyQualifiedImport $right) : int {
            return \strcmp($left->getFullyQualified(), $right->getFullyQualified());
        };
        \usort($imports, $sortByFullQualifiedCallback);
        $sortByTypeCallback = static function (\ConfigTransformer202202161\Symplify\PhpConfigPrinter\ValueObject\FullyQualifiedImport $left, \ConfigTransformer202202161\Symplify\PhpConfigPrinter\ValueObject\FullyQualifiedImport $right) : int {
            return self::TYPE_ORDER[$left->getType()] <=> self::TYPE_ORDER[$right->getType()];
        };
        \usort($imports, $sortByTypeCallback);
        return $imports;
    }
}
