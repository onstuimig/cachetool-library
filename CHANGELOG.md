# 12.0.0

- Require PHP >= 8.4
- Upgrade to Symfony 8
- Replace `consolidation/self-update` with a built-in `self:update` command. It installs the latest stable release. The `--preview`, `--compatible`, and version constraint options are removed.
- Upgrade `hollodotme/fast-cgi-client` to 4. It requires the `fileinfo` extension. A FastCGI request now times out after `--timeout`, or 120 seconds if it is not set.
- Show the `--tmp-dir` hint when php-fpm returns `File not found.`. The fastcgi adapter now checks for the 404 status code.
- Log the FastCGI response at debug level. Before, the log showed `{}`.
- The `ttl` argument of `apcu:key:store` is now required. Before, the command failed without it. Use 0 to keep the key until it is deleted.
- Fix PHP 8.4 deprecations for implicitly nullable parameters and for `realpath(null)`.
- [#81](https://github.com/gordalina/cachetool/issues/81) Add the `--format` option to the commands that show information. The formats are `table`, `json`, `csv`, and `yaml`. The `json`, `csv`, and `yaml` formats contain raw values, such as bytes and Unix timestamps.
- The `apcu:key:*` commands also accept `--format`. The `table` format shows the same messages as before. The other formats always show a record, also without `-v`.
- [#241](https://github.com/gordalina/cachetool/issues/241) Add the `--sort` option to the commands that show a list. For example, `opcache:status:scripts --sort=-memory` shows the largest scripts first.
- `apcu:sma:info` and `stat:realpath_size` now show a table. `opcache:status` shows the wasted memory and the blacklist misses in separate rows, without a separator line. The value column of `apcu:cache:info` is now `Value`.
- Show a clear error with the `--tmp-dir` hint when the temporary directory cannot be written. Before, PHP warnings showed before a `Could not write to` error.

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
