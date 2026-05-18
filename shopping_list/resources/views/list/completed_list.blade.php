@extends('layout')
@section('title') (詳細画面)@endsection

@section('contents')
          <h1>購入済み「買うもの」一覧</h1>
          <a href="/list">「買うもの」一覧に戻る</a>
    <table border="1">
      <tr>
      <th>「買うもの」名
      <th>購入日
      </tr>
        @foreach ($list as $item)
        <tr>
            <td>{{ $item->name }}
            <td>{{ $item->completed_at }}
        @endforeach

        </table>
        <!-- ページネーション -->
        現在 {{ $list->currentPage() }} ページ目<br>
        @if ($list->onFirstPage() === false)
        <a href="/task/list">最初のページ</a>
        @else
        最初のページ
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
        <a href="/logout">ログアウト</a><br>
        </menu>
@endsection