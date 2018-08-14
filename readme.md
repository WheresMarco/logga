

# Logga

Simple logger for PHP stuff. Supports logging to PHP error_log, sending emails, and calling webhooks. Add as a composer package and go nuts.

Based on the [VIP Go MU Plugins Logger](https://github.com/Automattic/vip-go-mu-plugins/blob/master/000-debug/logger.php).

## Requirements

PHP 5.4.0 or later.

## Composer

You can install the bindings via [Composer](http://getcomposer.org/). Run the following command:

```bash
composer require wm/logga
```

To use the bindings, use Composer's [autoload](https://getcomposer.org/doc/01-basic-usage.md#autoloading):

```php
require_once('vendor/autoload.php');
```

## Getting Started

Simple usage looks like:

```php
$l = new \WM\Logga();
$l->text('A thing to log');
```

## Usage

### Text (to PHP error_log)

 * `$l->text($something_to_log);` - error_log(print_r($something_to_log, true));
 * `$l->text(compact('v1','v2');` - log several variables with labels
 * `$l->text($thing5, $thing10);` - log two things
 * `$l->text();`  - log the file:line
 * `$l->text(null, $stuff, $ba);` - log the file:line, then log two things.

The first call of `$l->text()` will print an extra line containing a random ID & PID and the script name or URL. The ID prefixes every `$l->text()` log entry thereafter. The extra line and ID will help you to indentify and correlate log entries.

 **Example:**
`$l->text('yo')`
`$l->text('dude')`

 **/tmp/php-errors:**
```
 * 	[21-Jun-2012 14:45:13] 1566-32201 => /home/wpcom/public_html/bin/wpshell/wpshell.php
 * 	[21-Jun-2012 14:45:13] 1566-32201 yo
 * 	[21-Jun-2012 14:50:23] 1566-32201 dude
```
`$l->text()` returns its input so you can safely wrap most kinds of expressions to log them.
`$l->text($arg1, $arg2)` will call `$l->text($arg1)` and `$l->text($arg2)` and then return `$arg1`.

A null argument will log the file and line number of the `$l->text()` call.

### Email

To be added.

### Webhook

To be added.
