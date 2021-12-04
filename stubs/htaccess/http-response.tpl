# BM HTTP Response Headers
Header always set X-Frame-Options "SAMEORIGIN"
Header always set X-Xss-Protection "1; mode=block"
Header always set X-Content-Type-Options "nosniff"
Header set Strict-Transport-Security "max-age=10886400; preload"
Header set Referrer-Policy "no-referrer-when-downgrade"
# BM HTTP Response Headers END
