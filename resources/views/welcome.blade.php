<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <title>Document</title>
</head>

<body>
  <a href="/">Home</a>
  <a href="/catalog">Catalog</a>
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
  <h1>Hello world!</h1>
</body>

</html>