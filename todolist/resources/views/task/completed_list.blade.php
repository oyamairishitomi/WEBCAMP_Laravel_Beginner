@extends('layout')
@section('title') (詳細画面)@endsection

@section('contents')
          <h1>タスクの完了一覧</h1>
        <table border="1">
        <tr>
            <th>タスク名
            <th>期限
            <th>重要度
        @foreach ($list as $task)
        <tr>
            <td>{{ $task->name }}
            <td>{{ $task->period }}
            <td>{{ $task->getPriorityString() }}
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