#!/bin/sh
# Syntax-check every PHP file with the PHP on PATH. Run: sh tests/php-lint.sh
set -e
php -v | head -n 1
find . -name '*.php' -not -path './node_modules/*' -not -path './.git/*' | sort | while read -r f; do
	php -l "$f" >/dev/null || { echo "Syntax error in $f"; php -l "$f"; exit 1; }
done
echo "PHP lint OK"
