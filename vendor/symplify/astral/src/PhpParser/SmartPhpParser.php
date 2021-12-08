<?php

declare (strict_types=1);
namespace ConfigTransformer2021120810\Symplify\Astral\PhpParser;

use ConfigTransformer2021120810\PhpParser\Node\Stmt;
use ConfigTransformer2021120810\PHPStan\Parser\Parser;
/**
 * @see \Symplify\Astral\PhpParser\SmartPhpParserFactory
 */
final class SmartPhpParser
{
    /**
     * @var \PHPStan\Parser\Parser
     */
    private $parser;
    public function __construct(\ConfigTransformer2021120810\PHPStan\Parser\Parser $parser)
    {
        $this->parser = $parser;
    }
    /**
     * @return Stmt[]
     */
    public function parseFile(string $file) : array
    {
        return $this->parser->parseFile($file);
    }
    /**
     * @return Stmt[]
     */
    public function parseString(string $sourceCode) : array
    {
        return $this->parser->parseString($sourceCode);
    }
}
