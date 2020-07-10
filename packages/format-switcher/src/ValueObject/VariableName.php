<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\ValueObject;

final class VariableName
{
    /**
     * @var string
     */
    public const CONTAINER_CONFIGURATOR = 'containerConfigurator';

    /**
     * @var string
     */
    public const SERVICES = 'services';

    /**
     * @var string
     */
    public const PARAMETERS = 'parameters';
}
