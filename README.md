# SHPP BOOK LIBRARY


## Getting Started:
### Requires:
- PHP 8.0.8
- MySql 5.7.34
- Nginx

### Server configuration
Nginx example:
```
server {
    listen 80;

    server_name task3.com;

    root /var/www;

    index /public/index.php;

    location / {
        try_files $uri $uri/ /public/index.php?$args;
    }

    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass php:9000;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param PATH_INFO $fastcgi_path_info;
    }
}
```

### Installing
1. Copy the repository to root folder of yours server.
2. Set up a server.
3. Create a database.
4. Set your database details in the config file config.json.
5. Run migrations.
```
php migrations/migration.php
```
6. Add admin.
```
php scripts/addAdmin.php
```
7. Add to Cron:
   -scripts/backupDB.php
   -scripts/clearDeletedBooks.php


