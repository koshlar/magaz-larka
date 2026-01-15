# 1пр Старт работы в Laravel

## 1. Кратко про Laravel

Laravel - это MVC фреймворк на PHP с простой консольной утилитой artisan. Для Laravel нужна самые базовые знания PHP (переменные, база ООП, функции, типы данных, работа со строками, динамические страницы, разделение на роли, базовая работа с PDO). В Laravel уже всё прописано, по факту, осталось прописать саму логику приложения (что куда должно скинуться, что где должно на странице отобразиться и т.п.).

### Архитектура Laravel приложения (MVC):
1. Models (Модели) - представления объектов БД (пользователь, товар, категория товара, корзина и т.п.) и миграции (описание таблиц БД в виде удобного кода с возможностью быстро развернуть и обновить БД). Хранятся в папке `app/models`;
2. Views (Представления) - то, что видит пользователь (вёрстка страницы). В Laravel строить страницы помогает шаблонизатор blade. Хранятся в папке `resources/views`;
3. Controllers (Контроллеры) - то, что связывает Model и View и выполняет все манипуляции с данными (CRUD). Вся основная логика написана там. Хранятся в папке `app/Http/Controllers`;

Чтобы легко писать приложения на Laravel нужно знать:

1. что писать и в какой файл;
2. где хранить картинки;
3. какие команды выполнять, чтобы создать контроллер, модель, миграцию или и вовсе всё вместе одной командой;
4. скелет для CRUD.

### Основные папки и файлы

Здесь я выделил основные файлы, на которые нужно сделать акцент (выделены светло-серым цветом):

<img width="543" height="1238" alt="image" src="https://github.com/user-attachments/assets/b7053df7-0575-4ecb-87e1-610d0d4c98b1" />

Давайте подробнее:

1) `app/` - главная папка с backend-логикой приложения;
    1) `Http/` - папка для всех Controller и для Middleware (страж, который решает, пройдёт ли запрос дальше или будет отклонён и что будет в обоих случаях);
    2) `Models/` - папка со всеми Model;
2) `database/` - всё, что связано со структурой БД;
3) `public/` - папка, которую видит браузер при запуске проекта;
4) `resources/` - папка, где хранится папка `views/` со всеми View и содержатся вспомогательные папки;
5) `routes/` - папка, в которой хранится файл `web.php`, который содержит все роуты (по какому URL и с каким REST методом будет вызываться какой-либо обработчик события (функция или метод какого-либо Controller));
6) `storage/` - папка, где в подпапке `public/` будут храниться все загружаемые файлы;
7) `.env` - файл с настройками конфигурации проекта. В большинстве случаев только для настройки подключения к БД;

## 2. Создайте пустой проект

Вкратце нам нужно:
1. скачать php и composer;
2. создать пустой проект Laravel через composer;
3. скачать пакеты через `composer update`;
4. настроить подключение к БД;
5. выполнить миграцию;
6. запустить проект через `php artisan serve`; 

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

4) Запустите проект

```Bash
php artisan serve
```

Вы должны видеть следующую страницу (на Laravel 12):

<img width="2553" height="1322" alt="image" src="https://github.com/user-attachments/assets/e1b0ef0d-8e3a-49c0-aa29-bd4ac609c810" />

## 3. Создайте новые страницы и пропишите роуты

Чтобы прописать новые страницы нам нужно:
1. создать новые View и изменить имеющиеся;
2. прописать роуты для этих страниц с REST методом GET;
3. прописать базовый HTML код на страницах (чтобы визуальнр пометить их);
4. подключить css на страницы.

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

2) Создайте страницы для каталога, входа и регистрации и пропишите любой HTML-код внутри

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
