<?php

/**
 * 1. index.phpのフォームの部分がおかしいので、ここを書き換えて、
 * insert.phpにPOSTでデータが飛ぶようにしてください。
 * 2. insert.phpで値を受け取ってください。
 * 3. 受け取ったデータをバインド変数に与えてください。
 * 4. index.phpフォームに書き込み、送信を行ってみて、実際にPhpMyAdminを確認してみてください！
 */

//1. POSTデータ取得 = $～ =
$date = $_POST['date'];
$driver_name = $_POST['driver_name'];
$company_name = $_POST['company_name'];
$client = $_POST['client'];
$tell = $_POST['tell'];
$start_place = $_POST['start_place'];
$end_place = $_POST['end_place'];
$item = $_POST['item'];
$price = $_POST['price'];
$receipt = $_POST['receipt'];


//2. DB接続します
try {
  //ID:'root', Password: xamppは 空白 ''
  $pdo = new PDO('mysql:dbname=tsuchiya_transport;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DBConnectError:'.$e->getMessage());
}

//３．データ登録SQL作成

// 1. SQL文を用意
$stmt = $pdo->prepare("INSERT INTO 
              gs_bm_table(id,date,driver_name,company_name,client,tell,start_place,end_place,item,price,receipt
                  ) VALUES (NULL, :date ,:driver_name, :company_name, :client, :tell, :start_place, :end_place, :item, :price ,:receipt )");

//  2. バインド変数を用意
// Integer 数値の場合 PDO::PARAM_INT
// String文字列の場合 PDO::PARAM_STR

$stmt->bindValue(':date', $date, PDO::PARAM_STR);
$stmt->bindValue(':driver_name', $driver_name, PDO::PARAM_STR);
$stmt->bindValue(':company_name', $company_name, PDO::PARAM_STR);
$stmt->bindValue(':client', $client, PDO::PARAM_STR);
$stmt->bindValue(':tell', $tell, PDO::PARAM_STR);
$stmt->bindValue(':start_place', $start_place, PDO::PARAM_STR);
$stmt->bindValue(':end_place', $end_place, PDO::PARAM_STR);
$stmt->bindValue(':item', $item, PDO::PARAM_STR);
$stmt->bindValue(':price', $price, PDO::PARAM_INT);
$stmt->bindValue(':receipt', $receipt, PDO::PARAM_STR);

//  3. 実行
$status = $stmt->execute();

//４．データ登録処理後
if($status === false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit('ErrorMessage:'.$error[2]);
}else{
  //５．登録が完了した後の処理　index.phpへリダイレクト
header('Location: index.php');

}
?>
