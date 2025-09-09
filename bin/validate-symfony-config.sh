#!/bin/bash
set -e

for file in $(git diff --cached --name-only --diff-filter=ACM | grep -E '\.ya?ml$'); do
    php bin/console lint:yaml "$file" -q --parse-tags || exit 1
done

if git diff --cached --name-only --diff-filter=ACM | grep -q 'config/'; then
    php bin/console lint:container --no-debug || exit 1
fi
