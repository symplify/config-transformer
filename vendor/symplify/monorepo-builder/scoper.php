<?php

declare (strict_types=1);
namespace ConfigTransformer202301;

use ConfigTransformer202301\Isolated\Symfony\Component\Finder\Finder;
require __DIR__ . '/vendor/autoload.php';
$timestamp = (new \DateTime('now'))->format('Ym');
// @see https://github.com/humbug/php-scoper/blob/master/docs/further-reading.md
use ConfigTransformer202301\Nette\Utils\Strings;
$polyfillsBootstraps = \array_map(static function (\SplFileInfo $fileInfo) {
    return $fileInfo->getPathname();
}, \iterator_to_array(Finder::create()->files()->in(__DIR__ . '/vendor/symfony/polyfill-*')->name('bootstrap*.php'), \false));
$polyfillsStubs = \array_map(static function (\SplFileInfo $fileInfo) {
    return $fileInfo->getPathname();
}, \iterator_to_array(Finder::create()->files()->in(__DIR__ . '/vendor/symfony/polyfill-*/Resources/stubs')->name('*.php'), \false));
// see https://github.com/humbug/php-scoper
return ['prefix' => 'MonorepoBuilder' . $timestamp, 'exclude-files' => \array_merge([
    // these paths are relative to this file location, so it should be in the root directory
    'vendor/symfony/deprecation-contracts/function.php',
], $polyfillsBootstraps, $polyfillsStubs), 'exclude-namespaces' => [
    '#^Symplify\\\\MonorepoBuilder#',
    '#^Symfony\\\\Polyfill#',
    // part of public API in \Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface
    '#^PharIo\\\\Version#',
], 'exclude-constants' => ['#^SYMFONY\\_[\\p{L}_]+$#'], 'expose-classes' => [
    'Normalizer',
    // part of public interface of configs.php
    'ConfigTransformer202301\\Symplify\\MonorepoBuilder\\ComposerJsonManipulator\\ValueObject\\ComposerJsonSection',
    'ConfigTransformer202301\\Symfony\\Component\\DependencyInjection\\Loader\\Configurator\\ContainerConfigurator',
], 'patchers' => [
    // scope symfony configs
    function (string $filePath, string $prefix, string $content) : string {
        if (!Strings::match($filePath, '#(packages|config|services)\\.php$#')) {
            return $content;
        }
        // fix symfony config load scoping, except CodingStandard and EasyCodingStandard
        $content = Strings::replace($content, '#load\\(\'Symplify\\\\\\\\(?<package_name>[A-Za-z]+)#', function (array $match) use($prefix) {
            return 'load(\'' . $prefix . '\\Symplify\\' . $match['package_name'];
        });
        return $content;
    },
    // scope symfony configs
    function (string $filePath, string $prefix, string $content) : string {
        if (!Strings::match($filePath, '#(packages|config|services)\\.php$#')) {
            return $content;
        }
        // unprefix symfony config
        return Strings::replace($content, '#load\\(\'' . $prefix . '\\\\Symplify\\\\MonorepoBuilder#', 'load(\'' . 'Symplify\\MonorepoBuilder');
    },
]];
