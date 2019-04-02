<?php

    session_start();
    include('funcs/funcs.php');
    chkSsid();

    $student_id = h($_GET['sid']);
    include('mvc/model.php');
    $model = new MODEL;
    $column = '*';
    $where = 'WHERE student_id ='.$student_id;
    $code = $model->s_studentsAnySelect($column, $where);

    // 不正ログインチェック
    if($_SESSION['security_code'] != $code['security_code']){
        echo '不正アクセスです';
        exit();
    }

    // チューター情報
    $tuotor_id = h($_GET['tid']);
    $table = 't_tuotors';
    $column = '`tuotor_id`,
                 `k_familyname`,
                 `k_firstname`,
                 `birthyear`, 
                 `birthmonth`, 
                 `howto`,
                 `schoolname`,
                  `status`,
                  `howmany`,
                  `academic`,
                  `photo`';
    $where = 'WHERE `tuotor_id` = '."'".$tuotor_id."'";
    $info = $model->anyselect($table, $column, $where);
    
    // 勉強法
    $table = 'howtoLists';
    $column = '`howto_kind`';
    $where = '';
    $howto = $model->anyselectAll($table, $column, $where);

    // 学歴
    $table = 'academyLists';
    $column = 'academy_kind';
    $where = '';
    $academy = $model->anyselect($table, $column, $where);

    // 属性
    $table = 'statusLists';
    $column = 'status_kind';
    $where = '';
    $status = $model->anyselect($table, $column, $where);

    // view読み込み
    include('mvc/view.php');
    $view = new VIEW;
    $views = $view->viewStudentTopbar($code['student_id'], $code['k_familyname'], $code['k_firstname']);

    


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
        <div class="main">

        </div>

    </div>
</body>
</html>