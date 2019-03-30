<?php
    session_start();
    include('funcs/funcs.php');
    chkSsid();

    $id = $_GET['id'];
    include('mvc/model.php');
    $model = new MODEL;
    $column = 'security_code';
    $where = 'WHERE student_id ='.$id;
    $code = $model->s_studentsAnySelect($column, $where);

    // 不正ログインチェック
    if($_SESSION['security_code'] != $code['security_code']){
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
    <!-- jQuery本体-->
    <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
    <div>
        <!-- トップバー -->
        <div class="topbar">
            <!-- left -->
            <div class="left">
                <div class="logo">
                    <img src="img/logo.png">
                </div>
                <div class="search">
                    <ul class="certification"></ul>
                </div>
            </div>
            <!-- right -->
            <div class="right">
            </div>
        </div>
        <!-- メイン -->
        <div class="main">
        </div>
    </div>
</body>
</html>