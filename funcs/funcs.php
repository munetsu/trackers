<?php
/** 共通で使うものを別ファイルにしておきましょう。*/

// //DB接続関数（PDO）
// function db_con(){
//   $dbname='trackers';
//   $id='root';
//   $pw='';
//   try {
//     $pdo = new PDO('mysql:dbname='.$dbname.';charset=utf8;host=localhost',$id,$pw);
//   } catch (PDOException $e) {
//     exit('DbConnectError:'.$e->getMessage());
//   }
//   return $pdo;
// }

//SQL処理エラー
// function queryError($stmt){
//   //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
//   $error = $stmt->errorInfo();
//   exit("QueryError:".$error[2]);
// }

//クリックジャッキング対策
header('X-FRAME-OPTIONS: SAMEORIGIN');

/**
* XSS
* @Param:  $str(string) 表示する文字列
* @Return: (string)     サニタイジングした文字列
*/
function h($str){
  return htmlspecialchars($str, ENT_QUOTES, "UTF-8");
}

function chkSsid(){
  if(!isset($_SESSION["chk_ssid"]) ||
  $_SESSION["chk_ssid"] != session_id()
  ){exit("LOGIN ERROR");
  }else{
    session_regenerate_id(true);
    $_SESSION["chk_ssid"] = session_id();
  }
}

// JSON_ENCODE
function json($array){
  $array = JSON_ENCODE($array,JSON_UNESCAPED_UNICODE);
  return $array;
}


?>
