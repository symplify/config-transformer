<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\Service;

use Migrify\ConfigTransformer\FeatureShifter\ValueObject\YamlKey;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\ArgsNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\CommonNodeFactory;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;

final class AutoBindNodeFactory
{
    /**
     * @var CommonNodeFactory
     */
    private $commonNodeFactory;

    /**
     * @var ArgsNodeFactory
     */
    private $argsNodeFactory;

    public function __construct(CommonNodeFactory $commonNodeFactory, ArgsNodeFactory $argsNodeFactory)
    {
        $this->commonNodeFactory = $commonNodeFactory;
        $this->argsNodeFactory = $argsNodeFactory;
    }

    /**
     * Decorated node with:
     * ->autowire()
     * ->autoconfigure()
     * ->bind()
     */
    public function createAutoBindCalls(array $yaml, MethodCall $methodCall): MethodCall
    {
        foreach ($yaml as $key => $value) {
            if (in_array($key, ['autowire', 'autoconfigure', 'public'], true)) {
                $methodCall = new MethodCall($methodCall, $key);
                if ($value === false) {
                    $methodCall->args[] = new Arg($this->commonNodeFactory->createFalse());
                }
            }

            if ($key === YamlKey::BIND) {
                $methodCall = $this->createBindMethodCall($methodCall, $yaml[YamlKey::BIND]);
            }
        }

        return $methodCall;
    }

    private function createBindMethodCall(MethodCall $methodCall, array $bindValues): MethodCall
    {
        foreach ($bindValues as $key => $value) {
            $args = $this->argsNodeFactory->createFromValues([$key, $value]);
            $methodCall = new MethodCall($methodCall, YamlKey::BIND, $args);
        }

        return $methodCall;
    }
}
