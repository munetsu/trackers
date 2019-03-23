<?php
    session_start();
    include('funcs/funcs.php');
    chkSsid();

    $id = $_GET['id'];

    // modelへ引き継ぎ
    // 対象チューター情報取得
    include('mvc/model.php');
    $model = new MODEL;
    $column = 'security_code';
    $info = $model->tuotorInfo($id, $column);
    // var_dump($info);
    // var_dump($_SESSION['security_code']);

    // 不正ログインチェック
    if($_SESSION['security_code'] != $info['security_code']){
        echo '不正アクセスです';
        exit();
    }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
        mypage
</body>
</html>