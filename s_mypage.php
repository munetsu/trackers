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

    // 登録資格リスト
    $table = 'certifications';
    $column = '*';
    $where = '';
    $certifications = $model->anyselectAll($table, $column, $where);

    // チューター情報取得(LIMIT 5名ずつ)
    $table = 't_tuotors';
    $column = '`tuotor_id`, `k_familyname`,`k_firstname`,`birthyear`, `birthmonth`, `howto`, `status`';

    // 書籍用
    $tables = 'booklists';
    $columns = '`title`, `imageUrl`';

    // HTML記載用配列
    $array = array();
    foreach($certifications as $certification){
        // 資格ごとのチューター取得
        $where = 'WHERE `certification_id` ='."'".$certification['certification_id']."'".'LIMIT 3';
        $tuotors = $model->anyselectAll($table, $column, $where);
        // 登録チューターがいない場合
        if($tuotors == null){
            continue;
        }

        // 資格を追加
        $tempArray = array();
        $tempCertification = array();
        array_push($tempCertification, $certification);
        // $tempArray[] = $certification['certification_kind'];
        $tempArray[] = $tempCertification;

        // チューター格納
        $tempTuotor = array();
        
        // チューター1名ずつ取得
        foreach($tuotors as $tuotor){
            // 登録書籍を1冊取得
            $wheres = 'WHERE `tuotor_id` = '."'".$tuotor['tuotor_id']."'";
            $books = $model->anyselect($tables, $columns, $wheres);
            // var_dump($books);
            if($books == ''){
                $book = array();
                $book['title'] = '市販書籍なし';
                $book['imageUrl'] = '<img src="img/icon/noimage.svg" class="noimg">';
                // $book['imageUrl'] = '';
                array_push($tuotor, $book);
            }else{
                array_push($tuotor, $books);
            }
            // チューター情報を追加
            // チューター格納配列
            $temp = array();
            array_push($temp, $tuotor);
            array_push($tempTuotor, $temp);
            
            // array_push($tempArray, $tuotor);
        }
        $tempArray[] = $tempTuotor;
        array_push($array, $tempArray);
    }
    // var_dump($array[0][1]);

    // 配列内容
    // 資格名：$array[i][0];
    // チューター情報：$array[i][1]];

    // 日付
    $date = Date("d");
    $year = Date("Y");

    // 勉強法
    $table = 'howtoLists';
    $column = '`howto_kind`';
    $where = '';
    $howto = $model->anyselectAll($table, $column, $where);
    // var_dump($howto[1]['howto_kind']);
    
    // JSON処理
    $certifications = json($certifications);

    // View処理
    include('mvc/view.php');
    $view = new VIEW;
    $views = $view->viewStudentTopbar();

    // コンサルリスト取得
    $table = 'matchConsultations';
    $column = '`matchConsultation_id`';
    $where = 'WHERE `student_id` ='."'".$id."'".'AND `matchConsulStatus` = "1"';
    $consullist = $model->anyselect($table, $column, $where);
    if(!$consullist){
        $alertcheck = 0;
    }else{
        $alertcheck = 1;
    }

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
    <link rel="stylesheet" href="css/s_mypage.css">
    <!-- jQuery本体-->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
    <div>
        <!-- トップバー -->
        <?php echo $views ?>
        <!-- メイン -->
        <div class="main">
            <!-- 資格別チューター一覧 -->
            <?php foreach($array as $tuotor): ?>
            <div class="certificationArea">
                <div class="textlist">
                <p class="certificationName"><?php echo $tuotor[0][0]['certification_kind'] ?></p>
                <p><a href="" class="alldescribe" data-certification=<?php echo $tuotor[0][0]['certification_id']?>>すべてのチューターを表示>>></a></p>
                </div>
                <div class="tuotorArea">
                <!-- 個人表示 -->
                    <?php foreach($tuotor[1] as $one): ?>
                        <div class="tuotor" data-id=<?php echo $one[0]['tuotor_id']?>>
                            <!-- 年齢計算 -->
                            <?php if(($date - $one[0]['birthmonth']) <0): ?>
                            <?php $age = ($year - $one[0]['birthyear'] -1) ?>
                            <?php else: ?>
                            <?php $age = ($year - $one[0]['birthyear']) ?>
                            <?php endif; ?>
                            <!-- 名前：年齢 -->
                            <p><?php echo $one[0]['k_familyname'] ?><?php echo $one[0]['k_firstname'] ?>(<?php echo $age ?>)</p>
                            <!-- 勉強方法 -->
                            <?php $howtoIndex = ($one[0]['howto']-1) ?>
                            <p><?php echo $howto[$howtoIndex]['howto_kind'] ?></p>
                            <!-- 利用書籍 -->
                            <p><?php echo $one[0][0]['title'] ?></p>
                            <!-- 書籍画像 -->
                            <?php echo $one[0][0]['imageUrl'] ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>  
    </div>
</body>
<script>
    let certifications = <?php echo $certifications ?>;
    let student_id = <?php echo $id ?>;
    let alertcheck = <?php echo $alertcheck ?>;
    let date = <?php echo $date ?>;
</script>
<script src="js/s_common.js"></script>
<script src="js/s_mypage.js"></script>
</html>