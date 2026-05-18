<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<h1>ユーザ登録</h1>
@if($errors->any())
  <ul>
    @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
  </ul>
@endif

<form action="/register" method="post">
  @csrf
    名前：<input type="text" name="name"><br>
    email：<input type="text" name="email"><br>
    パスワード：<input type="password" name="password"><br>
    パスワード（再度）：<input type="password" name="password_confirmation"><br>
    <button>登録する</button>
  </form>
</body>
</html>