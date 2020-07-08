<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\DumperFomatter;

use Migrify\ConfigTransformer\Configuration\Configuration;
use Migrify\ConfigTransformer\ValueObject\SymfonyVersionFeature;
use Nette\Utils\Strings;

final class YamlDumpFormatter
{
    /**
     * @var Configuration
     */
    private $configuration;

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function format(string $content): string
    {
        // not sure why, but sometimes there is extra value in the start
        $content = ltrim($content);

        $content = $this->addExtraSpaceBetweenServiceDefinitions($content);
        $content = $this->clearExtraTagZeroName($content);

        return $this->replaceAnonymousIdsWithDash($content);
    }

    private function addExtraSpaceBetweenServiceDefinitions(string $content): string
    {
        // put extra empty line between service definitions, to make them better readable
        $content = Strings::replace($content, '#\n    (\w)#m', "\n\n    $1");

        // except the first line under "services:"
        return Strings::replace($content, '#services:\n\n    (\w)#m', "services:\n    $1");
    }

    private function replaceAnonymousIdsWithDash(string $content): string
    {
        return Strings::replace($content, '#(\n    )(\d+)\:#m', '$1-');
    }

    private function clearExtraTagZeroName(string $content): string
    {
        // not needed, already supported by Symfony
        if ($this->configuration->isAtLeastSymfonyVersion(SymfonyVersionFeature::TAGS_WITHOUT_NAME)) {
            return $content;
        }

        // remove pre-space in tags, kinda hacky
        return Strings::replace($content, '#- [\d]+: { (\w+):#', '- { $1:');
    }
}
