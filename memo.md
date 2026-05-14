ファイル名の前の ./ は、「自分自身のファイル（今回の場合はform.html）と同じディレクトリ」の意味になります。

かつては「echo $_GET['input_text'];」などというコードが書かれていたことがありました。これは「ぜったいに、絶対に、ゼッタイに書いてはいけないコード」です（大事なことなので3回書きました）。
なぜならば、脆弱性の原因（クロスサイトスクリプティングcross site scripting / XSS）になってしまうからです。

```
<?php
function h(string $s) : string
{
  return htmlspecialchars($s, ENT_QUOTES);
}

$input = $_GET['input_text'];

echo "あなたが入力したのは" . h($input) . "ですね";
```

その違反とは、「setcookie()関数（や他のいくつかの関数）より前に、echoやvar_dumpなどで出力をしてはいけない」というルールです。

このルールにも例外があって、ob_start()関数（と、ob_end_flush()関数）を使うと、今回のエラーを回避できます。

このob_start() 関数等を、出力バッファリング制御と言います。

（バッファリングという言葉は「どこかに一時的にためておく」といった意味合いになります。）

コードを書いて動かしてみましょう。

ここでは、「stcookie()関数などを使うときは、プログラムの先頭で ob_start()関数を呼び出し、プログラムの最後で ob_end_flush()関数を呼び出す」というルールを覚えておくと、どんな環境でも問題が起きないコードを書けるようになります。

コンストラクタは「newをしたときに自動で動くメソッド」であり、デストラクタも「プログラムが終わるとき（正確にはそのインスタンスが消えるとき）に自動で動くメソッド」だからです。

sudo systemctl start mariadb
「エラー表示」は、以下のようなコードを書きます。

テンプレートでのエラーの表示の書式
@foreach ($errors->all() as $error)
    {{ $error }}<br>
@endforeach
「エラーがあるかどうか？」を把握したい場合は、以下の書式で判定できます。

テンプレートでのエラーの表示の書式
@if ($errors->any())
    エラーがあるよ<br>
@endif


where() の引数

->where('user_id', Auth::id())
引数	意味
第1引数 'user_id'	カラム名
第2引数 Auth::id()	比較する値
デフォルトで =（イコール）で比較します。SQLに直すと WHERE user_id = 1 になります。

> や < で比較したい場合は第2引数に演算子を挟んで3つ書きます。


->where('priority', '>=', 2)  // WHERE priority >= 2
get() の出どころ
get() は LaravelのEloquent（ORM）が用意しているメソッドです。

TaskModel::where(...) の時点ではまだSQLを組み立てている途中で、DBには問い合わせていません。最後に get() を呼んで初めてSQLを実行してデータを取得します。


TaskModel::where('user_id', Auth::id())  // WHERE句を組み立て中
         ->orderBy('priority', 'DESC')   // ORDER BY を追加中
         ->get();                         // ここで初めてSQL実行
だから toSql() で確認したときも、get() の代わりに toSql() を呼ぶと「組み立てたSQL文字列」が取れたわけです。

クラスの定数は クラス名::定数名 という書き方で外から参照できます。


Task::PRIORITY_VALUE        // → [1 => '低い', 2 => '普通', 3 => '高い']
今回は use App\Models\Task as TaskModel; で Task に TaskModel という別名をつけているので、


TaskModel::PRIORITY_VALUE   // → [1 => '低い', 2 => '普通', 3 => '高い']
と書けるわけです。:: はインスタンスを作らずにクラスのメソッドや定数に直接アクセスするときに使う記号です。

guarded / fillable が必要な理由 — create() はマスアサインメント脆弱性対策のためどちらかの設定が必要

'front.task_register_success' はどこで指定しているか — 自分で決めたキー名で、Controllerでセット・Bladeで同じキー名で取り出す

where() の2つの引数の意味 — 第1引数がカラム名、第2引数が比較する値でデフォルトはイコール

get() はどこから来たのか — LaravelのEloquentが用意しているメソッドで、呼んで初めてSQLが実行される

定数をクラスの外に書いてしまった — クラス定数はクラスの中に書かないと $this::定数名 で参照できない

各メソッドの意味：

メソッド	意味
currentPage()	現在のページ番号
onFirstPage()	最初のページかどうか（true/false）
previousPageUrl()	前のページのURL（なければnull）
nextPageUrl()	次のページのURL（なければnull）
/task/list と /task/register は先頭が /task で共通しているので、prefix でグループ化しながら詳細閲覧のルートも追加します。


Route::middleware(['auth'])->group(function () {
    Route::prefix('/task')->group(function () {
        Route::get('/list', [TaskController::class, 'list']);


できた。ところで、task/listでいけるときと、task.listにしないといけないときのちがいってなに
いい気づきです。

/task/list（スラッシュ区切り） → URL


return redirect('/task/list');
ブラウザのアドレスバーに入力するURLそのものです。

task.list（ドット区切り） → テンプレートファイルのパス


return view('task.list', [...]);
resources/views/ 以下のファイルパスをドットで表したものです。


resources/views/task/list.blade.php
                 ↓
              task.list
ディレクトリの / がドット . に変わっているだけです。

まとめると：

書き方	用途	例
/task/list	URL（ブラウザのアドレス）	redirect('/task/list')
task.list	テンプレートファイルのパス	view('task.list')
全然別の話なので混同しないように注意です。


route('ルート名', ['パラメータ名' => 値])
それぞれ web.php の記述と対応しています。


// web.php
Route::get('/detail/{task_id}', ...)->name('detail');
//                  ↑パラメータ名          ↑ルート名

// テンプレート
route('detail', ['task_id' => $task->id])
//      ↑ルート名   ↑パラメータ名   ↑値
パラメータが不要なルートは第2引数を省略できます。


route('front.index')  // パラメータなし
パラメータが複数あれば配列に追加するだけです。


route('example', ['id' => 1, 'page' => 2])
つまり 「name()で付けた名前」と「{}で定義したパラメータ名」 の2つを把握していれば書けます。



Q.テンプレートファイルのときだけ.にするということか？