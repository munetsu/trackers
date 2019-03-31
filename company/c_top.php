<?php
    session_start();
    include('../funcs/funcs.php');
    chkSsid();

    // 申請中リスト件数
    include('c_model.php');
    $model = new C_MODEL;
    $col = 'step';
    ///////////////////////////////////////////////////
    // tuotorSide
    //////////////////////////////////////////////////
    // チューター登録
    $table = 't_tuotors';
    $num = $model->countGroupBy($table, $col);
    $num = JSON_ENCODE($num,JSON_UNESCAPED_UNICODE);
    // 勉強法確認
    $table = 't_howtos';
    $col = 'agree';
    $howtoNum = $model->countGroupBy($table, $col);
    $howtoNum = JSON_ENCODE($howtoNum,JSON_UNESCAPED_UNICODE);



    // 共通VIEW部分の読み込み
    include('c_view.php');
    $view = new C_VIEW;
    $view = $view->viewCommon();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- jQuery本体-->
    <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
    <?php echo $view ?>
    <script>
        let num = <?php echo $num ?>;
        let howtoNum = <?php echo $howtoNum ?>;
    </script>
    <script src="c_js/c_top.js"></script>
</body>
</html>