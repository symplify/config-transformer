# Config Format Converter

[![Downloads total](https://img.shields.io/packagist/dt/migrify/config-transformer.svg?style=flat-square)](https://packagist.org/packages/migrify/config-transformer/stats)

Toolkit for quick operations around configs.
Convert Symfony config formats or turn magic syntax to more readable one.

## Install

```bash
composer require migrify/config-transformer --dev
```

<br>

What features do we have here?

## 1. Convert Config Formats From XML/YAML to YAML/PHP

Why? Because YAML beats XML and [PHP beats YAML](https://tomasvotruba.com/blog/2020/07/16/10-cool-features-you-get-after-switching-from-yaml-to-php-configs/).

```bash
vendor/bin/config-transformer switch-format app/config --input-format xml --output-format yaml

# or in short
vendor/bin/config-transformer switch-format app/config -i xml -o yaml

```

You can also add `--target-symfony-version/-s` to specify, what Symfony features should be used (3.2 is used by default).

```bash
vendor/bin/config-transformer switch-format app/config -i yaml -o php -s 3.3
```

<br>

## 2. Make Configs Explicit

Take NEON/YAML magic *pro* short syntax and reveal it to clear syntax readable by any developer.

Do you use [Nette](https://nette.org/)? You can convert unpopular ["entities"](https://ne-on.org/) to clear arrays:

```diff
 services:
-    - SomeClass(1, 2)
+    -
+        class: SomeClass
+        arguments:
+            - 1
+            - 2
```

Just run `clarify` command:

```bash
vendor/bin/config-clarity clarify /config/sinle_file.neon
vendor/bin/config-clarity clarify /config
```

## Report Issues

In case you are experiencing a bug or want to request a new feature head over to the [migrify monorepo issue tracker](https://github.com/migrify/migrify/issues)

## Contribute

The sources of this package are contained in the migrify monorepo. We welcome contributions for this package on [migrify/migrify](https://github.com/migrify/migrify).
