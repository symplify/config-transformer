<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\NodeModifier;

use ConfigTransformerPrefix202401\Nette\Utils\Strings;
use ConfigTransformerPrefix202401\PhpParser\Node\Arg;
use ConfigTransformerPrefix202401\PhpParser\Node\Expr\Array_;
use ConfigTransformerPrefix202401\PhpParser\Node\Expr\ArrayItem;
use ConfigTransformerPrefix202401\PhpParser\Node\Expr\FuncCall;
use ConfigTransformerPrefix202401\PhpParser\Node\Name\FullyQualified;
use ConfigTransformerPrefix202401\PhpParser\Node\Scalar\String_;
use Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use Symplify\PhpConfigPrinter\ValueObject\FunctionName;
final class SingleFactoryReferenceNodeModifier
{
    /**
     * @readonly
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    /**
     * @see https://regex101.com/r/Smydt1/2
     * @var string
     */
    private const FACTORY_REGEX = '#(?<callee>.*?)(?<operator>\\:{1,2})(?<method_name>\\w+)#';
    public function __construct(ArgsNodeFactory $argsNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
    }
    /**
     * @param Arg[] $args
     */
    public function modifyArgs(array $args) : void
    {
        // split "service_name:methodName" shortcut to 2 args
        if (\count($args) !== 1) {
            return;
        }
        $singleArgValue = $args[0]->value;
        if (!$singleArgValue instanceof Array_) {
            return;
        }
        if (\count($singleArgValue->items) !== 1) {
            return;
        }
        $singleArrayItem = $singleArgValue->items[0];
        if (!$singleArrayItem instanceof ArrayItem) {
            return;
        }
        if (!$singleArrayItem->value instanceof String_) {
            return;
        }
        $factoryValue = $singleArrayItem->value;
        $match = Strings::match($factoryValue->value, self::FACTORY_REGEX);
        if ($match === null) {
            return;
        }
        $callee = $match['operator'] === ':' ? $this->createServiceFuncCall($match['callee']) : $this->argsNodeFactory->resolveExpr($match['callee']);
        $methodNameString = new String_($match['method_name']);
        $singleArgValue->items = [new ArrayItem($callee), new ArrayItem($methodNameString)];
    }
    private function createServiceFuncCall(string $serviceName) : FuncCall
    {
        $serviceFuncCallArgs = $this->argsNodeFactory->createFromValues([$serviceName]);
        return new FuncCall(new FullyQualified(FunctionName::SERVICE), $serviceFuncCallArgs);
    }
}