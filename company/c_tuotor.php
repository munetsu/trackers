<?php
    session_start();
    include('../funcs/funcs.php');
    chkSsid();

    // view取得
    // header部分
    include('c_view.php');
    $view = new C_VIEW;
    $headerView = $view->headerView();
    // sideBar部分
    $sideBar = $view->sideBar();
    // メイン部分
    $count = 0;

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
    <script src="c_js/c_tuotor.js"></script>
</head>
<body>
    <div>
        <!-- ヘッダー -->
        <?php echo $headerView; ?>
        <!-- サイドバー -->
        <?php echo $sideBar; ?>
        <!-- メイン部分 -->
        <div class="main">
            <div class="flex">
                <p class="list" id="beforeAjax">日程調整</p>
                <p class="list" id="interviewAjax">面談</p>
                <p class="list" id="tuotorListAjax">登録チューター一覧</p>
            </div>
            <div id="mainArea"></div>
        </div>
    </div>
</body>
</html>
