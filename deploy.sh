#!/bin/bash

set -euo pipefail

REPO="https://github.com/Jebadeiah/regnumjeb.com.git"
BRANCH="main"
TMP_DIR="/tmp/deploy_regnum"
PROJECT_DIR="/var/www/regnumjeb.com"
LOG_FILE="$PROJECT_DIR/deploy.log"

log() {
  echo "[$(date '+%Y-%m-%d %H:%M:%S')] $*" | tee -a "$LOG_FILE"
}

abort() {
  log "❌ ERROR: $1"
  exit 1
}

{
  log "=== Starting deployment ==="

  log "🔐 Ensuring GitHub is in known_hosts..."
  mkdir -p ~/.ssh
  ssh-keyscan github.com >> ~/.ssh/known_hosts 2>/dev/null || abort "Failed to add GitHub to known_hosts"

  log "🧹 Cleaning temp directory..."
  rm -rf "$TMP_DIR" || abort "Failed to remove temp directory"

  log "📦 Cloning fresh copy of '$BRANCH' branch from repo..."
  git clone --branch "$BRANCH" "$REPO" "$TMP_DIR" || abort "Git clone failed"

  log "🚚 Syncing to web root at $PROJECT_DIR..."
  rsync -av --delete "$TMP_DIR/" "$PROJECT_DIR/" || abort "Rsync failed"

  log "✅ Deploy finished successfully"
} 2>&1 | tee -a "$LOG_FILE"

exit_code=${PIPESTATUS[0]}

if [ $exit_code -eq 0 ]; then
  log "🎉 Deployment completed without errors"
else
  log "💥 Deployment failed with exit code $exit_code"
fi

exit $exit_code