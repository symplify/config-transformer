<?php

declare(strict_types=1);

namespace Symplify\ConfigTransformer\Tests\Helper\ValueObject;

final class InputAndExpected
{
    public function __construct(
        private readonly string $input,
        private readonly string $expected
    ) {
    }

    public function getInput(): string
    {
        return $this->input;
    }

    public function getExpected(): string
    {
        return $this->expected;
    }
}
