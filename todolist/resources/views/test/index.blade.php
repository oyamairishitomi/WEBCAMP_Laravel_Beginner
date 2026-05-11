@extends('test.layout')

@section('contents')
<h1>ログイン</h1>

@if ($errors->any())
  <div>
    @foreach ($errors->all() as $error)
      {{ $error }}<br>
    @endforeach
  </div>
@endif

   <form action="/test/input" method="post">
    @csrf
    email: <input type="text" name="email" value="{{ old('email') }}"><br>
    password: <input type="password" name="password"><br>
    <button>送信する</button>
  </form>
@endsection