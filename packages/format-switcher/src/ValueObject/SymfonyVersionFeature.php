<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\ValueObject;

final class SymfonyVersionFeature
{
    /**
     * @var float
     * @see https://github.com/symfony/symfony/commit/7fa8c8a7045b8bc2a2a41b0d1790027f356b93d6v
     */
    public const TAGS_WITHOUT_NAME = 3.3;

    /**
     * @var float
     * @see https://symfony.com/blog/new-in-symfony-3-3-optional-class-for-named-services
     * @see https://github.com/symfony/symfony/issues/22146#issuecomment-288988780
     */
    public const SERVICE_WITHOUT_NAME = 3.3;
}
