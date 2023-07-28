<?php
session_start();

// 1. ログインチェック処理！
// 以下、セッションID持ってたら、ok
// 持ってなければ、閲覧できない処理にする。
if (!isset($_SESSION['chk_ssid']) || $_SESSION['chk_ssid'] !== session_id()) {
exit('LOGIN ERROR');
} else {
session_regenerate_id(true);
$_SESSION['chk_ssid'] = session_id();
}

//１．関数群の読み込み
require_once('funcs.php');
// 関数化して上の処理を使う
loginCheck();

//２．データ登録SQL作成
$pdo = db_conn();
$stmt = $pdo->prepare('SELECT * FROM contact_table');
$status = $stmt->execute();

//３．データ表示
$view="";
if ($status==false) {
    //execute（SQL実行時にエラーがある場合）
$error = $stmt->errorInfo();
exit("ErrorQuery:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる ※この部分を変えると変化する
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    // 管理者のみが見れるページにする 1が見れる　それ以外は見れない管理者フラグ
    if ($_SESSION['kanri_flg'] === 1){
    $view .= "<tr>";
    $view .='<td>'. h($result['date']) .'</td>'
    .'<td>'. h($result['name']).'</td>' .'<td>'.h($result['email']) 
    .'</td>'.'<td>'.h($result['age']).'</td>'.'<td>'.h($result['kikkake']).'</td>'
    .'<td>'.h($result['douki']).'</td>'.'<td>'.h($result['text']).'</td>';
    // クロスサイトスクリプティング対策
    $view .= '<td>'.'<a href="contact_delete.php?id='. $result['id'] .'">';
    $view .= '[削除]';
    $view .= '</a>'.'</td>';
    $view .= "</tr>";}
}
// sqlはギットハブにエクスポートしてファイルを挿入する
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tsuchiya Transport</title>
    <link rel="icon" type="img/ping" href="img/favicon.png">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/new.css">
</head>

<body>
    <!-- この中に記述していく -->
    <!-- ここから下にコードを書く -->
    <header>
        <div class="head">
            <h1>
                <a href="home.php"><img class="logo" src="img/tsuchiya_logo.png" alt="ロゴ写真"></a>
            </h1>
            <nav>
            <ul class="main-nav">
                <li><a href="home.php">HOME</a></li>
                <li><a href="select.php">運行集計表</a></li>
                <li><a href="select_driver.php">配車管理表</a></li>
                <li><a href="logout.php">LOGOUT</a></li>
            </ul>
            </nav>
        </div>
    </header>

    

    <!-- /#header -->

    <!-- コンテンツ部分 -->
    <main>
        <!-- コンタクト部分 -->
        <div class="contact ">
            <p>【募集管理表】</p>
        </div>
        <div class="setumeikai ">
            応募データ
        </div>
<div>
    <div class="view">
    <table>
        <tbody>
        <?= $view ?>
        </tbody>
    </table>
        </div>
</div>
<!-- Main[End] -->
<footer id="footer ">
    <div class="footer ">
        <p>copyrights since from 1976 Tsuchiya Transport Co., Ltd All RIghts Reserved.</p>
    </div>
</footer>

</body>
</html>