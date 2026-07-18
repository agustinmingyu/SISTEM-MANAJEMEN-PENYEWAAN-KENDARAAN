<#
.SYNOPSIS
    Deployment script for the Laravel project on Windows PowerShell.

.DESCRIPTION
    This script performs a basic deployment from the current branch, installs dependencies,
    builds frontend assets, runs migrations, clears caches, and restarts queue workers.
#>

[CmdletBinding()]
param(
    [string]$Branch = $(git rev-parse --abbrev-ref HEAD),
    [switch]$SkipNpm
)

function Fail([string]$Message) {
    Write-Error $Message
    exit 1
}

$ProjectRoot = Get-Location
if (-not (Test-Path "$ProjectRoot\artisan")) {
    Fail 'This script must be run from the Laravel project root.'
}

if (-not (Test-Path "$ProjectRoot\.env")) {
    Fail 'Missing .env file. Copy .env.example to .env and configure it first.'
}

if (-not (Get-Command php -ErrorAction SilentlyContinue)) {
    Fail 'PHP is not installed or not available on PATH.'
}

if (-not (Get-Command composer -ErrorAction SilentlyContinue)) {
    Fail 'Composer is not installed or not available on PATH.'
}

Write-Host "=== Deploying branch: $Branch ==="

$CurrentBranch = git rev-parse --abbrev-ref HEAD
if ($CurrentBranch -ne $Branch) {
    git checkout $Branch
}

$Changes = git status --porcelain
if ($Changes) {
    Fail 'Working tree contains uncommitted changes. Commit or stash them before deploying.'
}

Write-Host 'Pulling latest code...'
git pull origin $Branch

Write-Host 'Installing composer dependencies...'
composer install --optimize-autoloader --no-dev --prefer-dist

if (-not $SkipNpm -and (Test-Path "$ProjectRoot\package.json")) {
    if (-not (Get-Command npm -ErrorAction SilentlyContinue)) {
        Write-Warning 'npm not found, skipping frontend build.'
    } else {
        Write-Host 'Installing npm dependencies...'
        npm ci
        Write-Host 'Building frontend assets...'
        npm run build
    }
}

Write-Host 'Running database migrations...'
php artisan migrate --force

Write-Host 'Clearing and caching config...'
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

$envContent = Get-Content "$ProjectRoot\.env" | Select-String -Pattern '^QUEUE_CONNECTION=' | ForEach-Object { $_.Line }
$queueConnection = $envContent -replace '^QUEUE_CONNECTION=', ''
if ($queueConnection -and $queueConnection -ne 'sync') {
    Write-Host 'Restarting queue workers...'
    php artisan queue:restart
}

Write-Host 'Deployment complete.'
