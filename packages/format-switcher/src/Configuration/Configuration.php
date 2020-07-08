<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Configuration;

use Migrify\ConfigTransformer\FormatSwitcher\Exception\InvalidConfigurationException;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\Option;
use Symfony\Component\Console\Input\InputInterface;

final class Configuration
{
    /**
     * @var string[]
     */
    private const ALLOWED_OUTPUT_FORMATS = ['yaml'];

    /**
     * @var string
     */
    private $outputFormat;

    /**
     * @var string
     */
    private $source;

    /**
     * @var float
     */
    private $targetSymfonyVersion;

    /**
     * @var bool
     */
    private $shouldDeleteOldFiles = false;

    public function populateFromInput(InputInterface $input): void
    {
        $this->source = (string) $input->getArgument(Option::SOURCE);

        $this->targetSymfonyVersion = floatval($input->getOption(Option::TARGET_SYMFONY_VERSION));

        $this->shouldDeleteOldFiles = boolval($input->getOption(Option::DELETE));

        /** @var string $outputFormat */
        $outputFormat = (string) $input->getOption(Option::OUTPUT_FORMAT);
        $this->validateOutputFormatValue($outputFormat);
        $this->outputFormat = $outputFormat;
    }

    public function getOutputFormat(): string
    {
        return $this->outputFormat;
    }

    public function getSource(): string
    {
        return $this->source;
    }

    public function getTargetSymfonyVersion(): float
    {
        return $this->targetSymfonyVersion;
    }

    public function isAtLeastSymfonyVersion(float $symfonyVersion): bool
    {
        return $this->targetSymfonyVersion >= $symfonyVersion;
    }

    public function shouldDeleteOldFiles(): bool
    {
        return $this->shouldDeleteOldFiles;
    }

    private function validateOutputFormatValue(string $outputFormat): void
    {
        if ($outputFormat === '') {
            $message = sprintf('Add missing "--%s" option to command line', Option::OUTPUT_FORMAT);
            throw new InvalidConfigurationException($message);
        }

        if (in_array($outputFormat, self::ALLOWED_OUTPUT_FORMATS, true)) {
            return;
        }

        $message = sprintf(
            'Output format "%s" is not supported. Pick one of "%s"',
            $outputFormat,
            implode('", ', self::ALLOWED_OUTPUT_FORMATS)
        );

        throw new InvalidConfigurationException($message);
    }
}
