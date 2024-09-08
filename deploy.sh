#!/bin/bash

# Bring down the old compose
echo "Stopping Docker containers..."
docker compose down --remove-orphans

# Pull the latest from the git repository
echo "Pulling the latest changes from git repository..."
git pull origin main || { echo "Git pull failed"; exit 1; }

# Run Node.js build process
echo "Running Node.js build process..."
docker run --rm -v ./:/app -w /app node:lts-alpine sh -c 'npm install; npm run build'

# Remove node_modules directory
echo "Removing node_modules directory..."
rm -rf './node_modules/'

# Build Docker images
echo "Building Docker images..."
docker compose -f compose.yaml -f compose.prod.yaml build --no-cache

# Start Docker containers
echo "Starting Docker containers..."
docker compose -f compose.yaml -f compose.prod.yaml up -d --wait

echo "Script execution completed."
