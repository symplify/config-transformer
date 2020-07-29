<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\CaseConverter;

use Migrify\ConfigTransformer\FeatureShifter\ValueObject\YamlKey;
use Migrify\ConfigTransformer\FormatSwitcher\Contract\CaseConverterInterface;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\ArgsNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\Service\ServiceOptionNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\MethodName;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\VariableName;
use Migrify\ConfigTransformer\FormatSwitcher\Yaml\YamlCommentPreserver;
use Nette\Utils\Strings;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Expression;

/**
 * Handles this part:
 *
 * services:
 *     Some:
 *         class: Other <---
 */
final class ClassServiceCaseConverter implements CaseConverterInterface
{
    /**
     * @var ArgsNodeFactory
     */
    private $argsNodeFactory;

    /**
     * @var ServiceOptionNodeFactory
     */
    private $serviceOptionNodeFactory;

    public function __construct(
        ArgsNodeFactory $argsNodeFactory,
        ServiceOptionNodeFactory $serviceOptionNodeFactory
    ) {
        $this->argsNodeFactory = $argsNodeFactory;
        $this->serviceOptionNodeFactory = $serviceOptionNodeFactory;
    }

    public function convertToMethodCall($key, $values): Expression
    {
        $args = $this->argsNodeFactory->createFromValues([$key, $values[YamlKey::CLASS_KEY]]);
        $setMethodCall = new MethodCall(new Variable(VariableName::SERVICES), MethodName::SET, $args);

        unset($values[YamlKey::CLASS_KEY]);

        $setMethodCall = $this->serviceOptionNodeFactory->convertServiceOptionsToNodes($values, $setMethodCall);
        return new Expression($setMethodCall);
    }

    public function match(string $rootKey, $key, $values): bool
    {
        if ($rootKey !== YamlKey::SERVICES) {
            return false;
        }

        // comments → skip
        if (Strings::startsWith($key, YamlCommentPreserver::COMMENT_PREFIX)) {
            return false;
        }

        if (is_array($values) && count($values) !== 1) {
            return false;
        }

        return isset($values[YamlKey::CLASS_KEY]) && ! isset($values[YamlKey::ALIAS]);
    }
}
