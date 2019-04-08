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

    // POSTデータ取得
    $consulid = h($_POST['consulid']);
    // POSTデータの開封
    $array = array();
    $array['offerDate1'] = h($_POST['offerDate1']);
    $array['offerStarttimeh1'] = h($_POST['offerStarttimeh1']);
    $array['offerStarttimem1'] = h($_POST['offerStarttimem1']);
    $array['offerFinishtimeh1'] = h($_POST['offerFinishtimeh1']);
    $array['offerFinishtimem1'] = h($_POST['offerFinishtimem1']);
    $array['offerDate2']= h($_POST['offerDate2']);
    $array['offerStarttimeh2'] = h($_POST['offerStarttimeh2']);
    $array['offerStarttimem2'] = h($_POST['offerStarttimem2']);
    $array['offerFinishtimeh2'] = h($_POST['offerFinishtimeh2']);
    $array['offerFinishtimem2'] = h($_POST['offerFinishtimem2']);
    $array['offerDate3'] = h($_POST['offerDate3']);
    $array['offerStarttimeh3'] = h($_POST['offerStarttimeh3']);
    $array['offerStarttimem3'] = h($_POST['offerStarttimem3']);
    $array['offerFinishtimeh3'] = h($_POST['offerFinishtimeh3']);
    $array['offerFinishtimem3']= h($_POST['offerFinishtimem3']);
    $array = json($array);

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
    <link rel="stylesheet" href="css/s_adjustmentConfirm.css">
    <!-- jQuery本体-->
    <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
    <div><?php echo $views ?></div>
   <div class="main">
       <p>下記日時でオファーしますか？</p>
       <table>
            <tr>
                <th>希望順位</th>
                <th>日付</th>
                <th>開始時間</th>
                <th></th>
                <th>終了時間</th>
            </tr>
           <tr>
               <td>第一希望</td>
               <td><?php echo $_POST['offerDate1'] ?></td>
               <td><?php echo $_POST['offerStarttimeh1'] ?>：<?php echo $_POST['offerStarttimem1'] ?></td>
               <td>〜</td>
               <td><?php echo $_POST['offerFinishtimeh1'] ?>：<?php echo $_POST['offerFinishtimem1'] ?></td>
           </tr>
           <tr>
               <td>第二希望</td>
               <td><?php echo $_POST['offerDate2'] ?></td>
               <td><?php echo $_POST['offerStarttimeh2'] ?>：<?php echo $_POST['offerStarttimem2'] ?></td>
               <td>〜</td>
               <td><?php echo $_POST['offerFinishtimeh2'] ?>：<?php echo $_POST['offerFinishtimem2'] ?></td>
           </tr>
           <tr>
               <td>第三希望</td>
               <td><?php echo $_POST['offerDate3'] ?></td>
               <td><?php echo $_POST['offerStarttimeh3'] ?>：<?php echo $_POST['offerStarttimem3'] ?></td>
               <td>〜</td>
               <td><?php echo $_POST['offerFinishtimeh3'] ?>：<?php echo $_POST['offerFinishtimem3'] ?></td>
           </tr>
       </table>
       <div class="btnarea">
            <div class="confirmarea">
                <a href="" class="confirm">送信する</a>
            </div>
            <div class="backarea">
                <a href="s_adjustmentlist.php" class="back">戻る</a>
            </div>
        </div>
</body>
<script>
    let offerlist = <?php echo $array ?>;
    let consulid = <?php echo $consulid ?>;
    let sid = <?php echo $id ?>;
</script>
<script src="js/s_common.js"></script>
<script src="js/t_adjustmentConfirm.js"></script>
</html>
