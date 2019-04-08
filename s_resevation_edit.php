<?php
    session_start();
    include('funcs/funcs.php');
    chkSsid();

    $id = h($_POST['sid']);
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

    $consul_id = h($_POST['consulid']);
    $table = 'matchConsultations';
    $column = '`security_code`';
    $where = 'WHERE `matchConsultation_id` ='."'".$consul_id."'";
    $matchSecurity = $model->anyselect($table, $column, $where);
    // マッチングリストの照合
    if($_SESSION['matchSecurity'] != $matchSecurity['security_code']){
        echo 'エラーが起きています。';
        exit();
    }

    $offerDate1 = h($_POST['offerDate1']);
    $offerDate2 = h($_POST['offerDate2']);
    $offerDate3 = h($_POST['offerDate3']);

    $offerStarttimeh[] = h($_POST['offerStarttimeh1']);
    $offerStarttimeh[] = h($_POST['offerStarttimeh2']);
    $offerStarttimeh[] = h($_POST['offerStarttimeh3']);
    $offerStarttimeh = json($offerStarttimeh);

    $offerStarttimem[] = h($_POST['offerStarttimem1']);
    $offerStarttimem[] = h($_POST['offerStarttimem2']);
    $offerStarttimem[] = h($_POST['offerStarttimem3']);
    $offerStarttimem = json($offerStarttimem);

    $offerFinishtimeh[] = h($_POST['offerFinishtimeh1']);
    $offerFinishtimeh[] = h($_POST['offerFinishtimeh2']);
    $offerFinishtimeh[] = h($_POST['offerFinishtimeh3']);
    $offerFinishtimeh = json($offerFinishtimeh);

    $offerFinishtimem[] = h($_POST['offerFinishtimem1']);
    $offerFinishtimem[] = h($_POST['offerFinishtimem2']);
    $offerFinishtimem[] = h($_POST['offerFinishtimem3']);
    $offerFinishtimem = json($offerFinishtimem);

    // view読み込み
    include('mvc/view.php');
    $view = new VIEW;
    $views = $view->viewStudentTopbar($code['student_id'], $code['k_familyname'], $code['k_firstname']);

    // 登録資格リスト
    $table = 'certifications';
    $column = '*';
    $where = '';
    $certifications = $model->anyselectAll($table, $column, $where);
    // JSON処理
    $certifications = json($certifications);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>【Trackers】</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/s_common.css">
    <link rel="stylesheet" href="css/s_resevation_edit.css">
    <!-- jQuery本体-->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <!-- jQuery UI -->
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <!-- Datepicker日本語化 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
    <!-- jQuery UI のCSS -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
</head>
<body>
    <div><?php echo $views ?></div>
    <div class="main">
        <div>
            <p>面談希望日時</p>
            <form action="s_resevation_confirm.php" method="POST" name="booking">
                <input type="hidden" name="sid" value=<?php echo $id ?>>
                <input type="hidden" name="consulid" value=<?php echo $consul_id ?>>
                <p>
                    第1希望：
                    <input type="text" name="offerDate1" class="datepicker" value=<?php echo $offerDate1 ?>>
                </p>
                <div class="timearea">
                    希望開始時間<br>
                    <select class="stime1" name="offerStarttimeh1"></select>：<select class="sminute1" name="offerStarttimem1"></select> 〜 <select class="ftime1" name="offerFinishtimeh1"></select>：<select class="fminute1" name="offerFinishtimem1"></select>
                </div>
                <p>
                    第2希望：
                    <input type="text" name="offerDate2" class="datepicker" value=<?php echo $offerDate2 ?>>
                </p>
                
                <div class="timearea">
                    希望開始時間<br>
                    <select class="stime2" name="offerStarttimeh2"></select>：<select class="sminute2" name="offerStarttimem2"></select> 〜 <select class="ftime2" name="offerFinishtimeh2"></select>：<select class="fminute2" name="offerFinishtimem2"></select>
                </div>
                <p>
                    第3希望：
                    <input type="text" name="offerDate3" class="datepicker" value=<?php echo $offerDate3 ?>>
                </p>
                <div class="timearea">
                    希望開始時間<br>
                    <select class="stime3" name="offerStarttimeh3"></select>：<select class="sminute3" name="offerStarttimem3"></select> 〜 <select class="ftime3" name="offerFinishtimeh3"></select>：<select class="fminute3" name="offerFinishtimem3"></select>
                </div>
            </form>
        </div>
        <div class="btnarea">
            <a href="" class="btn">確認する</a>
        </div>
    </div>
    </div>
</body>
<script>
    let offerStarttimeh = <?php echo $offerStarttimeh ?>;
    let offerStarttimem = <?php echo $offerStarttimem ?>;
    let offerFinishtimeh = <?php echo $offerFinishtimeh ?>;
    let offerFinishtimem = <?php echo $offerFinishtimem ?>;
    let certifications = <?php echo $certifications ?>;
</script>
<script src="js/s_common.js"></script>
<script src="js/s_resevation_edit.js"></script>
</html>