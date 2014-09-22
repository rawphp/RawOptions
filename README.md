# RawOptions - A Simple Session Wrapper Class for PHP Applications

[![Build Status](https://travis-ci.org/rawphp/RawOptions.svg?branch=master)](https://travis-ci.org/rawphp/RawOptions)
[![Latest Stable Version](https://poser.pugx.org/rawphp/raw-options/v/stable.svg)](https://packagist.org/packages/rawphp/raw-options) [![Total Downloads](https://poser.pugx.org/rawphp/raw-options/downloads.svg)](https://packagist.org/packages/rawphp/raw-options) 
[![Latest Unstable Version](https://poser.pugx.org/rawphp/raw-options/v/unstable.svg)](https://packagist.org/packages/rawphp/raw-options) [![License](https://poser.pugx.org/rawphp/raw-options/license.svg)](https://packagist.org/packages/rawphp/raw-options)

## Package Features
- Manage application options in the database through key->value pairs.
- Provides a ready-to-go database table migration and an option interface.

## Installation

### Composer
RawOptions is available via [Composer/Packagist](https://packagist.org/packages/rawphp/raw-options).

Add `"rawphp/raw-options": "0.*@dev"` to the require block in your composer.json and then run `composer install`.

```json
{
        "require": {
            "rawphp/raw-options": "0.*@dev"
        }
}
```

You can also simply run the following from the command line:

```sh
composer require rawphp/raw-options "0.*@dev"
```

### Tarball
Alternatively, just copy the contents of the RawOptions folder into somewhere that's in your PHP `include_path` setting. If you don't speak git or just want a tarball, click the 'zip' button at the top of the page in GitHub.

## Basic Usage

```php
<?php

use RawPHP\RawOptions\Options;

// IDatabase instance
$database = new Database( );
$database->init( $config );

// instantiate a new instance of options service
$options = new Options( $database );

// add a new option
$options->addOption( $key, $value );

// update an existing option
$options->updateOption( $key, $value );

// get an option
$options->getOption( $key );

// delete an option
$options->deleteOption( $key );
```

## License
This package is licensed under the [MIT](https://github.com/rawphp/RawOptions/blob/master/LICENSE). Read LICENSE for information on the software availability and distribution.

## Contributing

Please submit bug reports, suggestions and pull requests to the [GitHub issue tracker](https://github.com/rawphp/RawOptions/issues).

## Changelog

#### 22-09-2014
- Updated to PHP 5.3.

#### 20-09-2014
- Replaced php array configuration with yaml

#### 18-09-2014
- Updated to work with the latest rawphp/rawbase package.

#### 17-09-2014
- Initial Code Commit