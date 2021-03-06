<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202107130\Symfony\Component\HttpKernel\Controller\ArgumentResolver;

use ConfigTransformer202107130\Symfony\Component\HttpFoundation\Request;
use ConfigTransformer202107130\Symfony\Component\HttpFoundation\Session\SessionInterface;
use ConfigTransformer202107130\Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use ConfigTransformer202107130\Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
/**
 * Yields the Session.
 *
 * @author Iltar van der Berg <kjarli@gmail.com>
 */
final class SessionValueResolver implements \ConfigTransformer202107130\Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface
{
    /**
     * {@inheritdoc}
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata $argument
     */
    public function supports($request, $argument) : bool
    {
        if (!$request->hasSession()) {
            return \false;
        }
        $type = $argument->getType();
        if (\ConfigTransformer202107130\Symfony\Component\HttpFoundation\Session\SessionInterface::class !== $type && !\is_subclass_of($type, \ConfigTransformer202107130\Symfony\Component\HttpFoundation\Session\SessionInterface::class)) {
            return \false;
        }
        return $request->getSession() instanceof $type;
    }
    /**
     * {@inheritdoc}
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata $argument
     */
    public function resolve($request, $argument) : iterable
    {
        (yield $request->getSession());
    }
}
