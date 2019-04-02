<?php
    session_start();
    include('funcs/funcs.php');
    chkSsid();

    $id = $_GET['id'];
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
        $where = 'WHERE `certification_id` ='."'".$certification['certification_id']."'".'LIMIT 5';
        $tuotors = $model->anyselectAll($table, $column, $where);
        // 登録チューターがいない場合
        if($tuotors == null){
            continue;
        }

        // 資格を追加
        $tempArray = array();
        $tempArray[] = $certification['certification_kind'];

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
                // $book['imageUrl'] = '<img src="img/icon/noimage.svg">';
                $book['imageUrl'] = '';
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
    
    // JSON処理
    $certifications = json($certifications);


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
        <div class="topbar">
            <!-- left -->
            <div class="left">
                <div class="logo">
                    <img src="img/logo.png">
                </div>
                <div class="search">
                    <p class="selectCertification">資格で絞り込む</p>
                    <ul class="certificaionList"></ul>
                </div>
            </div>
            <!-- right -->
            <div class="right">
                <div class="mypage">
                    <p class="myname"><?php echo $code['k_familyname'] ?><?php echo $code['k_firstname'] ?></p>
                </div>
            </div>
        </div>
        <!-- メイン -->
        <div class="main">
            <!-- 資格別チューター一覧 -->
            <?php foreach($array as $tuotor): ?>
            <div class="certificationArea">
                <p><?php echo $tuotor[0] ?></p>
                <div class="tuotorArea"></div>
                <!-- 個人表示 -->
                <?php foreach($tuotor[1] as $one): ?>
                    <div class="tuotor" data-id=<?php echo $one[0]['tuotor_id']?>>
                        <p><?php echo $one[0]['k_familyname'] ?><?php echo $one[0]['k_firstname'] ?></p>
                        <p><?php echo $one[0]['birthyear'] ?>年生まれ</p>
                        <p><?php echo $one[0][0]['title'] ?></p>
                        <?php echo $one[0][0]['imageUrl'] ?>
                    </div>

                <?php endforeach; ?>
                
            </div>
            <?php endforeach; ?>
            
        </div>
    </div>
</body>
<script>
    let certifications = <?php echo $certifications ?>;
</script>
<script src="js/s_mypage.js"></script>
</html>