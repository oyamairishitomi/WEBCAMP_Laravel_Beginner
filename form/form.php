<?php
function h(string $s) : string
{
  return htmlspecialchars($s, ENT_QUOTES);
}

$input = $_GET['input_text'] ?? "";

echo "あなたが入力したのは" . h($input) . "ですね";