<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202106289\Symfony\Component\HttpKernel\Controller\ArgumentResolver;

use ConfigTransformer202106289\Symfony\Component\HttpFoundation\Request;
use ConfigTransformer202106289\Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use ConfigTransformer202106289\Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
/**
 * Yields a non-variadic argument's value from the request attributes.
 *
 * @author Iltar van der Berg <kjarli@gmail.com>
 */
final class RequestAttributeValueResolver implements \ConfigTransformer202106289\Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function supports(\ConfigTransformer202106289\Symfony\Component\HttpFoundation\Request $request, \ConfigTransformer202106289\Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata $argument) : bool
    {
        return !$argument->isVariadic() && $request->attributes->has($argument->getName());
    }
    /**
     * {@inheritdoc}
     */
    public function resolve(\ConfigTransformer202106289\Symfony\Component\HttpFoundation\Request $request, \ConfigTransformer202106289\Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata $argument) : iterable
    {
        (yield $request->attributes->get($argument->getName()));
    }
}
