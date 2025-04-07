#!/bin/bash

# Usage: ./update-version.sh 1.5

VERSION=$1

if [[ -z "$VERSION" ]]; then
  echo "❌ Error: Please provide the version number. Example: ./update-version.sh 1.5"
  exit 1
fi

# ✅ Update Stable tag in readme.txt
echo "🔄 Updating Stable tag in readme.txt..."
sed -i.bak "s/^Stable tag: .*/Stable tag: $VERSION/" readme.txt && rm readme.txt.bak

# ✅ Update version badge in README.md (if it exists)
echo "🔄 Updating version badge in README.md..."
sed -i.bak "s/version-[0-9.]*-blue/version-${VERSION}-blue/" README.md && rm README.md.bak

echo "✅ Version updated to $VERSION in readme.txt and README.md"
