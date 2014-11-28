Referral Application


---
Apache2 Virtual Host

<VirtualHost *:80>
    ServerName micro.dev
    DocumentRoot <your_website_root>
    ErrorLog ${APACHE_LOG_DIR}/error.micro.log
    CustomLog ${APACHE_LOG_DIR}/access.micro.log combined

    <Directory <your_website_root>>
        Options All
        Order allow,deny
        Allow from all
        Require all granted
    </Directory>
    <Directory <your_website_root>/api>
        RewriteEngine On
        RewriteBase /api
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^(.*)$ index.php?_url=/$1 [QSA,L]
    </Directory>
</VirtualHost>
---