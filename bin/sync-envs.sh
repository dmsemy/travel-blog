#!/bin/bash

# bin/sync-envs.sh

SOURCE_FILE=".env.dev.local"
TARGET_FILE="docker/.env"

echo "🔄 Syncing $SOURCE_FILE → $TARGET_FILE"

VARS_TO_COPY=(
  POSTGRES_USER
  POSTGRES_PASSWORD
  POSTGRES_DB
  POSTGRES_VERSION
)

# Ensure target dir exists
mkdir -p "$(dirname "$TARGET_FILE")"

# Clear target file
> "$TARGET_FILE"

for VAR in "${VARS_TO_COPY[@]}"; do
  VALUE=$(grep "^$VAR=" "$SOURCE_FILE" | cut -d '=' -f2-)
  if [[ -n "$VALUE" ]]; then
    echo "$VAR=$VALUE" >> "$TARGET_FILE"
  else
    echo "⚠️  Warning: $VAR not found in $SOURCE_FILE"
  fi
done

echo "✅ Synced to $TARGET_FILE"
