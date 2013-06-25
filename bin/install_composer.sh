#!/bin/bash
if [ ! -f composer.phar ]; then curl -s http://getcomposer.org/installer | php; fi; php composer.phar install
