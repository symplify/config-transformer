# Convert Symfony YAML configs to PHP

[![Downloads total](https://img.shields.io/packagist/dt/symplify/config-transformer.svg?style=flat-square)](https://packagist.org/packages/symplify/config-transformer/stats)

<br>

Why to PHP? It's the best format for PHP Symfony applications:

* [Modernize Symfony Configs](https://getrector.com/blog/modernize-symfony-configs)
* [10 Cool Features You Get after switching from YAML to PHP Configs](https://tomasvotruba.com/blog/2020/07/16/10-cool-features-you-get-after-switching-from-yaml-to-php-configs/)
* [How to Switch from YAML/XML Configs to PHP Today with Symplify](https://tomasvotruba.com/blog/2020/07/27/how-to-switch-from-yaml-xml-configs-to-php-today-with-migrify/)

## Install

```bash
composer require symplify/config-transformer --dev
```

<br>

## Usage

By default, the command uses `/config` directory to transform all files in it. At first, try to run it with `--dry-run`, just to see what files *would be* transformed:

```bash
vendor/bin/config-transformer --dry-run
```

<br>

Do you want to convert single file or directory at a time? Specify the paths as arguments:

```bash
vendor/bin/config-transformer config/parameters.yml  --dry-run
```

<br>

Are you ready to go? Remove `--dry-run`:

```bash
vendor/bin/config-transformer
```

The input files are deleted automatically.

<br>

### Skip Routes at First

It's typical to upgrade first services and then routes as follow up PR. To do that, use `--skip-routes` option:

```bash
vendor/bin/config-transformer --skip-routes
```
