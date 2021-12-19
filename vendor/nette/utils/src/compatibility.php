<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace ConfigTransformer202112197\Nette\Utils;

use ConfigTransformer202112197\Nette;
if (\false) {
    /** @deprecated use Nette\HtmlStringable */
    interface IHtmlString extends \ConfigTransformer202112197\Nette\HtmlStringable
    {
    }
} elseif (!\interface_exists(\ConfigTransformer202112197\Nette\Utils\IHtmlString::class)) {
    \class_alias(\ConfigTransformer202112197\Nette\HtmlStringable::class, \ConfigTransformer202112197\Nette\Utils\IHtmlString::class);
}
namespace ConfigTransformer202112197\Nette\Localization;

if (\false) {
    /** @deprecated use Nette\Localization\Translator */
    interface ITranslator extends \ConfigTransformer202112197\Nette\Localization\Translator
    {
    }
} elseif (!\interface_exists(\ConfigTransformer202112197\Nette\Localization\ITranslator::class)) {
    \class_alias(\ConfigTransformer202112197\Nette\Localization\Translator::class, \ConfigTransformer202112197\Nette\Localization\ITranslator::class);
}
