#!/usr/bin/env bash
set -euo pipefail

# Deployment script for Laravel project.
# Use DEPLOY_BRANCH or the current git branch.
# Set SKIP_NPM=true to avoid frontend build.

PROJECT_ROOT="$(pwd)"
PHP_BIN="php"
COMPOSER_BIN="composer"
NPM_BIN="npm"
DEPLOY_BRANCH=${DEPLOY_BRANCH:-$(git rev-parse --abbrev-ref HEAD)}
SKIP_NPM=${SKIP_NPM:-false}

if [ ! -f "$PROJECT_ROOT/artisan" ]; then
  echo "Error: This script must be run from the Laravel project root."
  exit 1
fi

if [ ! -f ".env" ]; then
  echo "Error: .env file is missing. Copy .env.example and configure it first."
  exit 1
fi

if ! command -v $PHP_BIN >/dev/null 2>&1; then
  echo "Error: php is not installed or not on PATH."
  exit 1
fi

if ! command -v $COMPOSER_BIN >/dev/null 2>&1; then
  echo "Error: composer is not installed or not on PATH."
  exit 1
fi

echo "=== Deploying branch: $DEPLOY_BRANCH ==="

git fetch origin

CURRENT_BRANCH=$(git rev-parse --abbrev-ref HEAD)
if [ "$CURRENT_BRANCH" != "$DEPLOY_BRANCH" ]; then
  echo "Switching to branch $DEPLOY_BRANCH"
  git checkout "$DEPLOY_BRANCH"
fi

if ! git diff --quiet --exit-code; then
  echo "Error: working tree contains uncommitted changes. Commit or stash them before deploying."
  exit 1
fi

echo "Pulling latest code from origin/$DEPLOY_BRANCH..."
git pull origin "$DEPLOY_BRANCH"

echo "Installing composer dependencies..."
$COMPOSER_BIN install --optimize-autoloader --no-dev --prefer-dist

if [ "$SKIP_NPM" != "true" ] && [ -f package.json ]; then
  if command -v $NPM_BIN >/dev/null 2>&1; then
    echo "Installing npm dependencies..."
    $NPM_BIN ci
    echo "Building frontend assets..."
    $NPM_BIN run build
  else
    echo "Warning: npm not found, skipping frontend build."
  fi
fi

echo "Running database migrations..."
$PHP_BIN artisan migrate --force

echo "Clearing caches..."
$PHP_BIN artisan cache:clear
$PHP_BIN artisan config:cache
$PHP_BIN artisan route:cache
$PHP_BIN artisan view:cache

echo "Optimizing application..."
$PHP_BIN artisan optimize

QUEUE_CONN=$(grep -E '^QUEUE_CONNECTION=' .env | cut -d '=' -f2 | tr -d '"')
if [ "$QUEUE_CONN" != "sync" ]; then
  echo "Restarting queue workers..."
  $PHP_BIN artisan queue:restart
fi

echo "Deployment complete."
