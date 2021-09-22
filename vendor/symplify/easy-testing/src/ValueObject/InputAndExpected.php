<?php

declare (strict_types=1);
namespace ConfigTransformer202109220\Symplify\EasyTesting\ValueObject;

final class InputAndExpected
{
    /**
     * @var string
     */
    private $input;
    private $expected;
    /**
     * @param mixed $expected
     */
    public function __construct(string $input, $expected)
    {
        $this->input = $input;
        $this->expected = $expected;
    }
    public function getInput() : string
    {
        return $this->input;
    }
    /**
     * @return mixed
     */
    public function getExpected()
    {
        return $this->expected;
    }
}
