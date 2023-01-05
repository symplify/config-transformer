<?php

declare (strict_types=1);
namespace ConfigTransformer202301\Symplify\MonorepoBuilder\Contract\Git;

interface TagResolverInterface
{
    public function resolve(string $gitDirectory) : ?string;
}
