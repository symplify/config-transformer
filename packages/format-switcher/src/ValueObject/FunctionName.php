<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\ValueObject;

final class FunctionName
{
    /**
     * @var string
     */
    public const INLINE_SERVICE_FUNCTION_NAME = 'Symfony\Component\DependencyInjection\Loader\Configurator\inline_service';

    /**
     * @var string
     */
    public const SERVICE_FUNCTION_NAME = 'Symfony\Component\DependencyInjection\Loader\Configurator\service';

    /**
     * @var string
     */
    public const REF_FUNCTION_NAME = 'Symfony\Component\DependencyInjection\Loader\Configurator\ref';

    /**
     * @var string
     */
    public const EXPR_FUNCTION_NAME = 'Symfony\Component\DependencyInjection\Loader\Configurator\expr';
}
