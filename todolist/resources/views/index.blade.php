@extends('layout')

@section('contents')
<h1>ログイン</h1>
  <form action="/login" method="post">
    email: <input type="text" name="email"><br>
    password: <input type="password" name="password"><br>
    <button>ログインする</button>
  </form>
@endsection