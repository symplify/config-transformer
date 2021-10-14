<?php

declare (strict_types=1);
namespace ConfigTransformer202110145\Symplify\PhpConfigPrinter\CaseConverter;

use ConfigTransformer202110145\PhpParser\Node\Stmt\Expression;
use ConfigTransformer202110145\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use ConfigTransformer202110145\Symplify\PhpConfigPrinter\NodeFactory\Service\ServicesPhpNodeFactory;
use ConfigTransformer202110145\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ResourceCaseConverter implements \ConfigTransformer202110145\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\Service\ServicesPhpNodeFactory
     */
    private $servicesPhpNodeFactory;
    public function __construct(\ConfigTransformer202110145\Symplify\PhpConfigPrinter\NodeFactory\Service\ServicesPhpNodeFactory $servicesPhpNodeFactory)
    {
        $this->servicesPhpNodeFactory = $servicesPhpNodeFactory;
    }
    public function convertToMethodCall($key, $values) : \ConfigTransformer202110145\PhpParser\Node\Stmt\Expression
    {
        // Due to the yaml behavior that does not allow the declaration of several identical key names.
        if (isset($values['namespace'])) {
            $key = $values['namespace'];
            unset($values['namespace']);
        }
        return $this->servicesPhpNodeFactory->createResource($key, $values);
    }
    /**
     * @param string $rootKey
     */
    public function match($rootKey, $key, $values) : bool
    {
        return isset($values[\ConfigTransformer202110145\Symplify\PhpConfigPrinter\ValueObject\YamlKey::RESOURCE]);
    }
}
