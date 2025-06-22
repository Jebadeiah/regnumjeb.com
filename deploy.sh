#!/bin/bash

REPO="git@github.com:Jebadeiah/regnumjeb.com.git"
BRANCH="main"
TMP_DIR="/tmp/deploy_regnum"
PROJECT_DIR="/var/www/regnumjeb.com"
LOG_FILE="$PROJECT_DIR/deploy.log"

{
  echo "=== $(date '+%Y-%m-%d %H:%M:%S') ==="
  echo "📦 Cloning fresh copy of repo..."

  rm -rf "$TMP_DIR"
  git clone --branch "$BRANCH" "$REPO" "$TMP_DIR" || { echo "❌ Clone failed"; exit 1; }

  echo "🚚 Syncing to web root..."
  rsync -av --delete "$TMP_DIR/" "$PROJECT_DIR/"

  echo "✅ Deploy finished successfully."
  echo
} >> "$LOG_FILE" 2>&1
