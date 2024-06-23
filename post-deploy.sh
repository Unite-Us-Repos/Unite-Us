#!/bin/bash

# Clear the view cache
wp acorn view:cache

# Remove AppleDouble files from the icons directory
find /wp-content/themes/uniteus-sage/ -name '._*' -delete
