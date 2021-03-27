<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\Mysql;

class AuthController extends Controller
{
  public function login(Request $request)
  {
      return view('auth.login');
  }

  public function logout(Request $request)
  {
      \Auth::logout();
      setcookie("id", '');
      setcookie("name", '');
      setcookie("role", '');
      return view('auth.login');
  }

  public function loginValidation(Request $request)
  {
    
    $mysql = new Mysql;
    $user = $mysql->select('users', '*', ['email' => addslashes($request->email)]);

    if(isset($user[0]) && password_verify($request->password , $user[0]['password'])){
      \Auth::loginUsingId($user[0]['id']);
      setcookie("name", $user[0]['name']);
      setcookie("role", $user[0]['role']);
      


      if ($user[0]['role'] === 'admin'){
        
        return redirect()->route('admin.index')->withCookie(cookie('id', $user[0]['id'],  3600000));
      }else{
        return redirect()->route('home')->withCookie(cookie('id', $user[0]['id'],  3600000));
      }
    }

    return back()->withErrors(['login' => 'Les identifiants fournis ne correspondent pas à nos données']);
  }
}
