@extends('layout')

@section('contents')
@if($errors->has('auth'))
  {{ $errors->first('auth') }}
@endif
@if(session('front.user_register_success') == true)
  登録完了しました。
@endif
  <h1>ログイン</h1>
  <form action="/login" method="post">
    @csrf
    email：<input type="text" name="email"><br>
    パスワード：<input type="password" name="password"><br>
    <button>ログインする</button>
  </form>
  <a href="/register">会員登録</a>
@endsection