# 2пр Авторег

1) Обновить файл миграции для таблицы `users` (`database/migrations/..._create_users_table.php`)

```php
...
public function up(): void
  {
    Schema::create('users', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('surname');
      $table->string('patronymic');
      $table->string('login')->unique();
      $table->date("bday");
      $table->string('email')->unique();
      $table->timestamp('email_verified_at')->nullable();
      $table->string('password');
      $table->rememberToken();
      $table->timestamps();
    });
...
```

2) На странице регистрации (`resources/views/reglog/register.blade.php`) сверстать скелет формы

```html
...
<div class="container">
  <form action="/register" method="post">
    @csrf

    <button type="submit">
      Отправить форму
    </button>
  </form>
</div>
...
```

3) Создать файл `input.blade.php` для компонента `input` в папке `resources/views/components`

4) Написать код для компонента `input`

```html
<div class="input_container">
  <label for="{{$name}}">{{$placeholder}}</label>
  <input id="{{$name}}" type="{{$type ?? 'text'}}" name="{{$name}}" value="{{@old($name)}}" placeholder="{{$placeholder}}">
  <!-- Отображение ошибки -->
  @error($name)
  <p class="error">{{$message}}</p>
  @enderror
</div>
```

5) Подключить компонент `input` в форму и заполнить параметры для поля с именем

```html
...
<div class="container">
  <form action="/register" method="post">
    @csrf
    @include('components.input', ['name' => 'name', 'placeholder' => 'Имя'])
    ...
```

6) Продублировать подключение компонента `input` с помощью клавиш `Shift`+`Alt`+`Стрелка вниз` и заполнить параметры для остальных полей

```html
...
<div class="container">
  <form action="/register" method="post">
    @csrf
    @include('components.input', ['name' => 'name', 'placeholder' => 'Имя'])
    @include('components.input', ['name' => 'surname', 'placeholder' => 'Фамилия'])
    @include('components.input', ['name' => 'patronymic', 'placeholder' => 'Отчество'])
    @include('components.input', ['name' => 'login', 'placeholder' => 'Логин'])
    @include('components.input', ['type' => 'date', 'name' => 'bday', 'placeholder' => 'День рождения'])
    @include('components.input', ['type' => 'email', 'name' => 'email', 'placeholder' => 'Электронная почта'])
    @include('components.input', ['type' => 'password', 'name' => 'password', 'placeholder' => 'Пароль'])
    @include('components.input', ['type' => 'password', 'name' => 'password_confirmation', 'placeholder' => 'Пароль ещё раз'])
    <button type="submit">
      Отправить форму
    </button>
  </form>
</div>
...
```

7) В файле модели `User` (`app/Models/User.php`) заменить поле `$fillable` на поле `$guarded` со значением пустого массива (`[]`):

```php
protected $fillable = [
  'name',
  'email',
  'password',
];
```

на

```php
protected $guarded = [];
```

В будущем делать так во всех моделях (только `$guarded`, никакого `$fillable`)

8) Создаём контроллер регистрации и авторизации

```bash
php artisan make:controller RegLogController
```

9) Пишем роуты для регистрации и оборачиваем их в middleware `guest` (`routes/web.php`). Подключаем `RegLogController` при post запросе по адресу `/register`

```php
...
Route::middleware('guest')->group(function () {
  Route::get('/register', function () {
    return view('reglog.register');
  });
  Route::post('/register', [RegLogController::class, 'register']);
});
...
```

10) Создаём публичную функцию `register` в `RegLogController`

```php
...
public function register(Request $request)
{
}
...
```

11) Пишем валидацию для регистрации

```php
...
use Illuminate\Validation\Rules\Password;
...
public function register(Request $request)
{
  $request->validate([
    'name' => 'required|min:2',
    'surname' => 'required|min:2',
    'patronymic' => 'required|min:2',
    'login' => 'required|min:5|unique:users,login',
    'bday' => 'required',
    'email' => 'required|email|unique:users,email',
    'password' => [
      'required',
      Password::min(6)
        ->letters()
        ->numbers()
        ->symbols()
        ->mixedCase()
    ],
  ]);
...
```

