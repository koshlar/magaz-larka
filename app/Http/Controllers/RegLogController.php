<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// Для валидации пароля
use Illuminate\Validation\Rules\Password;

class RegLogController extends Controller
{
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

  public function logout(Request $request)
  {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
  }
}
