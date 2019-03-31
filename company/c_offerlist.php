<?php
    session_start();
    include('../funcs/funcs.php');
    chkSsid();

    // 申請中一覧
    include('c_model.php');
    $model = new C_MODEL;
    $table = 't_tuotors';
    $column = '*';
    $where = 'WHERE `step` = 10';
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
    <!-- jQuery本体-->
    <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
    <div>
        <?php echo $view ?>
    </div>
</body>
<script>
    let lists = <?php echo $lists ?>;
</script>
<script src="c_js/c_offerlist.js"></script>
</html>