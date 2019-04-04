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
    <title>Document</title>
    <!-- jQuery本体-->
    <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
   <div>
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
        <div>
            <a href="" class="confirm">送信する</a>
        </div>
        <div>
            <a href="t_adjustmentlist.php">戻る</a>
        </div>
</body>
<script>
    let offerlist = <?php echo $array ?>;
    let consulid = <?php echo $consulid ?>;
</script>
<script src="js/t_adjustmentConfirm.js"></script>
</html>
