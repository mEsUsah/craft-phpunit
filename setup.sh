#!/bin/bash

# Written by Stanley Skarshaug 2024.09.29
# https://github.com/mEsUsah
# https://www.haxor.no

# Install PHP dependencies
composer upgrade vlucas/phpdotenv:^5
composer require phpunit/phpunit guzzlehttp/guzzle --dev

# Create directories
mkdir -p tests/Unit
mkdir -p tests/Feature

# Config file
wget https://raw.githubusercontent.com/mEsUsah/craft-phpunit/refs/heads/master/phpunit.xml -O phpunit.xml

# Bootstrap file
wget https://raw.githubusercontent.com/mEsUsah/craft-phpunit/refs/heads/master/tests/bootstrap.php -O tests/bootstrap.php

# Examples
wget https://raw.githubusercontent.com/mEsUsah/craft-phpunit/refs/heads/master/tests/Feature/ExampleFeatureTest.php -O tests/Feature/ExampleFeatureTest.php
wget https://raw.githubusercontent.com/mEsUsah/craft-phpunit/refs/heads/master/tests/Unit/ExampleUnitTest.php -O tests/Unit/ExampleUnitTest.php

## Gitignore cache directory
printf "\n.phpunit.cache" >> .gitignore