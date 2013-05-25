#!/bin/sh
MATERIAL_DIR="./material_skin"
rm -rf $MATERIAL_DIR
mkdir $MATERIAL_DIR
cp -rf ../skin/install/ $MATERIAL_DIR
cp -rf ../skin/adminhtml/ $MATERIAL_DIR
# Copy and override according to the fallback base/default <- package/default_theme <- package/theme
SKIN_PATH="$MATERIAL_DIR/frontend/default/default"
mkdir -p $SKIN_PATH
cp -rf ../skin/frontend/base/default/* $SKIN_PATH
cp -rf ../skin/frontend/default/default/* $SKIN_PATH


