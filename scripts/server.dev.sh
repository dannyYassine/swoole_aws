#!/usr/bin/env bash

bash -c "exec -a swoole_server-dev php ../server.php APPLICATION_ENV=dev > /dev/null &"