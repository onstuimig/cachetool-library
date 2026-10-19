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
