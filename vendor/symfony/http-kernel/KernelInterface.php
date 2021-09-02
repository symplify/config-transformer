<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202109023\Symfony\Component\HttpKernel;

use ConfigTransformer202109023\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202109023\Symfony\Component\DependencyInjection\ContainerInterface;
use ConfigTransformer202109023\Symfony\Component\HttpKernel\Bundle\BundleInterface;
/**
 * The Kernel is the heart of the Symfony system.
 *
 * It manages an environment made of application kernel and bundles.
 *
 * @method string getBuildDir() Returns the build directory - not implementing it is deprecated since Symfony 5.2.
 *                              This directory should be used to store build artifacts, and can be read-only at runtime.
 *                              Caches written at runtime should be stored in the "cache directory" ({@see KernelInterface::getCacheDir()}).
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
interface KernelInterface extends \ConfigTransformer202109023\Symfony\Component\HttpKernel\HttpKernelInterface
{
    /**
     * Returns an array of bundles to register.
     *
     * @return iterable|BundleInterface[] An iterable of bundle instances
     */
    public function registerBundles();
    /**
     * Loads the container configuration.
     * @param \Symfony\Component\Config\Loader\LoaderInterface $loader
     */
    public function registerContainerConfiguration($loader);
    /**
     * Boots the current kernel.
     */
    public function boot();
    /**
     * Shutdowns the kernel.
     *
     * This method is mainly useful when doing functional testing.
     */
    public function shutdown();
    /**
     * Gets the registered bundle instances.
     *
     * @return BundleInterface[] An array of registered bundle instances
     */
    public function getBundles();
    /**
     * Returns a bundle.
     *
     * @return BundleInterface A BundleInterface instance
     *
     * @throws \InvalidArgumentException when the bundle is not enabled
     * @param string $name
     */
    public function getBundle($name);
    /**
     * Returns the file path for a given bundle resource.
     *
     * A Resource can be a file or a directory.
     *
     * The resource name must follow the following pattern:
     *
     *     "@BundleName/path/to/a/file.something"
     *
     * where BundleName is the name of the bundle
     * and the remaining part is the relative path in the bundle.
     *
     * @return string The absolute path of the resource
     *
     * @throws \InvalidArgumentException if the file cannot be found or the name is not valid
     * @throws \RuntimeException         if the name contains invalid/unsafe characters
     * @param string $name
     */
    public function locateResource($name);
    /**
     * Gets the environment.
     *
     * @return string The current environment
     */
    public function getEnvironment();
    /**
     * Checks if debug mode is enabled.
     *
     * @return bool true if debug mode is enabled, false otherwise
     */
    public function isDebug();
    /**
     * Gets the project dir (path of the project's composer file).
     *
     * @return string
     */
    public function getProjectDir();
    /**
     * Gets the current container.
     *
     * @return ContainerInterface
     */
    public function getContainer();
    /**
     * Gets the request start time (not available if debug is disabled).
     *
     * @return float The request start timestamp
     */
    public function getStartTime();
    /**
     * Gets the cache directory.
     *
     * Since Symfony 5.2, the cache directory should be used for caches that are written at runtime.
     * For caches and artifacts that can be warmed at compile-time and deployed as read-only,
     * use the new "build directory" returned by the {@see getBuildDir()} method.
     *
     * @return string The cache directory
     */
    public function getCacheDir();
    /**
     * Gets the log directory.
     *
     * @return string The log directory
     */
    public function getLogDir();
    /**
     * Gets the charset of the application.
     *
     * @return string The charset
     */
    public function getCharset();
}
