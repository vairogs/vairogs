#!/bin/sh

# Set the core.hooksPath configuration to point to the .github/githooks directory
git config core.hooksPath .github/githooks

echo "Git hooks have been set up successfully!"
