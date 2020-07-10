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
    private const ALLOWED_OUTPUT_FORMATS = ['yaml', 'php'];

    /**
     * @var string[]
     */
    private const ALLOWED_INPUT_FORMATS = ['xml', 'yaml'];

    /**
     * @var string
     */
    private $outputFormat;

    /**
     * @var string
     */
    private $inputFormat;

    /**
     * @var string[]
     */
    private $source = [];

    /**
     * @var float
     */
    private $targetSymfonyVersion;

    /**
     * @var bool
     */
    private $dryRun = false;

    public function populateFromInput(InputInterface $input): void
    {
        $this->source = (array) $input->getArgument(Option::SOURCE);

        $this->targetSymfonyVersion = floatval($input->getOption(Option::TARGET_SYMFONY_VERSION));

        $this->dryRun = boolval($input->getOption(Option::DRY_RUN));

        $this->resolveInputFormat($input);
        $this->resolveOutputFormat($input);
    }

    public function getOutputFormat(): string
    {
        return $this->outputFormat;
    }

    public function getSource(): array
    {
        return $this->source;
    }

    public function isAtLeastSymfonyVersion(float $symfonyVersion): bool
    {
        return $this->targetSymfonyVersion >= $symfonyVersion;
    }

    public function isDryRun(): bool
    {
        return $this->dryRun;
    }

    public function getInputFormat(): string
    {
        return $this->inputFormat;
    }

    public function changeSymfonyVersion(float $symfonyVersion): void
    {
        $this->targetSymfonyVersion = $symfonyVersion;
    }

    private function resolveInputFormat(InputInterface $input): void
    {
        /** @var string $inputFormat */
        $inputFormat = (string) $input->getOption(Option::INPUT_FORMAT);

        $this->validateFormatValue($inputFormat, self::ALLOWED_INPUT_FORMATS, Option::INPUT_FORMAT, 'input');

        $this->inputFormat = $inputFormat;
    }

    /**
     * @param string[] $allowedValues
     */
    private function validateFormatValue(
        string $formatValue,
        array $allowedValues,
        string $optionKey,
        string $type
    ): void {
        if ($formatValue === '') {
            $message = sprintf('Add missing "--%s" option to command line', $optionKey);
            throw new InvalidConfigurationException($message);
        }

        if (in_array($formatValue, $allowedValues, true)) {
            return;
        }

        $message = sprintf(
            '%s format "%s" is not supported. Pick one of "%s"',
            ucfirst($type),
            $formatValue,
            implode('", ', $allowedValues)
        );

        throw new InvalidConfigurationException($message);
    }

    private function resolveOutputFormat(InputInterface $input): void
    {
        /** @var string $outputFormat */
        $outputFormat = (string) $input->getOption(Option::OUTPUT_FORMAT);

        $this->validateFormatValue($outputFormat, self::ALLOWED_OUTPUT_FORMATS, Option::OUTPUT_FORMAT, 'output');

        $this->outputFormat = $outputFormat;
    }
}
