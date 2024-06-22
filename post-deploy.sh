#!/bin/bash

# Clear the view cache
wp acorn view:cache

# Remove AppleDouble files from the icons directory
find /wp-content/themes/uniteus-sage/resources/icons/acf/ -name '._*' -delete
