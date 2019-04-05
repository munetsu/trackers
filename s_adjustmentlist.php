<?php 
    session_start();
    include('funcs/funcs.php');
    chkSsid();
    
    // $id = h($_GET['id']);
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

    // 面談調整リスト取得
    $table = 'matchConsultations';
    $column = '`matchConsultation_id`,`tuotor_id`,`offerDate1`,`offerStarttime1`,`offerFinishtime1`,`offerDate2`,`offerStarttime2`,`offerFinishtime2`,`offerDate3`,`offerStarttime3`,`offerFinishtime3`';
    $where = 'WHERE `student_id` ='."'".$id."'".'AND `matchConsulStatus` = 1';
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

    // VIEW読み込み
    include('mvc/view.php');
    $view = new VIEW;
    $views = $view->viewStudentTopbar();

    // ステータス一覧
    $table = 'statusLists';
    $column = '*';
    $where = '';
    $statuslist = $model->anyselectAll($table, $column, $where);
    $statuslist = json($statuslist);

    // 学歴一覧
    $table = 'academyLists';
    $academiclist = $model->anyselectAll($table, $column, $where);
    $academiclist = json($academiclist);

    // 勉強法一覧
    $table = 'howtoLists';
    $howtolist = $model->anyselectAll($table, $column, $where);
    $howtolist = json($howtolist);

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
    <title>Document</title>
    <!-- jQuery本体-->
    <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
    <!-- jQuery UI -->
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <!-- Datepicker日本語化 -->
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
    <!-- jQuery UI のCSS -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
</head>
<body>
    <div>
        <!-- トップバー -->
        <?php echo $views ?>
        <!-- メイン部分 -->
        <div class="main">
            <div class="datelist">
            </div>
            <div class="detail">
            </div>
        </div>
    </div>
</body>
<script>
    let lists = <?php echo $lists ?>;
    let statuslist = <?php echo $statuslist ?>;
    let academiclist = <?php echo $academiclist ?>;
    let howtolist = <?php echo $howtolist ?>;
    let thisyear = <?php echo $year ?>;
    let thismonth = <?php echo $month ?>;
</script>
<script src="js/s_adjustmentlist.js"></script>
</html>