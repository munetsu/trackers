<?php

    session_start();
    include('funcs/funcs.php');
    chkSsid();

    $id = $_SESSION['student_id'];
    include('mvc/model.php');
    $model = new MODEL;
    $column = '*';
    $where = 'WHERE student_id ='.$id;
    $code = $model->s_studentsAnySelect($column, $where);

    // 不正ログインチェック
    if($_SESSION['security_code'] != $code['security_code']){
        echo '不正アクセスです';
        exit();
    }

    // VIEW読み込み
    include('mvc/view.php');
    $view = new VIEW;
    $views = $view->viewStudentTopbar();

    // コンサルリスト
    $table = 'matchConsultations';
    $column = '`matchConsultation_id`, `tuotor_id`,`confirmDate`,`confirmTime`';
    $where = 'WHERE `student_id` ='."'".$id."'".'AND `matchConsulStatus` = 10';
    $lists = $model->anyselectAll($table, $column, $where);
    
    // チューター情報
    $table = 't_tuotors';
    $column = '`k_familyname`, `k_firstname`, `birthyear`, `birthmonth`';
    $count = 0;
    foreach($lists as $list){
        $where = 'WHERE `tuotor_id` ='."'".$list['tuotor_id']."'";
        $info = $model->anyselect($table, $column, $where);
        array_push($lists[$count], $info);
        $count++;
    }
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
    <div>
        <!-- トップバー -->
        <?php echo $views ?>
        <!-- メイン -->
        <div class="main"></div>
    </div>
</body>
<script>
    let sid = <?php echo $id ?>;
    let lists = <?php echo $lists ?>;
</script>
<script src="js/s_matchConsulList.js"></script>
</html>