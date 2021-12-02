<?php

declare (strict_types=1);
namespace ConfigTransformer2021120210\Symplify\PhpConfigPrinter\CaseConverter;

use ConfigTransformer2021120210\PhpParser\Node\Stmt\Expression;
use ConfigTransformer2021120210\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use ConfigTransformer2021120210\Symplify\PhpConfigPrinter\NodeFactory\Service\ServicesPhpNodeFactory;
use ConfigTransformer2021120210\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ResourceCaseConverter implements \ConfigTransformer2021120210\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\Service\ServicesPhpNodeFactory
     */
    private $servicesPhpNodeFactory;
    public function __construct(\ConfigTransformer2021120210\Symplify\PhpConfigPrinter\NodeFactory\Service\ServicesPhpNodeFactory $servicesPhpNodeFactory)
    {
        $this->servicesPhpNodeFactory = $servicesPhpNodeFactory;
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function convertToMethodCall($key, $values) : \ConfigTransformer2021120210\PhpParser\Node\Stmt\Expression
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
     * @param string $rootKey
     */
    public function match($rootKey, $key, $values) : bool
    {
        return isset($values[\ConfigTransformer2021120210\Symplify\PhpConfigPrinter\ValueObject\YamlKey::RESOURCE]);
    }
}
