<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\ValueObject;

final class Format
{
    /**
     * @var string
     */
    public const YAML = 'yaml';

    /**
     * @var string
     */
    public const XML = 'xml';

    /**
     * @var string
     */
    public const PHP = 'php';
}
