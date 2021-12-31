<?php

// scoper-autoload.php @generated by PhpScoper

$loader = require_once __DIR__.'/autoload.php';

// Aliases for the whitelisted classes. For more information see:
// https://github.com/humbug/php-scoper/blob/master/README.md#class-whitelisting
if (!class_exists('ComposerAutoloaderInit3fa8b228cc21cd1b60563c4f4c404d79', false) && !interface_exists('ComposerAutoloaderInit3fa8b228cc21cd1b60563c4f4c404d79', false) && !trait_exists('ComposerAutoloaderInit3fa8b228cc21cd1b60563c4f4c404d79', false)) {
    spl_autoload_call('ConfigTransformer2021123110\ComposerAutoloaderInit3fa8b228cc21cd1b60563c4f4c404d79');
}
if (!class_exists('Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator', false) && !interface_exists('Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator', false) && !trait_exists('Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator', false)) {
    spl_autoload_call('ConfigTransformer2021123110\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator');
}
if (!class_exists('Normalizer', false) && !interface_exists('Normalizer', false) && !trait_exists('Normalizer', false)) {
    spl_autoload_call('ConfigTransformer2021123110\Normalizer');
}
if (!class_exists('ReturnTypeWillChange', false) && !interface_exists('ReturnTypeWillChange', false) && !trait_exists('ReturnTypeWillChange', false)) {
    spl_autoload_call('ConfigTransformer2021123110\ReturnTypeWillChange');
}

// Functions whitelisting. For more information see:
// https://github.com/humbug/php-scoper/blob/master/README.md#functions-whitelisting
if (!function_exists('composerRequire3fa8b228cc21cd1b60563c4f4c404d79')) {
    function composerRequire3fa8b228cc21cd1b60563c4f4c404d79() {
        return \ConfigTransformer2021123110\composerRequire3fa8b228cc21cd1b60563c4f4c404d79(...func_get_args());
    }
}
if (!function_exists('scanPath')) {
    function scanPath() {
        return \ConfigTransformer2021123110\scanPath(...func_get_args());
    }
}
if (!function_exists('lintFile')) {
    function lintFile() {
        return \ConfigTransformer2021123110\lintFile(...func_get_args());
    }
}
if (!function_exists('parseArgs')) {
    function parseArgs() {
        return \ConfigTransformer2021123110\parseArgs(...func_get_args());
    }
}
if (!function_exists('showHelp')) {
    function showHelp() {
        return \ConfigTransformer2021123110\showHelp(...func_get_args());
    }
}
if (!function_exists('formatErrorMessage')) {
    function formatErrorMessage() {
        return \ConfigTransformer2021123110\formatErrorMessage(...func_get_args());
    }
}
if (!function_exists('preprocessGrammar')) {
    function preprocessGrammar() {
        return \ConfigTransformer2021123110\preprocessGrammar(...func_get_args());
    }
}
if (!function_exists('resolveNodes')) {
    function resolveNodes() {
        return \ConfigTransformer2021123110\resolveNodes(...func_get_args());
    }
}
if (!function_exists('resolveMacros')) {
    function resolveMacros() {
        return \ConfigTransformer2021123110\resolveMacros(...func_get_args());
    }
}
if (!function_exists('resolveStackAccess')) {
    function resolveStackAccess() {
        return \ConfigTransformer2021123110\resolveStackAccess(...func_get_args());
    }
}
if (!function_exists('magicSplit')) {
    function magicSplit() {
        return \ConfigTransformer2021123110\magicSplit(...func_get_args());
    }
}
if (!function_exists('assertArgs')) {
    function assertArgs() {
        return \ConfigTransformer2021123110\assertArgs(...func_get_args());
    }
}
if (!function_exists('removeTrailingWhitespace')) {
    function removeTrailingWhitespace() {
        return \ConfigTransformer2021123110\removeTrailingWhitespace(...func_get_args());
    }
}
if (!function_exists('regex')) {
    function regex() {
        return \ConfigTransformer2021123110\regex(...func_get_args());
    }
}
if (!function_exists('execCmd')) {
    function execCmd() {
        return \ConfigTransformer2021123110\execCmd(...func_get_args());
    }
}
if (!function_exists('ensureDirExists')) {
    function ensureDirExists() {
        return \ConfigTransformer2021123110\ensureDirExists(...func_get_args());
    }
}
if (!function_exists('setproctitle')) {
    function setproctitle() {
        return \ConfigTransformer2021123110\setproctitle(...func_get_args());
    }
}
if (!function_exists('array_is_list')) {
    function array_is_list() {
        return \ConfigTransformer2021123110\array_is_list(...func_get_args());
    }
}
if (!function_exists('enum_exists')) {
    function enum_exists() {
        return \ConfigTransformer2021123110\enum_exists(...func_get_args());
    }
}
if (!function_exists('includeIfExists')) {
    function includeIfExists() {
        return \ConfigTransformer2021123110\includeIfExists(...func_get_args());
    }
}

return $loader;
