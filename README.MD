package ini memerlukan tsung/nova-user-management minimal versi 0.0.12

install nova-master

install package melalui folder
```
composer config repositories.nova-master path [PACKAGE_PATH]
composer require tsung/nova-master=@dev
```

install package melaluia composer
```
composer require tsung/nova-master
```

jalankan perintah ini setelah package berhasil di install
```
php artisan migrate
php artisan novamaster:install
```

