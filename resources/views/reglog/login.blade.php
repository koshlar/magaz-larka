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