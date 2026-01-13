<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <title>Регистрация</title>
</head>

<body>
  <h1>Регистрация</h1>
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
</body>

</html>