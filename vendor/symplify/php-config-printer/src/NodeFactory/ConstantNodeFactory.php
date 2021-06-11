<?php

declare (strict_types=1);
namespace ConfigTransformer202106110\Symplify\PhpConfigPrinter\NodeFactory;

use ConfigTransformer202106110\Nette\Utils\Strings;
use ConfigTransformer202106110\PhpParser\Node\Expr;
use ConfigTransformer202106110\PhpParser\Node\Expr\ClassConstFetch;
use ConfigTransformer202106110\PhpParser\Node\Expr\ConstFetch;
use ConfigTransformer202106110\PhpParser\Node\Name;
use ConfigTransformer202106110\PhpParser\Node\Name\FullyQualified;
use ConfigTransformer202106110\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface;
/**
 * Hacking constants @solve better in the future now it's hardcoded very deep in yaml parser, so unable to detected:
 * https://github.com/symfony/symfony/blob/ba4d57bb5fc0e9a1b4f63ced66156296dea3687e/src/Symfony/Component/Yaml/Inline.php#L617
 *
 * @see https://github.com/symfony/symfony/pull/18626/files
 */
final class ConstantNodeFactory
{
    /**
     * @var YamlFileContentProviderInterface
     */
    private $yamlFileContentProvider;
    public function __construct(\ConfigTransformer202106110\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface $yamlFileContentProvider)
    {
        $this->yamlFileContentProvider = $yamlFileContentProvider;
    }
    /**
     * @return ConstFetch|ClassConstFetch|null
     */
    public function createConstantIfValue(string $value) : ?\ConfigTransformer202106110\PhpParser\Node\Expr
    {
        if (\ConfigTransformer202106110\Nette\Utils\Strings::contains($value, '::')) {
            [$class, $constant] = \explode('::', $value);
            // not uppercase → probably not a constant
            if (\strtoupper($constant) !== $constant) {
                return null;
            }
            return new \ConfigTransformer202106110\PhpParser\Node\Expr\ClassConstFetch(new \ConfigTransformer202106110\PhpParser\Node\Name\FullyQualified($class), $constant);
        }
        $definedConstants = \get_defined_constants();
        foreach (\array_keys($definedConstants) as $constantName) {
            if ($value !== \constant($constantName)) {
                continue;
            }
            $yamlContent = $this->yamlFileContentProvider->getYamlContent();
            $constantDefinitionPattern = '#' . \preg_quote('!php/const', '#') . '(\\s)+' . $constantName . '#';
            if (!\ConfigTransformer202106110\Nette\Utils\Strings::match($yamlContent, $constantDefinitionPattern)) {
                continue;
            }
            return new \ConfigTransformer202106110\PhpParser\Node\Expr\ConstFetch(new \ConfigTransformer202106110\PhpParser\Node\Name($constantName));
        }
        return null;
    }
}
