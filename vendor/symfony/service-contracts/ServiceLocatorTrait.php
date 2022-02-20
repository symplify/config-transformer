<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202202203\Symfony\Contracts\Service;

use ConfigTransformer202202203\Psr\Container\ContainerExceptionInterface;
use ConfigTransformer202202203\Psr\Container\NotFoundExceptionInterface;
// Help opcache.preload discover always-needed symbols
\class_exists(\ConfigTransformer202202203\Psr\Container\ContainerExceptionInterface::class);
\class_exists(\ConfigTransformer202202203\Psr\Container\NotFoundExceptionInterface::class);
/**
 * A trait to help implement ServiceProviderInterface.
 *
 * @author Robin Chalas <robin.chalas@gmail.com>
 * @author Nicolas Grekas <p@tchwork.com>
 */
trait ServiceLocatorTrait
{
    /**
     * @var mixed[]
     */
    private $factories;
    /**
     * @var mixed[]
     */
    private $loading = [];
    /**
     * @var mixed[]
     */
    private $providedTypes;
    /**
     * @param callable[] $factories
     */
    public function __construct(array $factories)
    {
        $this->factories = $factories;
    }
    /**
     * {@inheritdoc}
     */
    public function has(string $id) : bool
    {
        return isset($this->factories[$id]);
    }
    /**
     * {@inheritdoc}
     * @return mixed
     */
    public function get(string $id)
    {
        if (!isset($this->factories[$id])) {
            throw $this->createNotFoundException($id);
        }
        if (isset($this->loading[$id])) {
            $ids = \array_values($this->loading);
            $ids = \array_slice($this->loading, \array_search($id, $ids));
            $ids[] = $id;
            throw $this->createCircularReferenceException($id, $ids);
        }
        $this->loading[$id] = $id;
        try {
            return $this->factories[$id]($this);
        } finally {
            unset($this->loading[$id]);
        }
    }
    /**
     * {@inheritdoc}
     */
    public function getProvidedServices() : array
    {
        if (!isset($this->providedTypes)) {
            $this->providedTypes = [];
            foreach ($this->factories as $name => $factory) {
                if (!\is_callable($factory)) {
                    $this->providedTypes[$name] = '?';
                } else {
                    $type = (new \ReflectionFunction($factory))->getReturnType();
                    $this->providedTypes[$name] = $type ? ($type->allowsNull() ? '?' : '') . ($type instanceof \ReflectionNamedType ? $type->getName() : $type) : '?';
                }
            }
        }
        return $this->providedTypes;
    }
    private function createNotFoundException(string $id) : \ConfigTransformer202202203\Psr\Container\NotFoundExceptionInterface
    {
        if (!($alternatives = \array_keys($this->factories))) {
            $message = 'is empty...';
        } else {
            $last = \array_pop($alternatives);
            if ($alternatives) {
                $message = \sprintf('only knows about the "%s" and "%s" services.', \implode('", "', $alternatives), $last);
            } else {
                $message = \sprintf('only knows about the "%s" service.', $last);
            }
        }
        if ($this->loading) {
            $message = \sprintf('The service "%s" has a dependency on a non-existent service "%s". This locator %s', \end($this->loading), $id, $message);
        } else {
            $message = \sprintf('Service "%s" not found: the current service locator %s', $id, $message);
        }
        return new class($message) extends \InvalidArgumentException implements \ConfigTransformer202202203\Psr\Container\NotFoundExceptionInterface
        {
        };
    }
    private function createCircularReferenceException(string $id, array $path) : \ConfigTransformer202202203\Psr\Container\ContainerExceptionInterface
    {
        return new class(\sprintf('Circular reference detected for service "%s", path: "%s".', $id, \implode(' -> ', $path))) extends \RuntimeException implements \ConfigTransformer202202203\Psr\Container\ContainerExceptionInterface
        {
        };
    }
}
