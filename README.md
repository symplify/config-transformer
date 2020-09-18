# Config Format Converter

[![Downloads total](https://img.shields.io/packagist/dt/migrify/config-transformer.svg?style=flat-square)](https://packagist.org/packages/migrify/config-transformer/stats)

Convert Symfony Config Formats From XML/YAML to YAML/PHP

## Install

```bash
composer require migrify/config-transformer --dev
```

<br>

What features do we have here?

## Convert Config Formats From XML/YAML to YAML/PHP

Why? Because YAML beats XML and [PHP beats YAML](https://tomasvotruba.com/blog/2020/07/16/10-cool-features-you-get-after-switching-from-yaml-to-php-configs/).

Do you need to convert 1 file to PHP? Just add it as argument:

```bash
vendor/bin/config-transformer switch-format ecs.yaml
```

If you need more files or directories, `--input-format/-i` must be provided:

```bash
vendor/bin/config-transformer switch-format app/config --input-format xml --output-format yaml

# or in short
vendor/bin/config-transformer switch-format app/config -i xml -o yaml

# to PHP?  
vendor/bin/config-transformer switch-format app/config -i xml -o php

# you can skip the -o value, as "php" is default value
vendor/bin/config-transformer switch-format app/config -i xml
```

You can also add `--target-symfony-version/-s` to specify, what Symfony features should be used (3.2 is used by default).

```bash
vendor/bin/config-transformer switch-format app/config -i yaml -o php -s 3.3
```

*Note: Symfony YAML parse removes all comments, so be sure to go through files and add still-relevant comments manauly. Often they can be removed, as dead-code.*

## Report Issues

In case you are experiencing a bug or want to request a new feature head over to the [migrify monorepo issue tracker](https://github.com/migrify/migrify/issues)

## Contribute

The sources of this package are contained in the migrify monorepo. We welcome contributions for this package on [migrify/migrify](https://github.com/migrify/migrify).
