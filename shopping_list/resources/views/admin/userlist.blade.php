@extends('layout')

@section('contents')
<a href="/admin/top">管理画面TOP</a><br>
<a href="/admin/list">ユーザ一覧</a><br>
<a href="/admin/logout">ログアウト</a><br>
<h1>ユーザ一覧</h1>
<table border="1">
  <th>ユーザID
  <th>ユーザ名
  <th>購入した「買うもの」の数</th>
      @foreach ($users as $user)
      <tr>
      <td>{{ $user-> id }}</td>
      <td>{{ $user -> name }}</td>
      <td>{{ $user -> item_count }}</td>
      @endforeach
  </table>
        <br>
        <a href="/admin/logout">ログアウト</a>
@endsection