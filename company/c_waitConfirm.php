<?php
    session_start();
    include('../funcs/funcs.php');
    chkSsid();

    // 承認待ち勉強法取得
    include('c_model.php');
    $model = new C_MODEL;
    $table = 't_howtos';
    $column = '*';
    $where = 'WHERE `agree` = 1';
    $lists = $model->selectFree($table, $column, $where);
    $lists = json($lists);

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
    <link rel="stylesheet" href="../css/reset.css">
    <!-- jQuery本体-->
    <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
    <?php echo $view ?>
</body>
<script>
    let lists = <?php echo $lists ?>;
</script>
<script src="c_js/c_waitConfirm.js"></script>
</html>