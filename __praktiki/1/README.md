# 1пр Старт работы в Laravel

## 1. Кратко про Laravel

Laravel - это MVC фреймворк на PHP с простой консольной утилитой artisan. Для Laravel нужна самые базовые знания PHP (переменные, база ООП, функции, типы данных, работа со строками, динамические страницы, разделение на роли, базовая работа с PDO). В Laravel уже всё прописано, по факту, осталось прописать саму логику приложения (что куда должно скинуться, что где должно на странице отобразиться и т.п.).

Архитектура простая

Чтобы легко писать приложения на Laravel нужно знать:

1. в какой файл что писать;
2. где хранить картинки;
3. какие команды выполнять, чтобы создать контроллер, модель, миграцию или и вовсе всё вместе;
4. скелет для CRUD.

## 2. Создайте пустой проект

1) Откройте powershell от имени администратора и выполните команду ниже:

```bash
# Скачиваем php, composer
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows/8.4'))

# Создаём папку Laravel в домашней папке пользователя
mkdir ~/Laravel

# Переходим в домашнюю папку пользователя
cd ~/Laravel

# Создаём проект Laravel
composer create-project laravel/laravel test --prefer-dist --no-interaction

# Переходим в папку проекта
cd magaz-larka

# Скачиваем пакеты в проекте
composer update
```

У вас должна создаться папка Laravel в домашней папке пользователя (`C:/Users/%USERNAME%/Laravel/magaz-larka` на Windows).

2) Настройте подключение к бд в файле `.env`. Файл найдите с помощью комбинации клавиш <kbd>Ctrl</kbd>+<kbd>p</kbd>

> ❗ БД создавать не нужно!

```.env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=magaz_larka
DB_USERNAME=root
DB_PASSWORD=
```

3) Выполните миграцию БД

Так как у нас по идее нет этой БД и миграции не выполнялись, выполняем следующую команду:

```bash
php artisan migrate
```

Если он спросит, нужно ли создавать БД, напишите `yes`:

<img width="1035" height="246" alt="image" src="https://github.com/user-attachments/assets/7a728de3-e010-4357-b370-6b5d515a3a78" />

Если всё ок, то вы увидите следующую картину:

<img width="1583" height="420" alt="image" src="https://github.com/user-attachments/assets/4e52428e-7148-41a4-a1ce-bc906f1cb10f" />

Если вы видите следующее (или ошибку), значит миграция уже выполнена, т.е. вы ничего не сделали. 

<img width="1070" height="132" alt="image" src="https://github.com/user-attachments/assets/daf25602-891e-47cb-b2cd-a905d4c7e75a" />

Так как у нас нет важных данных в бд, то мы просто снесём все таблицы, а затем поставим их заново одной командой:

```Bash
php artisan migrate:refresh
```

Должен быть следующий вывод в консоль:

<img width="1967" height="472" alt="image" src="https://github.com/user-attachments/assets/c9df31b9-3d66-443d-b9e5-304eb62b8b5b" />

## 3. Создайте страницы 

Теперь поработаем с Views 

1) Измените код домашней страницы (`resources/views/welcome.blade.php`)

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

2) Создайте страницы для каталога, входа и регистрации
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

3) Настройте роуты в файле routes/web.php

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

4) Подключите css (css должен быть в папке public/assets/css/style.css)

```html
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
```
