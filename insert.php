<?php
session_start();
//1. POSTデータ取得
$seki_syubetu  = $_POST["seki_syubetu"];
$formattedDate = $_POST["formattedDate"];


//2. DB接続します(エラー処理追加)
include("funcs.php");
$pdo = db_conn();

//３．データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO zaseki(seki_syubetu, date, indate )VALUES(:seki_syubetu, :date, sysdate())");
$stmt->bindValue(':seki_syubetu', $seki_syubetu);
$stmt->bindValue(':date', $formattedDate);
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  echo "false";
  redirect("buy_success.php");
}else{
  echo "true";
  redirect("buy_success.php");
}
redirect("buy_success.php");
?>
