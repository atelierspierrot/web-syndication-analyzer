web-syndication-analyzer
========================

A PHP package to manipulate syndication feeds.


## Usage

### First notes about standards

As for all our work, we try to follow the coding standards and naming rules most commonly in use:

-   the [PEAR coding standards](http://pear.php.net/manual/en/standards.php)
-   the [PHP Framework Interoperability Group standards](https://github.com/php-fig/fig-standards).

Knowing that, all classes are named and organized in an architecture to allow the use of the
[standard SplClassLoader](https://gist.github.com/jwage/221634).

The whole package is embedded in the `WebSyndication` namespace.

In this README documentation, the key words "MUST", "MUST NOT", "REQUIRED", "SHALL", "SHALL NOT",
"SHOULD", "SHOULD NOT", "RECOMMENDED", "MAY", and "OPTIONAL" in this document are to be
interpreted as described in [RFC 2119](http://www.ietf.org/rfc/rfc2119.txt).

### Installation

You can use this package in your work in many ways. Note that it depends on the external
packages:

-   [PHP Patterns](https://github.com/atelierspierrot/patterns)
-   [PHP Patterns](https://github.com/atelierspierrot/library).

First, you can clone the [GitHub](https://github.com/atelierspierrot/web-syndication-analyzer) repository
and include it "as is" in your poject:

    https://github.com/atelierspierrot/patterns
    https://github.com/atelierspierrot/library
    https://github.com/atelierspierrot/web-syndication-analyzer

You can also download an [archive](https://github.com/atelierspierrot/web-syndication-analyzer/downloads)
from Github.

Then, to use the package classes, you just need to register the `Library` AND the `Patterns`
namespace directory using the [SplClassLoader](https://gist.github.com/jwage/221634) or
any other custom autoloader (if required, a copy of the `SplClassLoader` is proposed in
the package):

```php
require_once '.../src/SplClassLoader.php';
$patternsLoader = new SplClassLoader('Patterns', '/path/to/patterns/package/src');
$patternsLoader->register();
$libraryLoader = new SplClassLoader('Library', '/path/to/package/src');
$libraryLoader->register();
$libraryLoader = new SplClassLoader('WebSyndication', '/path/to/package/src');
$libraryLoader->register();
```

If you are a [Composer](http://getcomposer.org/) user, just add the package to your requirements
in your `composer.json`:

```json
"require": {
    "yrou/deps": "*",
    "atelierspierrot/web-syndication-analyzer": "dev-master"
}
```

The namespaces will be automatically added to the project Composer autoloader.


## Author & License

>    PHP Web Syndication Analyzer

>    http://github.com/atelierspierrot/web-syndication-analyzer

>    Copyright (c) 2014-2015 Pierre Cassat and contributors

>    Licensed under the Apache 2.0 license.

>    http://www.apache.org/licenses/LICENSE-2.0

>    ----

>    Les Ateliers Pierrot - Paris, France

>    <http://www.ateliers-pierrot.fr/> - <contact@ateliers-pierrot.fr>
