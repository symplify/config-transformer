<?php

declare (strict_types=1);
namespace ConfigTransformer202111284\Symplify\PhpConfigPrinter\ValueObject;

use Stringable;
final class FullyQualifiedImport
{
    /**
     * @var string
     */
    private $type;
    /**
     * @var string
     */
    private $fullyQualified;
    public function __construct(string $type, string $fullyQualified)
    {
        $this->type = $type;
        $this->fullyQualified = $fullyQualified;
    }
    public function __toString() : string
    {
        return $this->fullyQualified;
    }
    public function getType() : string
    {
        return $this->type;
    }
    public function getFullyQualified() : string
    {
        return $this->fullyQualified;
    }
}
