#!/usr/bin/env bash

bash -c "exec -a swoole_server php ../server.php APPLICATION_ENV=production > /dev/null &"