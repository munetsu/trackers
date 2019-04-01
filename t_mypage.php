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
        exit();
    }else if($step == 3){
        // 審査通過者の初業務
        header('location: http://'.$_SERVER["HTTP_HOST"].'/trackers/t_howto.php?id='.$id);
        exit();
    }
    // else if($step == 2){
    // }else if($step != 99){
    //     echo 'ログイン上の問題が発生しました';
    //     exit();
    // }

    // VIEW読み込み
    include('mvc/view.php');
    $view = new VIEW;
    $viewCommon = $view->viewCommon();

    
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
    <div class="body"><?php echo $viewCommon ?></div>
    <script>
        let step = <?php echo $step ?>;
    </script>
    <script src="js/t_mypage.js"></script>
</body>
</html>