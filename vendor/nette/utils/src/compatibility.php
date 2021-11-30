<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace ConfigTransformer2021113010\Nette\Utils;

use ConfigTransformer2021113010\Nette;
if (\false) {
    /** @deprecated use Nette\HtmlStringable */
    interface IHtmlString extends \ConfigTransformer2021113010\Nette\HtmlStringable
    {
    }
} elseif (!\interface_exists(\ConfigTransformer2021113010\Nette\Utils\IHtmlString::class)) {
    \class_alias(\ConfigTransformer2021113010\Nette\HtmlStringable::class, \ConfigTransformer2021113010\Nette\Utils\IHtmlString::class);
}
namespace ConfigTransformer2021113010\Nette\Localization;

if (\false) {
    /** @deprecated use Nette\Localization\Translator */
    interface ITranslator extends \ConfigTransformer2021113010\Nette\Localization\Translator
    {
    }
} elseif (!\interface_exists(\ConfigTransformer2021113010\Nette\Localization\ITranslator::class)) {
    \class_alias(\ConfigTransformer2021113010\Nette\Localization\Translator::class, \ConfigTransformer2021113010\Nette\Localization\ITranslator::class);
}
