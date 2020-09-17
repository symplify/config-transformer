<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\ValueObject;

final class Format
{
    /**
     * @var string
     */
    public const YAML = 'yaml';

    /**
     * @var string
     */
    public const YML = 'yml';

    /**
     * @var string
     */
    public const XML = 'xml';

    /**
     * @var string
     */
    public const PHP = 'php';
}
