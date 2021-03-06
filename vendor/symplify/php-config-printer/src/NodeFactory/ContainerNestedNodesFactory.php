<?php

declare (strict_types=1);
namespace ConfigTransformer202107130\Symplify\PhpConfigPrinter\NodeFactory;

use ConfigTransformer202107130\PhpParser\Node\Stmt\Expression;
use ConfigTransformer202107130\Symplify\PhpConfigPrinter\CaseConverter\InstanceOfNestedCaseConverter;
final class ContainerNestedNodesFactory
{
    /**
     * @var \Symplify\PhpConfigPrinter\CaseConverter\InstanceOfNestedCaseConverter
     */
    private $instanceOfNestedCaseConverter;
    public function __construct(\ConfigTransformer202107130\Symplify\PhpConfigPrinter\CaseConverter\InstanceOfNestedCaseConverter $instanceOfNestedCaseConverter)
    {
        $this->instanceOfNestedCaseConverter = $instanceOfNestedCaseConverter;
    }
    /**
     * @return Expression[]
     */
    public function createFromValues(array $nestedValues, string $key, $nestedKey) : array
    {
        $nestedNodes = [];
        foreach ($nestedValues as $subNestedKey => $subNestedValue) {
            if (!$this->instanceOfNestedCaseConverter->isMatch($key, $nestedKey)) {
                continue;
            }
            $nestedNodes[] = $this->instanceOfNestedCaseConverter->convertToMethodCall($subNestedKey, $subNestedValue);
        }
        return $nestedNodes;
    }
}
