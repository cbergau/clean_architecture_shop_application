Architecture:
===

This is an example implementation of a shop which is done by the principles of clean architecture.

This repository contains all the business rules.

Metrics:
===

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/7c338ac7-3ba5-48fb-94ac-79365b45f684/big.png)](https://insight.sensiolabs.com/projects/7c338ac7-3ba5-48fb-94ac-79365b45f684) [![Build Status](https://travis-ci.org/cbergau/clean_architecture_shop_application.svg?branch=master)](https://travis-ci.org/cbergau/clean_architecture_shop_application) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/cbergau/clean_architecture_shop_application/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/cbergau/clean_architecture_shop_application/?branch=master) [![Coverage Status](https://coveralls.io/repos/github/cbergau/clean_architecture_shop_application/badge.svg?branch=master)](https://coveralls.io/github/cbergau/clean_architecture_shop_application?branch=master) [![Code Climate](https://codeclimate.com/github/cbergau/clean_architecture_shop_application/badges/gpa.svg)](https://codeclimate.com/github/cbergau/clean_architecture_shop_application)

Links for Clean Architecture:
=============================

 - http://blog.8thlight.com/uncle-bob/2012/08/13/the-clean-architecture.html
 - https://www.youtube.com/watch?v=asLUTiJJqdE

Send code coverage manually
===

    docker run --rm -e XDEBUG_CONFIG="remote_host=192.168.178.22" -e PHP_IDE_CONFIG="serverName=my.server" -v $(pwd):/var/www/html cbergau/clean_architecture_shop_symfony3client php ./vendor/bin/phpunit --coverage-clover=coverage_clover.xml --configuration=tests/ tests/
    docker run --rm -v $(pwd):/var/www/html cbergau/clean_architecture_shop_symfony3client php vendor/bin/coveralls -x coverage_clover.xml -v
