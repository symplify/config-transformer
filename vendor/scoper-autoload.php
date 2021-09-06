<?php

// scoper-autoload.php @generated by PhpScoper

$loader = require_once __DIR__.'/autoload.php';

// Aliases for the whitelisted classes. For more information see:
// https://github.com/humbug/php-scoper/blob/master/README.md#class-whitelisting
if (!class_exists('ComposerAutoloaderInit66e13cd7b906ccbc79da65387e300b03', false) && !interface_exists('ComposerAutoloaderInit66e13cd7b906ccbc79da65387e300b03', false) && !trait_exists('ComposerAutoloaderInit66e13cd7b906ccbc79da65387e300b03', false)) {
    spl_autoload_call('ConfigTransformer2021090610\ComposerAutoloaderInit66e13cd7b906ccbc79da65387e300b03');
}
if (!class_exists('Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator', false) && !interface_exists('Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator', false) && !trait_exists('Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator', false)) {
    spl_autoload_call('ConfigTransformer2021090610\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator');
}
if (!class_exists('Normalizer', false) && !interface_exists('Normalizer', false) && !trait_exists('Normalizer', false)) {
    spl_autoload_call('ConfigTransformer2021090610\Normalizer');
}
if (!class_exists('JsonException', false) && !interface_exists('JsonException', false) && !trait_exists('JsonException', false)) {
    spl_autoload_call('ConfigTransformer2021090610\JsonException');
}
if (!class_exists('Attribute', false) && !interface_exists('Attribute', false) && !trait_exists('Attribute', false)) {
    spl_autoload_call('ConfigTransformer2021090610\Attribute');
}
if (!class_exists('Stringable', false) && !interface_exists('Stringable', false) && !trait_exists('Stringable', false)) {
    spl_autoload_call('ConfigTransformer2021090610\Stringable');
}
if (!class_exists('UnhandledMatchError', false) && !interface_exists('UnhandledMatchError', false) && !trait_exists('UnhandledMatchError', false)) {
    spl_autoload_call('ConfigTransformer2021090610\UnhandledMatchError');
}
if (!class_exists('ValueError', false) && !interface_exists('ValueError', false) && !trait_exists('ValueError', false)) {
    spl_autoload_call('ConfigTransformer2021090610\ValueError');
}
if (!class_exists('ReturnTypeWillChange', false) && !interface_exists('ReturnTypeWillChange', false) && !trait_exists('ReturnTypeWillChange', false)) {
    spl_autoload_call('ConfigTransformer2021090610\ReturnTypeWillChange');
}

// Functions whitelisting. For more information see:
// https://github.com/humbug/php-scoper/blob/master/README.md#functions-whitelisting
if (!function_exists('composerRequire66e13cd7b906ccbc79da65387e300b03')) {
    function composerRequire66e13cd7b906ccbc79da65387e300b03() {
        return \ConfigTransformer2021090610\composerRequire66e13cd7b906ccbc79da65387e300b03(...func_get_args());
    }
}
if (!function_exists('parseArgs')) {
    function parseArgs() {
        return \ConfigTransformer2021090610\parseArgs(...func_get_args());
    }
}
if (!function_exists('showHelp')) {
    function showHelp() {
        return \ConfigTransformer2021090610\showHelp(...func_get_args());
    }
}
if (!function_exists('formatErrorMessage')) {
    function formatErrorMessage() {
        return \ConfigTransformer2021090610\formatErrorMessage(...func_get_args());
    }
}
if (!function_exists('preprocessGrammar')) {
    function preprocessGrammar() {
        return \ConfigTransformer2021090610\preprocessGrammar(...func_get_args());
    }
}
if (!function_exists('resolveNodes')) {
    function resolveNodes() {
        return \ConfigTransformer2021090610\resolveNodes(...func_get_args());
    }
}
if (!function_exists('resolveMacros')) {
    function resolveMacros() {
        return \ConfigTransformer2021090610\resolveMacros(...func_get_args());
    }
}
if (!function_exists('resolveStackAccess')) {
    function resolveStackAccess() {
        return \ConfigTransformer2021090610\resolveStackAccess(...func_get_args());
    }
}
if (!function_exists('magicSplit')) {
    function magicSplit() {
        return \ConfigTransformer2021090610\magicSplit(...func_get_args());
    }
}
if (!function_exists('assertArgs')) {
    function assertArgs() {
        return \ConfigTransformer2021090610\assertArgs(...func_get_args());
    }
}
if (!function_exists('removeTrailingWhitespace')) {
    function removeTrailingWhitespace() {
        return \ConfigTransformer2021090610\removeTrailingWhitespace(...func_get_args());
    }
}
if (!function_exists('regex')) {
    function regex() {
        return \ConfigTransformer2021090610\regex(...func_get_args());
    }
}
if (!function_exists('execCmd')) {
    function execCmd() {
        return \ConfigTransformer2021090610\execCmd(...func_get_args());
    }
}
if (!function_exists('ensureDirExists')) {
    function ensureDirExists() {
        return \ConfigTransformer2021090610\ensureDirExists(...func_get_args());
    }
}
if (!function_exists('setproctitle')) {
    function setproctitle() {
        return \ConfigTransformer2021090610\setproctitle(...func_get_args());
    }
}
if (!function_exists('array_is_list')) {
    function array_is_list() {
        return \ConfigTransformer2021090610\array_is_list(...func_get_args());
    }
}
if (!function_exists('enum_exists')) {
    function enum_exists() {
        return \ConfigTransformer2021090610\enum_exists(...func_get_args());
    }
}
if (!function_exists('includeIfExists')) {
    function includeIfExists() {
        return \ConfigTransformer2021090610\includeIfExists(...func_get_args());
    }
}
if (!function_exists('dump')) {
    function dump() {
        return \ConfigTransformer2021090610\dump(...func_get_args());
    }
}
if (!function_exists('dd')) {
    function dd() {
        return \ConfigTransformer2021090610\dd(...func_get_args());
    }
}

return $loader;
