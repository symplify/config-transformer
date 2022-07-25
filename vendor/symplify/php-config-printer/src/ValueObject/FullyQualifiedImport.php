<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\ValueObject;

use Stringable;
final class FullyQualifiedImport
{
    /**
     * @var ImportType::*
     */
    private $type;
    /**
     * @var string
     */
    private $fullyQualified;
    /**
     * @var string
     */
    private $shortClassName;
    /**
     * @param ImportType::* $type
     */
    public function __construct(string $type, string $fullyQualified, string $shortClassName)
    {
        $this->type = $type;
        $this->fullyQualified = $fullyQualified;
        $this->shortClassName = $shortClassName;
    }
    public function __toString() : string
    {
        return $this->fullyQualified;
    }
    /**
     * @return ImportType::*
     */
    public function getType() : string
    {
        return $this->type;
    }
    public function getFullyQualified() : string
    {
        return $this->fullyQualified;
    }
    public function getShortClassName() : string
    {
        return $this->shortClassName;
    }
}
