<?php
    session_start();
    include('funcs/funcs.php');
    chkSsid();

    $id = h($_GET['id']);
    include('mvc/model.php');
    $model = new MODEL;
    $column = '*';
    $where = 'WHERE tuotor_id ='.$id;
    $info = $model->t_tuotorsAnySelect($column, $where);
    // // // 不正ログインチェック
    if($_SESSION['security_code'] != $info['security_code']){
        echo 'ログイン上の問題が発生しました';
        exit();
    }

    $step = $info['step'];
    // 登録状況によって振り分け
    if($step == 1){
        header('location: http://'.$_SERVER["HTTP_HOST"].'/trackers/t_signUp2.php?id='.$id);
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
    <div>tuotor_mypage</div>
    <script ></script>
</body>
</html>