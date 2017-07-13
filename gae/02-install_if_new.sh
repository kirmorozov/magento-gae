#!/usr/bin/env bash

if [ ! -f app/etc/env.php ]; then
    echo "Configuration File not found! Installing!"
fi