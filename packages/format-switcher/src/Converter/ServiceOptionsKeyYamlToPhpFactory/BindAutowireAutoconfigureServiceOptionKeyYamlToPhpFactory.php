<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Converter\ServiceOptionsKeyYamlToPhpFactory;

use Migrify\ConfigTransformer\FeatureShifter\ValueObject\YamlKey;
use Migrify\ConfigTransformer\FeatureShifter\ValueObject\YamlServiceKey;
use Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\CommonNodeFactory;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;

final class BindAutowireAutoconfigureServiceOptionKeyYamlToPhpFactory implements ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @var CommonNodeFactory
     */
    private $commonNodeFactory;

    public function __construct(CommonNodeFactory $commonNodeFactory)
    {
        $this->commonNodeFactory = $commonNodeFactory;
    }

    public function decorateServiceMethodCall($key, $yaml, $values, MethodCall $methodCall): MethodCall
    {
        $method = $key;
        if ($key === 'shared') {
            $method = 'share';
        }

        $methodCall = new MethodCall($methodCall, $method);
        if ($yaml === false) {
            $methodCall->args[] = new Arg($this->commonNodeFactory->createFalse());
        }

        return $methodCall;
    }

    public function isMatch($key, $values): bool
    {
        return in_array($key, [YamlServiceKey::BIND, YamlKey::AUTOWIRE, YamlKey::AUTOCONFIGURE], true);
    }
}
