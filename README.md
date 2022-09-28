<h1 align="center">Pronamic WordPress File Header</h1>

<p align="center">
	Many WordPress plugins contain bash scripts with <code>sed</code> and <code>awk</code> commands to update WordPress file headers. Because <code>sed</code> and <code>awk</code> commands are difficult to read and can be error prone we have developed this library. This library makes it easy to read and/or edit WordPress file headers in for example <code>plugin.php</code>, <code>style.css</code> or <code>readme.txt</code>.
</p>

## Table of contents

- [Getting Started](#getting-started)
- [Command Line Usage](#command-line-usage)
  - [Examples](#examples)
- [Alternatives](#alternatives)
- [Links](#links)

## Getting Started

### Installation

To start documenting your WordPress filters and actions, require Pronamic WordPress Documentor in Composer:

```
composer require pronamic/wp-file-header --dev
```

## Command Line Usage

### Examples

```
vendor/bin/pronamic-wp-file-header get Version plugin.php
```

```
vendor/bin/pronamic-wp-file-header get 'Stable tag' readme.txt
```

```
vendor/bin/pronamic-wp-file-header get Version style.css
```

```
vendor/bin/pronamic-wp-file-header set Version 1.0.0 plugin.php
```

```
vendor/bin/pronamic-wp-file-header set 'Stable tag' 4.3 readme.txt
```

```
vendor/bin/pronamic-wp-file-header set Version 1.3 style.css
```

## Alternatives

Here is a list of alternatives that we found. However, none of these satisfied our requirements.

*If you know other similar projects, feel free to edit this section!*

- [wp-file-header-metadata](https://github.com/ahmadawais/wp-file-header-metadata) by [Ahmad Awais](https://github.com/ahmadawais)

## Links

- https://codex.wordpress.org/File_Header
- https://codex.wordpress.org/File_Header_API
- https://developer.wordpress.org/plugins/plugin-basics/header-requirements/#header-fields
- https://developer.wordpress.org/plugins/wordpress-org/how-your-readme-txt-works/
- https://developer.wordpress.org/themes/basics/main-stylesheet-style-css/
- https://docs.npmjs.com/cli/v7/commands/npm-pkg
- https://developer.wordpress.org/reference/functions/get_plugin_data/
- https://developer.wordpress.org/reference/functions/get_file_data/
- https://github.com/wp-cli/i18n-command/blob/v2.4.0/src/FileDataExtractor.php
