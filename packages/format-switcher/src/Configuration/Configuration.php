<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Configuration;

use Migrify\ConfigTransformer\FormatSwitcher\Guard\InputValidator;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\Format;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\Option;
use Symfony\Component\Console\Input\InputInterface;

final class Configuration
{
    /**
     * @var string[]
     */
    private const ALLOWED_OUTPUT_FORMATS = [Format::YAML, Format::PHP];

    /**
     * @var string[]
     */
    private const ALLOWED_INPUT_FORMATS = [Format::XML, Format::YML, Format::YAML];

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

    /**
     * @var bool
     */
    private $shouldKeepBcLayer = false;

    /**
     * @var InputValidator
     */
    private $inputValidator;

    public function __construct(InputValidator $inputValidator)
    {
        $this->inputValidator = $inputValidator;
    }

    public function populateFromInput(InputInterface $input): void
    {
        $this->source = (array) $input->getArgument(Option::SOURCE);
        $this->targetSymfonyVersion = floatval($input->getOption(Option::TARGET_SYMFONY_VERSION));
        $this->dryRun = boolval($input->getOption(Option::DRY_RUN));
        $this->shouldKeepBcLayer = (bool) $input->getOption(Option::BC_LAYER);

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

    public function shouldKeepBcLayer(): bool
    {
        return $this->shouldKeepBcLayer;
    }

    public function changeInputFormat(string $inputFormat): void
    {
        $this->setInputFormat($inputFormat);
    }

    public function changeOutputFormat(string $outputFormat): void
    {
        $this->setOutputFormat($outputFormat);
    }

    /**
     * @return string[]
     */
    public function getInputSuffixes(): array
    {
        if ($this->inputFormat === Format::YAML) {
            return [Format::YAML, Format::YML];
        }

        return [$this->inputFormat];
    }

    private function resolveInputFormat(InputInterface $input): void
    {
        /** @var string $inputFormat */
        $inputFormat = (string) $input->getOption(Option::INPUT_FORMAT);

        $this->setInputFormat($inputFormat);
    }

    private function resolveOutputFormat(InputInterface $input): void
    {
        /** @var string $outputFormat */
        $outputFormat = (string) $input->getOption(Option::OUTPUT_FORMAT);

        $this->setOutputFormat($outputFormat);
    }

    private function setOutputFormat(string $outputFormat): void
    {
        $this->inputValidator->validateFormatValue(
            $outputFormat,
            self::ALLOWED_OUTPUT_FORMATS,
            Option::OUTPUT_FORMAT,
            'output'
        );

        $this->outputFormat = $outputFormat;
    }

    private function setInputFormat(string $inputFormat): void
    {
        $this->inputValidator->validateFormatValue(
            $inputFormat,
            self::ALLOWED_INPUT_FORMATS,
            Option::INPUT_FORMAT,
            'input'
        );
        if ($inputFormat === Format::YML) {
            $inputFormat = Format::YAML;
        }

        $this->inputFormat = $inputFormat;
    }
}
