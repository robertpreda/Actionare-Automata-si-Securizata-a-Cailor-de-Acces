#!/bin/bash
echo "ceva"
avconv -f video4linux2 -s vga -i /dev/video0 -vframes 1 /var/www/test/img/_1436352508.jpg
echo "ceva1"
