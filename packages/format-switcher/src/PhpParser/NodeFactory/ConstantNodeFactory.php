<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory;

use Migrify\ConfigTransformer\FormatSwitcher\Provider\YamlContentProvider;
use Nette\Utils\Strings;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Name;

/**
 * Hacking constants @solve better in the future
 * now it's hardcoded very deep in yaml parser, so unable to detected: https://github.com/symfony/symfony/blob/ba4d57bb5fc0e9a1b4f63ced66156296dea3687e/src/Symfony/Component/Yaml/Inline.php#L617
 * @see https://github.com/symfony/symfony/pull/18626/files
 */
final class ConstantNodeFactory
{
    /**
     * @var YamlContentProvider
     */
    private $yamlContentProvider;

    public function __construct(YamlContentProvider $yamlContentProvider)
    {
        $this->yamlContentProvider = $yamlContentProvider;
    }

    public function createConstantIfValue(string $value): ?ConstFetch
    {
        $definedConstants = get_defined_constants();

        foreach (array_keys($definedConstants) as $constantName) {
            if ($value !== constant($constantName)) {
                continue;
            }

            $yamlContent = $this->yamlContentProvider->getYamlContent();
            $constantDefinitionPattern = '#' . preg_quote('!php/const', '#') . '(\s)+' . $constantName . '#';

            if (! Strings::match($yamlContent, $constantDefinitionPattern)) {
                continue;
            }

            return new ConstFetch(new Name($constantName));
        }

        return null;
    }
}
