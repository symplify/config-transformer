# Config Format Converter

[![Downloads total](https://img.shields.io/packagist/dt/migrify/config-transformer.svg?style=flat-square)](https://packagist.org/packages/migrify/config-transformer/stats)

Convert Symfony XML format to YAML or clarify Symfony/Nette syntax to readable one - all the useful utils around configs.

## Install

```bash
composer require migrify/config-transformer --dev
```

<br>

What features do we have here?

## 1. Convert Config Formats From XML/YAML to PHP/YAMl

```bash
vendor/bin/config-transformer switch-format app/config --intput-format xml --output-format yaml
```

You can also add `target-symfony-version` to specify, what Symfony features should be used.

```bash
vendor/bin/config-transformer switch-format app/config --intput-format xml --output-format yaml --target-symfony-version 3.3
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
