# 1пр Старт работы в Laravel

1) Поставьте проект Laravel и все зависимости

```bash
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows/8.4'))

mkdir ~/Laravel

cd ~/Laravel

composer create-project laravel/laravel magaz-larka

cd magaz-larka

composer update
```

2) Настройте подключение к бд в файле `.env`. Файл найдите с помощью комбинации клавиш `Ctrl+p`

```.env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=magaz_larka
DB_USERNAME=root
DB_PASSWORD=
```

3) Выполните миграцию БД

```bash
php artisan migrate
```

4) Измените код домашней страницы (resources/views/welcome.blade.php)

```html
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <h1>Home page</h1>
</body>

</html>
```

5) Создайте страницы для каталога, входа и регистрации
```bash
/
└── resources/
    └── views/
        ├── products/
        │   └── catalog.blade.php
        ├── reglog/
        │   ├── register.blade.php
        │   └── login.blade.php
        └── welcome.blade.php
```
6) Настройте роуты в файле routes/web.php

```php
...
Route::get('/', function () {
  return view('welcome');
});
Route::get('/catalog', function () {
  return view('products.catalog');
});
Route::get('/login', function () {
  return view('reglog.login');
});
Route::get('/register', function () {
  return view('reglog.register');
});
...
```

7) Подключите css (css должен быть в папке public/assets/css/style.css)

```html
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
```
