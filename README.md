# RawConsole - A Simple Console for PHP Applications

[![Build Status](https://travis-ci.org/rawphp/RawConsole.svg?branch=master)](https://travis-ci.org/rawphp/RawConsole)

## Package Features
- Define custom commands
- Easily run commands from the command line

## Installation

### Composer
RawConsole is available via [Composer/Packagist](https://packagist.org/packages/rawphp/raw-console).

Add `"rawphp/raw-console": "0.*@dev"` to the require block in your composer.json and then run `composer install`.

```json
{
        "require": {
            "rawphp/raw-console": "0.*@dev"
        }
}
```

You can also simply run the following from the command line:

```sh
composer require rawphp/raw-console "0.*@dev"
```

### Tarball
Alternatively, just copy the contents of the RawConsole folder into somewhere that's in your PHP `include_path` setting. If you don't speak git or just want a tarball, click the 'zip' button at the top of the page in GitHub.

## Usage
See 'tests/_support' directory for example commands.

The test bootstrap file shows an example of how to run the Console.

## License
This package is licensed under the [MIT](https://github.com/rawphp/RawConsole/blob/master/LICENSE). Read LICENSE for information on the software availability and distribution.

## Contributing

Please submit bug reports, suggestions and pull requests to the [GitHub issue tracker](https://github.com/rawphp/RawSession/issues).

## Changelog

#### 16-09-2014
- Added new support properties to base Command class.
- Added new `init( )` method which adds the help and verbose options to the command options list.
- Added new StandardHelpWriter class for writing command help output. ( Not yet connected with the console ).

#### 15-09-2014
- Initial Code Commit
