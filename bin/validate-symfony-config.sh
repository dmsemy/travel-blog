#!/bin/bash
set -e

export APP_ENV=test

# Only lint YAML files that are in Symfony-relevant paths (e.g. config/, translations/)
git diff --cached --name-only --diff-filter=ACM | grep -E '^(config/|translations/).+\.ya?ml$' | while IFS= read -r file; do
    if [ -f "$file" ]; then
        echo "🔎 Linting $file"
        php bin/console lint:yaml "$file" -q --parse-tags || {
            echo "❌ YAML lint failed for $file"
            exit 1
        }
    fi
done

# Lint Symfony container if config files are changed
if git diff --cached --name-only --diff-filter=ACM | grep -q '^config/'; then
    echo "🔎 Linting Symfony container..."
    php bin/console lint:container --no-debug || {
        echo "❌ Container lint failed"
        exit 1
    }
fi

echo "✅ Symfony configuration lint passed"
exit 0
