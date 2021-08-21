<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace ConfigTransformer202108212\Nette\Utils;

use ConfigTransformer202108212\Nette;
if (\false) {
    /** @deprecated use Nette\HtmlStringable */
    interface IHtmlString extends \ConfigTransformer202108212\Nette\HtmlStringable
    {
    }
} elseif (!\interface_exists(\ConfigTransformer202108212\Nette\Utils\IHtmlString::class)) {
    \class_alias(\ConfigTransformer202108212\Nette\HtmlStringable::class, \ConfigTransformer202108212\Nette\Utils\IHtmlString::class);
}
namespace ConfigTransformer202108212\Nette\Localization;

if (\false) {
    /** @deprecated use Nette\Localization\Translator */
    interface ITranslator extends \ConfigTransformer202108212\Nette\Localization\Translator
    {
    }
} elseif (!\interface_exists(\ConfigTransformer202108212\Nette\Localization\ITranslator::class)) {
    \class_alias(\ConfigTransformer202108212\Nette\Localization\Translator::class, \ConfigTransformer202108212\Nette\Localization\ITranslator::class);
}
