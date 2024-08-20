# CacheTool Library - Manage OPcache & APCu cache

[![Coverage Status](https://img.shields.io/coveralls/github/onstuimig/cachetool-library/main?style=flat-square)](https://coveralls.io/github/onstuimig/cachetool-library?branch=main)
[![Version](https://img.shields.io/github/v/tag/onstuimig/cachetool-library?sort=semver&style=flat-square)](https://github.com/onstuimig/cachetool-library/releases)
[![Downloads](https://img.shields.io/packagist/dt/onstuimig/cachetool-library?style=flat-square)](https://packagist.org/packages/onstuimig/cachetool-library)

CacheTool Library allows you to work with APCu, OPcache, and the file status cache. 
It will connect to a FastCGI server (like PHP-FPM) and operate on its cache.

> This is a library-only fork of [gordalina/cachetool](https://github.com/gordalina/cachetool)

Why is this useful?

- Maybe you want to clear the bytecode cache without reloading php-fpm or using a web endpoint
- Maybe you want to have a cron which deals with cache invalidation
- Maybe you want to see some statistics right from PHP
- And many more...

Note that, unlike APCu and Opcache, the file status cache is per-process rather than stored in shared memory. This means that running `stat:clear` against PHP-FPM will only affect whichever FPM worker responds to the request, not the whole pool. [Julien Pauli has written a post](http://blog.jpauli.tech/2014-06-30-realpath-cache-html/) with more details on how the file status cache operates.

```

## Usage

Add it as a dependency

```sh
composer require onstuimig/cachetool-library
```

Create instance

```php
use CacheTool\Adapter\FastCGI;
use CacheTool\CacheTool;

$adapter = new FastCGI('127.0.0.1:9000');
$cache = CacheTool::factory($adapter, '/tmp');
```

You can use `apcu` and `opcache` functions

```php
$cache->apcu_clear_cache();
$cache->opcache_reset();
```

## Proxies

CacheTool depends on `Proxies` to provide functionality, by default when creating a CacheTool instance from the factory
all proxies are enabled [`ApcuProxy`](https://github.com/onstuimig/cachetool-library/blob/main/src/Proxy/ApcuProxy.php), [`OpcacheProxy`](https://github.com/onstuimig/cachetool-library/blob/main/src/Proxy/OpcacheProxy.php) and [`PhpProxy`](https://github.com/onstuimig/cachetool-library/blob/main/src/Proxy/PhpProxy.php), you can customize it or extend to your will like the example below:

```php
use CacheTool\Adapter\FastCGI;
use CacheTool\CacheTool;
use CacheTool\Proxy;

$adapter = new FastCGI('/var/run/php-fpm.sock');
$cache = new CacheTool();
$cache->setAdapter($adapter);
$cache->addProxy(new Proxy\ApcuProxy());
$cache->addProxy(new Proxy\PhpProxy());
```

## Testing

After running `composer install`, run `./vendor/bin/phpunit`

### Troubleshooting test failures

#### sslip.io

Tests in `tests/Adapter/Http/FileGetContentsTest` and `tests/Adapter/Http/SymfonyHttpClientTest` rely on [sslip.io](https://sslip.io/) to resolve hostnames containing an IP to the IP contained. For this to work a nameserver from sslip.io needs to be in the DNS servers configured on the host which runs those tests, otherwise hostnames like `_.127.0.0.1.sslip.io` used for testing will not resolve. The IP addresses for the DNS servers can be found on [sslip.io](https://sslip.io), how to configure them depends on the system used to run the tests.

## Version Compatibility

| CacheTool Library | PHP
| - | -
| `9.x` | `>=8.1`

## License

CacheTool is licensed under the MIT License - see the [LICENSE](LICENSE) for details
