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
    
    // VIEW読み込み
    include('mvc/view.php');
    $view = new VIEW;
    $viewCommon = $view->viewCommon($id);

    // 日程調整中リスト
    $table = 'matchConsultations';
    $column = '`matchConsulStatus`, COUNT("*")';
    $where = 'WHERE `tuotor_id` ='."'".$id."'".'AND (`matchConsulStatus` = 0 OR `matchConsulStatus` =1 OR `matchConsulStatus` =10) GROUP BY `matchConsulStatus`';
    $lists = $model->anyselectAll($table, $column, $where);
    // var_dump($lists);
    $lists = json($lists);
    
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
    <div class="body">
    <?php echo $viewCommon ?>
    </div>
</body>
<script>
        let step = <?php echo $step ?>;
        let lists = <?php echo $lists ?>;
</script>
<script src="js/t_mypage.js"></script>
</html>