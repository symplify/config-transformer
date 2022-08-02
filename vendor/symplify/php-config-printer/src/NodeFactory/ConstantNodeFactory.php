<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\NodeFactory;

use ConfigTransformer202208\Nette\Utils\Strings;
use ConfigTransformer202208\PhpParser\Node\Expr\ClassConstFetch;
use ConfigTransformer202208\PhpParser\Node\Expr\ConstFetch;
use ConfigTransformer202208\PhpParser\Node\Name;
use ConfigTransformer202208\PhpParser\Node\Name\FullyQualified;
/**
 * @see https://github.com/symfony/symfony/pull/18626/files
 *
 * @see \Symplify\PhpConfigPrinter\Tests\NodeFactory\ConstantNodeFactoryTest
 */
final class ConstantNodeFactory
{
    /**
     * @see https://regex101.com/r/xrllDg/1
     * @var string
     */
    private const CLASS_CONST_FETCH_REGEX = '#(.*?)::[A-Za-z_]#';
    public function createClassConstantIfValue(string $value, bool $checkExistence = \true) : ?ClassConstFetch
    {
        $match = Strings::match($value, self::CLASS_CONST_FETCH_REGEX);
        if ($match !== null) {
            [$class, $constant] = \explode('::', $value);
            if (!$checkExistence) {
                return new ClassConstFetch(new FullyQualified($class), $constant);
            }
            if (\class_exists($class)) {
                return new ClassConstFetch(new FullyQualified($class), $constant);
            }
        }
        return null;
    }
    /**
     * @return \PhpParser\Node\Expr\ConstFetch|\PhpParser\Node\Expr\ClassConstFetch
     */
    public function createConstant(string $value)
    {
        $classConstFetch = $this->createClassConstantIfValue($value, \false);
        if ($classConstFetch instanceof ClassConstFetch) {
            return $classConstFetch;
        }
        return new ConstFetch(new Name($value));
    }
}
