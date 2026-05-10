<?php
function h(string $s) : string{
  return htmlspecialchars($s, ENT_QUOTES);
}

$html_form_params = [
  "pw" => "パスワード",
  "radio_a" => "ラジオボタン",
    "check" => "チェックボックス",
    "sele" => "セレクトボックス",
    "tarea" => "テキストエリア",
    "hide" => "隠れた入力(hidden)",
];

$datum = [];
foreach($html_form_params as $name => $type){
  $datum[$name] = $_POST[$name] ?? "";
}

var_dump($datum);