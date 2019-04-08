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

    // VIEW読み込み
    include('mvc/view.php');
    $view = new VIEW;
    $viewCommon = $view->viewCommon($id);

    // 日程調整リスト
    $table = 'matchConsultations';
    $column = '`matchConsultation_id`, `student_id`, `confirmDate`, `confirmTime`';
    $where = 'WHERE `tuotor_id` ='."'".$id."'".'AND `matchConsulStatus` = 10';
    $resevationlists = $model->anyselectAll($table, $column, $where);
    
    // 生徒情報
    $table = 's_students';
    $column = '`a_familyname`,`a_firstname`, `birthyear`,`birthmonth`';
    $count = 0;
    foreach($resevationlists as $resevation){
        $where ='WHERE `student_id` ='."'".$resevation['student_id']."'";
        $info = $model->anyselect($table, $column, $where);
        array_push($resevationlists[$count], $info);
        $count++;
    }

    // var_dump($resevationlists);
    $resevationlists = json($resevationlists);

    // 日付取得
    $year = Date("Y");
    $month = Date("d");

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>【Trackers】チューター</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/t_common.css">
    <!-- jQuery本体-->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
    <div>
        <?php echo $viewCommon ?>
    </div>
</body>
<script>
    let resevationlists = <?php echo $resevationlists ?>;
    let thisyear = <?php echo $year ?>;
    let thismonth = <?php echo $month ?>;
    let tid = <?php echo $id ?>;
</script>
<script src="js/t_common.js"></script>
<script src="js/t_resevationlist.js"></script>
</html>