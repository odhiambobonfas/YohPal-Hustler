#!/bin/bash
# HTTPS Server for YohPal Hustler

cd /home/wizarddev/Othina/Yohpal/YohPal-Hustler

# Start HTTPS server using stunnel
php -S 127.0.0.1:8000 > server.log 2>&1 &
PHP_PID=$!

# Create stunnel config
cat > stunnel.conf << EOF
[https]
accept = 0.0.0.0:8443
connect = 127.0.0.1:8000
cert = /home/wizarddev/Othina/Yohpal/YohPal-Hustler/cert.pem
key = /home/wizarddev/Othina/Yohpal/YohPal-Hustler/key.pem
EOF

# Start stunnel
stunnel stunnel.conf

echo "HTTPS Server started!"
echo "Local: https://localhost:8443"
echo "Network: https://192.168.1.196:8443"
echo ""
echo "⚠️  IMPORTANT: You'll see a security warning on your phone."
echo "This is normal for self-signed certificates."
echo "Tap 'Advanced' then 'Proceed anyway' to continue."
