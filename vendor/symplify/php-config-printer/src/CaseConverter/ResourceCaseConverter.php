<?php

declare (strict_types=1);
namespace ConfigTransformer202206072\Symplify\PhpConfigPrinter\CaseConverter;

use ConfigTransformer202206072\PhpParser\Node\Stmt\Expression;
use ConfigTransformer202206072\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use ConfigTransformer202206072\Symplify\PhpConfigPrinter\NodeFactory\Service\ServicesPhpNodeFactory;
use ConfigTransformer202206072\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ResourceCaseConverter implements CaseConverterInterface
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\Service\ServicesPhpNodeFactory
     */
    private $servicesPhpNodeFactory;
    public function __construct(ServicesPhpNodeFactory $servicesPhpNodeFactory)
    {
        $this->servicesPhpNodeFactory = $servicesPhpNodeFactory;
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function convertToMethodCall($key, $values) : Expression
    {
        // Due to the yaml behavior that does not allow the declaration of several identical key names.
        if (isset($values['namespace'])) {
            $key = $values['namespace'];
            unset($values['namespace']);
        }
        return $this->servicesPhpNodeFactory->createResource($key, $values);
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function match(string $rootKey, $key, $values) : bool
    {
        return isset($values[YamlKey::RESOURCE]);
    }
}
