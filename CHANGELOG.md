# 11.0.0

- Require PHP >= 8.2
- [#238](https://github.com/gordalina/cachetool/issues/238) Upgrade to Symfony 7. The new `--silent` option also disables log output.
- Upgrade `consolidation/self-update` to 3.x. The command is now `self:update`. `self-update` and `update` are aliases. It is only available in the phar.

# 10.1.0

- [#199](https://github.com/gordalina/cachetool/issues/199), [#209](https://github.com/gordalina/cachetool/issues/209) Retry a failed fastcgi or web request 3 times. Use `--retries` or the `retries` config key to change this.
- [#208](https://github.com/gordalina/cachetool/issues/208) Add the `--timeout` option and the `timeout` config key to set a timeout in seconds for each request.
- `HttpInterface::fetch()` now throws an exception if the request fails. It no longer returns a serialized error.

# 10.0.2

- [#237](https://github.com/gordalina/cachetool/issues/237) Fix `apcu:key:fetch` and `apcu:key:store` when the key contains `%`

# 10.0.1

- [#265](https://github.com/gordalina/cachetool/issues/265) Show a clear error when php-fpm cannot read the temporary file
- [#248](https://github.com/gordalina/cachetool/issues/248) Show dates in the local timezone when `date.timezone` is not set

# 10.0.0

- [#261](https://github.com/gordalina/cachetool/pull/261) Use `sys_get_temp_dir()` as default temporary directory

# 9.2.1

- Nothing changed

# 9.2.0

- [#254](https://github.com/gordalina/cachetool/pull/254) Allow excluding files in opcache:status:scripts command
- Bump symfony/http-client from 6.1.6 to 6.4.15
- Bump symfony/http-foundation from 6.1.6 to 6.4.14
- Bump symfony/process from 6.1.3 to 6.4.14
- [#252](https://github.com/gordalina/cachetool/pull/252) Fix some typos

# 9.1.0

- Initial release of library based on https://github.com/gordalina/cachetool version 9.1.0
