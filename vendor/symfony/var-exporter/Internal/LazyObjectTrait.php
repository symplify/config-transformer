<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformerPrefix202507\Symfony\Component\VarExporter\Internal;

use ConfigTransformerPrefix202507\Symfony\Component\Serializer\Attribute\Ignore;
if (\PHP_VERSION_ID >= 80300) {
    /**
     * @internal
     */
    trait LazyObjectTrait
    {
        /**
         * @readonly
         * @var \Symfony\Component\VarExporter\Internal\LazyObjectState
         */
        private $lazyObjectState;
    }
} else {
    /**
     * @internal
     */
    trait LazyObjectTrait
    {
        /**
         * @var \Symfony\Component\VarExporter\Internal\LazyObjectState
         */
        private $lazyObjectState;
    }
}
