<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FeatureShifter\ValueObject;

final class YamlKey
{
    /**
     * @var string
     */
    public const DEFAULTS = '_defaults';

    /**
     * @var string
     */
    public const SERVICES = 'services';

    /**
     * @var string
     */
    public const AUTOWIRE = 'autowire';

    /**
     * @var string
     */
    public const AUTOCONFIGURE = 'autoconfigure';

    /**
     * @var string
     */
    public const RESOURCE = 'resource';

    /**
     * @var string
     */
    public const _INSTANCEOF = '_instanceof';

    /**
     * @var string
     */
    public const _DEFAULTS = '_defaults';

    /**
     * @var string
     */
    public const BIND = 'bind';

    /**
     * @var string
     */
    public const IMPORTS = 'imports';

    /**
     * @var string
     */
    public const FACTORY = 'factory';

    /**
     * @var string
     */
    public const CONFIGURATOR = 'configurator';

    /**
     * @var string
     */
    public const IGNORE_ERRORS = 'ignore_errors';

    /**
     * @var string
     */
    public const PARAMETERS = 'parameters';

    /**
     * @var string
     */
    public const PUBLIC = 'public';

    /**
     * @var string
     */
    public const TAGS = 'tags';
}
