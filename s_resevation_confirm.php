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

    // POSTデータの開封
    $array = array();
    $array['offerDate1'] = h($_POST['offerDate1']);
    $array['offerStarttimeh1'] = h($_POST['offerStarttimeh1']);
    $array['offerStarttimem1'] = h($_POST['offerStarttimem1']);
    $array['offerFinishtimeh1'] = h($_POST['offerFinishtimeh1']);
    $array['offerFinishtimem1'] = h($_POST['offerFinishtimem1']);
    $array['offerDate2 ']= h($_POST['offerDate2']);
    $array['offerStarttimeh2'] = h($_POST['offerStarttimeh2']);
    $array['offerStarttimem2'] = h($_POST['offerStarttimem2']);
    $array['offerFinishtimeh2'] = h($_POST['offerFinishtimeh2']);
    $array['offerFinishtimem2'] = h($_POST['offerFinishtimem2']);
    $array['offerDate3'] = h($_POST['offerDate3']);
    $array['offerStarttimeh3'] = h($_POST['offerStarttimeh3']);
    $array['offerStarttimem3'] = h($_POST['offerStarttimem3']);
    $aray['offerFinishtimeh3'] = h($_POST['offerFinishtimeh3']);
    $array['offerFinishtimem3 ']= h($_POST['offerFinishtimem3']);
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
           <div>
               <a href="" class="confirm">送信する</a>
           </div>
           <div>
               <a href="" class="back">修正する</a>
           </div>
       </div>
       <form action="s_resevation_edit.php" method="POST" name="edit">
           <input type="hidden" name="sid" value=<?php echo $id ?>>
           <input type="hidden" name="consulid" value=<?php echo $consul_id ?>>
           <input type="hidden" name="offerDate1" value=<?php echo $_POST['offerDate1'] ?>>
           <input type="hidden" name="offerStarttimeh1" value=<?php echo $_POST['offerStarttimeh1'] ?>>
           <input type="hidden" name="offerStarttimem1" value=<?php echo $_POST['offerStarttimem1'] ?>>
           <input type="hidden" name="offerFinishtimeh1" value=<?php echo $_POST['offerFinishtimeh1'] ?>>
           <input type="hidden" name="offerFinishtimem1" value=<?php echo $_POST['offerFinishtimem1'] ?>>
           <input type="hidden" name="offerDate2" value=<?php echo $_POST['offerDate2'] ?>>
           <input type="hidden" name="offerStarttimeh2" value=<?php echo $_POST['offerStarttimeh2'] ?>>
           <input type="hidden" name="offerStarttimem2" value=<?php echo $_POST['offerStarttimem2'] ?>>
           <input type="hidden" name="offerFinishtimeh2" value=<?php echo $_POST['offerFinishtimeh2'] ?>>
           <input type="hidden" name="offerFinishtimem2" value=<?php echo $_POST['offerFinishtimem2'] ?>>
           <input type="hidden" name="offerDate3" value=<?php echo $_POST['offerDate3'] ?>>
           <input type="hidden" name="offerStarttimeh3" value=<?php echo $_POST['offerStarttimeh3'] ?>>
           <input type="hidden" name="offerStarttimem3" value=<?php echo $_POST['offerStarttimem3'] ?>>
           <input type="hidden" name="offerFinishtimeh3" value=<?php echo $_POST['offerFinishtimeh3'] ?>>
           <input type="hidden" name="offerFinishtimem3" value=<?php echo $_POST['offerFinishtimem3'] ?>>    
       </form>
   </div>
</body>
<script>
    let array = <?php echo $array ?>;
    let sid = <?php echo $id ?>;
    let consulid = <?php echo $consul_id ?>;
</script>
<script src="js/s_resevation_confirm.js"></script>
</html>