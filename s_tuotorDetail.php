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
    $academy = $model->anyselectAll($table, $column, $where);

    // 属性
    $table = 'statusLists';
    $column = 'status_kind';
    $where = '';
    $status = $model->anyselectAll($table, $column, $where);

    // view読み込み
    include('mvc/view.php');
    $view = new VIEW;
    $views = $view->viewStudentTopbar($code['student_id'], $code['k_familyname'], $code['k_firstname']);

    // 日付
    $date = Date("d");
    $year = Date("Y");

    // 勉強方法を取得
    // 登録済み勉強方法月を取得
    $select = 'month';
    $month = $model->howtoMonthly($tuotor_id, $select);
    $monthLength = count($month);
    if($monthLength != 0){
        $month = json($month);
    }else{
        array_push($month, 0);
        $month = json($month);
    }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/s_tuotorDetail.css">
    <!-- jQuery本体-->
    <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
    <div>
        <!-- トップバー -->
        <?php echo $views ?>
        <!-- メイン -->
        <div class="main">
            <div class="profile">
                <!-- 顔写真 -->
                <div class="photo">
                    <?php if($info['photo'] == null): ?>
                        <img src="img/icon/feature1.svg" class="face">
                    <?php else:?>
                        <img src=<?php echo $info['photo'] ?> class="face">
                    <?php endif; ?>                
                </div>
                <!-- プロフィール -->
                <div class="profileText">
                    <!-- 年齢計算 -->
                    <?php if(($date - $info['birthmonth']) <0): ?>
                            <?php $age = ($year - $info['birthyear'] -1) ?>
                            <?php else: ?>
                            <?php $age = ($year - $info['birthyear']) ?>
                            <?php endif; ?>
                    <table>
                        <tr>
                            <td>氏名：</td>
                            <td><?php echo $info['k_familyname'] ?><?php echo $info['k_firstname'] ?>(<?php echo $age ?>)</td>
                        </tr>
                        <tr>
                            <td>勉強法</td>
                            <td><?php echo $howto[($info['howto']-1)]['howto_kind']?></td>
                            <?php if($info['howto'] == 2): ?>
                            <tr>
                                <td>学校名：</td>
                                <td><?php echo $info['schoolname']?></td>
                            </tr>
                            <?php elseif($info['howto'] == 3): ?>
                            <tr>
                                <td>通信教材：</td>
                                <td><?php echo $info['schoolname']?></td>
                            </tr>
                            <?php endif; ?>
                        </tr>
                        <tr>
                            <td>職業：</td>
                            <td><?php echo $status[($info['status']-1)]['status_kind'] ?></td>
                        </tr>
                    </table>
                </div>
                <!-- 利用書籍 -->
                <div class="text">
                    <p>利用書籍一覧</p><a href="" class="textajax">表示する</a>
                    <div class="textarea"></div>
                </div>
                <!-- 勉強法 -->
                <div class="howtoStudy">
                    <p>勉強方法</p>
                    <span>閲覧したい月をクリックしてください.</span>
                    <ul class="monthlist"></ul>
                    <div class="howtobody"></div>
                </div>
                <!-- クリック -->
                <div class="btn">
                    <div class="likearea">
                        <a href="" class="like">参考にする</a>
                    </div>
                    <div class="consultationarea">
                        <a href="" class="consultation">相談したい</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    let tuotor_id = <?php echo $tuotor_id ?>;
    let monthly = <?php echo $month ?>;
    let student_id = <?php echo $student_id ?>;
</script>
<script src="js/s_tuotorDetail.js"></script>
</html>