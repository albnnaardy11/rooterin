#!/bin/bash

# RooterIN Sentinel Deep Scan Automation
# Frequency: Every 01:00 AM
# Target: Production Environment (cPanel)

PATH=/usr/local/bin:/usr/bin:/bin
PHP_PATH=$(which php)
PROJECT_ROOT=$(pwd)

echo "[$(date)] INITIATING SENTINEL DEEP SCAN..." >> $PROJECT_ROOT/storage/logs/sentinel_cron.log

# 1. Execute Holistic Audit via Artisan
$PHP_PATH $PROJECT_ROOT/artisan tinker --execute="app(App\Services\Sentinel\SentinelService::class)->executeHolisticAudit();" >> $PROJECT_ROOT/storage/logs/sentinel_cron.log 2>&1

# 2. Reclaim Entropy
$PHP_PATH $PROJECT_ROOT/artisan tinker --execute="App\Services\Security\EntropyGuard::reclaim();" >> $PROJECT_ROOT/storage/logs/sentinel_cron.log 2>&1

echo "[$(date)] SENTINEL SCAN COMPLETE. NODE STABILIZED." >> $PROJECT_ROOT/storage/logs/sentinel_cron.log
