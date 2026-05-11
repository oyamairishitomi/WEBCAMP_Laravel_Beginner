@extends('test.layout');

@section('contents')
  email: {{ $datum['email'] }}<br>
  パスワード: {{ $datum['password' ]}}<br>
@endsection