<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace ConfigTransformer2022022110\Nette;

interface HtmlStringable
{
    /**
     * Returns string in HTML format
     */
    function __toString() : string;
}
\interface_exists(\ConfigTransformer2022022110\Nette\Utils\IHtmlString::class);
