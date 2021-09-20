<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202109209\Symfony\Component\VarDumper;

use ConfigTransformer202109209\Symfony\Component\HttpFoundation\Request;
use ConfigTransformer202109209\Symfony\Component\HttpFoundation\RequestStack;
use ConfigTransformer202109209\Symfony\Component\HttpKernel\Debug\FileLinkFormatter;
use ConfigTransformer202109209\Symfony\Component\VarDumper\Caster\ReflectionCaster;
use ConfigTransformer202109209\Symfony\Component\VarDumper\Cloner\VarCloner;
use ConfigTransformer202109209\Symfony\Component\VarDumper\Dumper\CliDumper;
use ConfigTransformer202109209\Symfony\Component\VarDumper\Dumper\ContextProvider\CliContextProvider;
use ConfigTransformer202109209\Symfony\Component\VarDumper\Dumper\ContextProvider\RequestContextProvider;
use ConfigTransformer202109209\Symfony\Component\VarDumper\Dumper\ContextProvider\SourceContextProvider;
use ConfigTransformer202109209\Symfony\Component\VarDumper\Dumper\ContextualizedDumper;
use ConfigTransformer202109209\Symfony\Component\VarDumper\Dumper\HtmlDumper;
use ConfigTransformer202109209\Symfony\Component\VarDumper\Dumper\ServerDumper;
// Load the global dump() function
require_once __DIR__ . '/Resources/functions/dump.php';
/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class VarDumper
{
    private static $handler;
    public static function dump($var)
    {
        if (null === self::$handler) {
            self::register();
        }
        return (self::$handler)($var);
    }
    /**
     * @param callable|null $callable
     */
    public static function setHandler($callable = null)
    {
        $prevHandler = self::$handler;
        // Prevent replacing the handler with expected format as soon as the env var was set:
        if (isset($_SERVER['VAR_DUMPER_FORMAT'])) {
            return $prevHandler;
        }
        self::$handler = $callable;
        return $prevHandler;
    }
    private static function register() : void
    {
        $cloner = new \ConfigTransformer202109209\Symfony\Component\VarDumper\Cloner\VarCloner();
        $cloner->addCasters(\ConfigTransformer202109209\Symfony\Component\VarDumper\Caster\ReflectionCaster::UNSET_CLOSURE_FILE_INFO);
        $format = $_SERVER['VAR_DUMPER_FORMAT'] ?? null;
        switch (\true) {
            case 'html' === $format:
                $dumper = new \ConfigTransformer202109209\Symfony\Component\VarDumper\Dumper\HtmlDumper();
                break;
            case 'cli' === $format:
                $dumper = new \ConfigTransformer202109209\Symfony\Component\VarDumper\Dumper\CliDumper();
                break;
            case 'server' === $format:
            case $format && 'tcp' === \parse_url($format, \PHP_URL_SCHEME):
                $host = 'server' === $format ? $_SERVER['VAR_DUMPER_SERVER'] ?? '127.0.0.1:9912' : $format;
                $dumper = \in_array(\PHP_SAPI, ['cli', 'phpdbg'], \true) ? new \ConfigTransformer202109209\Symfony\Component\VarDumper\Dumper\CliDumper() : new \ConfigTransformer202109209\Symfony\Component\VarDumper\Dumper\HtmlDumper();
                $dumper = new \ConfigTransformer202109209\Symfony\Component\VarDumper\Dumper\ServerDumper($host, $dumper, self::getDefaultContextProviders());
                break;
            default:
                $dumper = \in_array(\PHP_SAPI, ['cli', 'phpdbg'], \true) ? new \ConfigTransformer202109209\Symfony\Component\VarDumper\Dumper\CliDumper() : new \ConfigTransformer202109209\Symfony\Component\VarDumper\Dumper\HtmlDumper();
        }
        if (!$dumper instanceof \ConfigTransformer202109209\Symfony\Component\VarDumper\Dumper\ServerDumper) {
            $dumper = new \ConfigTransformer202109209\Symfony\Component\VarDumper\Dumper\ContextualizedDumper($dumper, [new \ConfigTransformer202109209\Symfony\Component\VarDumper\Dumper\ContextProvider\SourceContextProvider()]);
        }
        self::$handler = function ($var) use($cloner, $dumper) {
            $dumper->dump($cloner->cloneVar($var));
        };
    }
    private static function getDefaultContextProviders() : array
    {
        $contextProviders = [];
        if (!\in_array(\PHP_SAPI, ['cli', 'phpdbg'], \true) && \class_exists(\ConfigTransformer202109209\Symfony\Component\HttpFoundation\Request::class)) {
            $requestStack = new \ConfigTransformer202109209\Symfony\Component\HttpFoundation\RequestStack();
            $requestStack->push(\ConfigTransformer202109209\Symfony\Component\HttpFoundation\Request::createFromGlobals());
            $contextProviders['request'] = new \ConfigTransformer202109209\Symfony\Component\VarDumper\Dumper\ContextProvider\RequestContextProvider($requestStack);
        }
        $fileLinkFormatter = \class_exists(\ConfigTransformer202109209\Symfony\Component\HttpKernel\Debug\FileLinkFormatter::class) ? new \ConfigTransformer202109209\Symfony\Component\HttpKernel\Debug\FileLinkFormatter(null, $requestStack ?? null) : null;
        return $contextProviders + ['cli' => new \ConfigTransformer202109209\Symfony\Component\VarDumper\Dumper\ContextProvider\CliContextProvider(), 'source' => new \ConfigTransformer202109209\Symfony\Component\VarDumper\Dumper\ContextProvider\SourceContextProvider(null, null, $fileLinkFormatter)];
    }
}
