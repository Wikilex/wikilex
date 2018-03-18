#!/bin/bash -e

find . -not -path './.git' -name .git -type d -prune -exec rm -r {} +