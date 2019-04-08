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
    // 資格ID
    $certificationid = h($_GET['certificationid']);

    // チューター一覧情報取得
    $table = 't_tuotors';
    $column = '`tuotor_id`, `k_familyname`,`k_firstname`,`birthyear`, `birthmonth`, `howto`, `status`';
    $where = 'WHERE `certification_id` ='."'".$certificationid."'";
    $lists = $model->anyselectAll($table, $column, $where);

    // 書籍情報
    $table = 'booklists';
    $column = '`title`, `imageUrl`';
    $count = 0;
    $nobook = ['title'=>'登録なし', 'imageUrl'=>'<img src="img/icon/noimage.svg">'];
    // チューターごとの書籍を取得
    foreach($lists as $list){
        $where = 'WHERE `tuotor_id`='."'".$list['tuotor_id']."'";
        $book = $model->anyselect($table, $column, $where);
        // 書籍がない場合
        if($book == null){
            array_push($lists[$count], $nobook);
            $count++;
            continue;
        }
        array_push($lists[$count], $book);
        $count++;
    }
    // JSON処理
    $lists = json($lists);

    // View処理
    include('mvc/view.php');
    $view = new VIEW;
    $views = $view->viewStudentTopbar();

    // 勉強法一覧
    $table = 'howtoLists';
    $column = '*';
    $where = '';
    $howtolist = $model->anyselectAll($table, $column, $where);
    $howtolist = json($howtolist);


    // 日時
    $year = Date("Y");
    $month = Date("m");

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
    <link rel="stylesheet" href="css/s_tuotoralllist.css">
    <!-- jQuery本体-->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
    <div>
        <!-- ヘッダー -->
        <?php echo $views ?>
        <!-- メイン -->
        <div class="main"></div>
    </div>
</body>
<script>
    let lists = <?php echo $lists?>;
    let thisyear = <?php echo $year ?>;
    let thismonth = <?php echo $month ?>;
    let howtolist = <?php echo $howtolist ?>;
    let certifications = <?php echo $certifications ?>;
</script>
<script src="js/s_common.js"></script>
<script src="js/s_tuotoralllist.js"></script>
</html>