12) Пишем код для создания новой записи в таблице БД `users`. Для этого, как и в будущем, используем модель. В данном случае это `User` (`use App\Models\User`)

```php 
User::create([
  'name' => $request->name,
  'surname' => $request->surname,
  'patronymic' => $request->patronymic,
  'login' => $request->login,
  'bday' => $request->bday,
  'email' => $request->email,
  // Хешируем пароль
  'password' => bcrypt($request->password),
]);
```

13) Добавляем авторизацию в новосозданный аккаунт

```php
...
// Если вошёл
if (Auth::attempt($request->only(['email', 'password']))) {
  return redirect('/');
}
// Если не вошёл
return redirect()
  ->back()
  ->withErrors(['email' => 'Email или пароль неверный'])
  ->withInput();
```

14) Тестируем. Должна создаваться запись в бд

15) Добавляем кнопки на главную

```
...
<!-- Если пользователь авторизован, то ему покажут эти кнопки -->
@auth
<form action="/logout" method="post">
  @csrf
  <button type="submit">
    Выйти из аккаунта
  </button>
</form>
<!-- Если нет, то эти -->
@else
<a href="/register">Register</a>
<a href="/login">Login</a>
@endauth
...
```

16) Копируем код из файла с регистрацией и вставляем в файл с авторизацией (`login.blade.php`)

```html
<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <title>Вход</title>
</head>

<body>
  <h1>Вход</h1>
  <div class="container">
    <form action="/login" method="post">
      @csrf
      @include('components.input', ['type' => 'email', 'name' => 'email', 'placeholder' => 'Электронная почта'])
      @include('components.input', ['type' => 'password', 'name' => 'password', 'placeholder' => 'Пароль'])
      <button type="submit">
        Отправить форму
      </button>
    </form>
  </div>
</body>

</html>
```

17) Добавляем роуты для входа (`/login`) и выхода (`/logout`) из аккаунта в файл `web.php`

```php
...
Route::middleware('guest')->group(function () {
  Route::get('/login', function () {
    return view('reglog.login');
  })->name('login');
  Route::post('/login', [RegLogController::class, 'login']);

  Route::get('/register', function () {
    return view('reglog.register');
  });
  Route::post('/register', [RegLogController::class, 'register']);
});

Route::middleware('auth')->group(function () {
  Route::post('/logout', [RegLogController::class, 'logout']);
});
```

18) Добавляем функцию входа в `RegLogController`. По факту, это урезанная функция `register`

```php
...
public function login(Request $request)
{
  $request->validate([
    'email' => 'required|email|exists:users,email',
    'password' => 'required',
  ]);

  // Если вошёл
  if (Auth::attempt($request->only(['email', 'password']))) {
    return redirect('/');
  }
  // Если не вошёл
  return redirect()
    ->back()
    ->withErrors(['email' => 'Email или пароль неверный'])
    ->withInput();
}
...
```

19) Добавляем функцию `logout` в `RegLogController` для выхода из аккаунта

```php
...
public function logout(Request $request)
{
  Auth::logout();
  $request->session()->invalidate();
  $request->session()->regenerateToken();
  return redirect('/');
}
...
```

20) Добавляем чутка стилей, чтобы не резало глаза
```css
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif
}

html {
  font-size: 16px;
}

h1 {
  font-weight: 600;
}

p {
  font-weight: 400;
}

button,
a.btn {
  padding: 0.5rem 1.25rem;
  border: none;
  border-radius: 0.25rem;
}

/* input component */
.input_container {
  width: fit-content;
  display: flex;
  flex-direction: column;
  gap: 0.25rem;
}

.input_container input {
  width: 100%;
}

.input_container label {
  font-weight: 500;
}

.input_container p {
  color: red;
  font-size: 0.85rem;
}

.input_container+.input_container {
  margin-top: 0.45rem;
}

.input_container+button[type="submit"] {
  margin-top: 1.25rem;
}
```