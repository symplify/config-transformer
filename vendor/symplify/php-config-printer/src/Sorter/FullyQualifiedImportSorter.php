<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\Sorter;

use Symplify\PhpConfigPrinter\ValueObject\FullyQualifiedImport;
use Symplify\PhpConfigPrinter\ValueObject\ImportType;
final class FullyQualifiedImportSorter
{
    /**
     * @var array<string, int>
     */
    private const TYPE_ORDER = [ImportType::CLASS_TYPE => 0, ImportType::CONSTANT_TYPE => 1, ImportType::FUNCTION_TYPE => 2];
    /**
     * @param FullyQualifiedImport[] $imports
     *
     * @return FullyQualifiedImport[]
     */
    public function sortImports(array $imports) : array
    {
        $sortByFullQualifiedCallback = static function (FullyQualifiedImport $firstFullyQualifiedImport, FullyQualifiedImport $secondFullyQualifiedImport) : int {
            return \strcmp($firstFullyQualifiedImport->getFullyQualified(), $secondFullyQualifiedImport->getFullyQualified());
        };
        \usort($imports, $sortByFullQualifiedCallback);
        $sortByTypeCallback = static function (FullyQualifiedImport $left, FullyQualifiedImport $right) : int {
            return self::TYPE_ORDER[$left->getType()] <=> self::TYPE_ORDER[$right->getType()];
        };
        \usort($imports, $sortByTypeCallback);
        return $imports;
    }
}
