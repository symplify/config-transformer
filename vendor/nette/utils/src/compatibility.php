<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace ConfigTransformer202107130\Nette\Utils;

use ConfigTransformer202107130\Nette;
if (\false) {
    /** @deprecated use Nette\HtmlStringable */
    interface IHtmlString extends \ConfigTransformer202107130\Nette\HtmlStringable
    {
    }
} elseif (!\interface_exists(\ConfigTransformer202107130\Nette\Utils\IHtmlString::class)) {
    \class_alias(\ConfigTransformer202107130\Nette\HtmlStringable::class, \ConfigTransformer202107130\Nette\Utils\IHtmlString::class);
}
namespace ConfigTransformer202107130\Nette\Localization;

if (\false) {
    /** @deprecated use Nette\Localization\Translator */
    interface ITranslator extends \ConfigTransformer202107130\Nette\Localization\Translator
    {
    }
} elseif (!\interface_exists(\ConfigTransformer202107130\Nette\Localization\ITranslator::class)) {
    \class_alias(\ConfigTransformer202107130\Nette\Localization\Translator::class, \ConfigTransformer202107130\Nette\Localization\ITranslator::class);
}
