<?php

declare (strict_types=1);
namespace ConfigTransformer2022011110\Symplify\PhpConfigPrinter\NodeFactory;

use ConfigTransformer2022011110\PhpParser\Node\Stmt\Expression;
use ConfigTransformer2022011110\Symplify\PhpConfigPrinter\CaseConverter\NestedCaseConverter\InstanceOfNestedCaseConverter;
final class ContainerNestedNodesFactory
{
    /**
     * @var \Symplify\PhpConfigPrinter\CaseConverter\NestedCaseConverter\InstanceOfNestedCaseConverter
     */
    private $instanceOfNestedCaseConverter;
    public function __construct(\ConfigTransformer2022011110\Symplify\PhpConfigPrinter\CaseConverter\NestedCaseConverter\InstanceOfNestedCaseConverter $instanceOfNestedCaseConverter)
    {
        $this->instanceOfNestedCaseConverter = $instanceOfNestedCaseConverter;
    }
    /**
     * @return Expression[]
     * @param int|string $nestedKey
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
