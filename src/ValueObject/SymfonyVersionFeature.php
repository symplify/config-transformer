<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\ValueObject;

final class SymfonyVersionFeature
{
    /**
     * @var float
     * @see https://github.com/symfony/symfony/commit/7fa8c8a7045b8bc2a2a41b0d1790027f356b93d6v
     */
    public const TAGS_WITHOUT_NAME = 3.3;
}
