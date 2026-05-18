@extends('layout')

@section('contents')
  <h1>「買うもの」の登録</h1>
  @if($errors->has('name'))
    {{ $errors->first('name') }}
  @endif
  <form action="/list/register" method="post">
    @csrf
    「買うもの」名：<input type="text" name="name" value="{{ old('name') }}"><br>
    <button>「買うもの」を登録する</button>
  </form>

  <h1>「買うもの」一覧</h1>
  <a href="/completed/list">購入済み「買うもの」一覧</a>
    <table border="1">
      <tr>
      <th>登録日
      <th>「買うもの」名
      <th>
      <th>
      </tr>

      @foreach ($list as $item)
      <tr>
      <td>{{ $item-> created_at }}</td>
      <td>{{ $item -> name }}</td>
      <td><form action="{{ route('complete', ['id' => $item->id]) }}" method="post">
          @csrf
          <button onclick='return confirm("このタスクを「完了」にしていいですか？")'>完了</button></form></td>
      <td><form action="{{ route('delete', ['id' => $item->id]) }}" method="post">
          @csrf
          @method('DELETE')
          <button onclick='return confirm("このタスクを「削除」していいですか？")'>削除</button></form></td>
      </tr>
      @endforeach
  </table>
              <!-- ページネーション -->
        現在 {{ $list->currentPage() }} ページ目<br>
        @if ($list->onFirstPage() === false)
        <a href="/list">最初のページ</a>
        @else
        <a href="/list">最初のページ</a>
        @endif
        /
        @if ($list->previousPageUrl() !== null)
            <a href="{{ $list->previousPageUrl() }}">前に戻る</a>
        @else
            前に戻る
        @endif
        /
        @if ($list->nextPageUrl() !== null)
            <a href="{{ $list->nextPageUrl() }}">次に進む</a>
        @endif
        <br>
        <a href="/logout">ログアウト</a>
  @endsection