<?php
    session_start();
    include('funcs/funcs.php');
    chkSsid();

    $id = $_SESSION['tuotor_id'];
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
        header('location: http://'.$_SERVER["HTTP_HOST"].'/trackers/t_signUp2.php');
        exit();
    }
    
    // VIEW読み込み
    include('mvc/view.php');
    $view = new VIEW;
    $viewCommon = $view->viewCommon($id);

    // 日程調整中リスト
    $table = 'matchConsultations';
    $column = '`matchConsulStatus`, COUNT("*")';
    $where = 'WHERE `tuotor_id` ='."'".$id."'".'AND `matchConsulStatus` = 0';
    $list0 = $model->anyselectAll($table, $column, $where);
    $where = 'WHERE `tuotor_id` ='."'".$id."'".'AND `matchConsulStatus` = 1';
    $list1 = $model->anyselectAll($table, $column, $where);
    $where = 'WHERE `tuotor_id` ='."'".$id."'".'AND `matchConsulStatus` = 10';
    $list10 = $model->anyselectAll($table, $column, $where);
    $lists = array('0'=>$list0[0]['COUNT("*")'], '1'=>$list1[0]['COUNT("*")'], '10'=>$list10[0]['COUNT("*")']);
    $lists = json($lists);
    
    
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>【Trackers】チューターMypage</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/t_common.css">
    <link rel="stylesheet" href="css/t_mypage.css">
    <!-- jQuery本体-->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
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
<script src="js/t_common.js"></script>
<script src="js/t_mypage.js"></script>
</html>