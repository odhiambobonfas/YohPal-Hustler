#!/bin/bash

echo "Starting YohPal Hustler Server..."
echo "Access from your phone at: http://192.168.1.196:8000"
echo "Press Ctrl+C to stop the server"
echo ""

php -S 0.0.0.0:8000 -t .
