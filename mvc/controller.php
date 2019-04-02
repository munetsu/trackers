<?php
    include('../funcs/funcs.php');
    include('model.php');
    $http = 'https';

    class CONTROLLER{
        function __construct(){
            $this->model = new MODEL;
            $this->POST = $_POST['action'];
            $this->judge();
        }

        // 処理切り分け
        private function judge(){

            ///////////////////////////////////////////
            //tuotorRegister.php
            ///////////////////////////////////////////

            // チューター面談登録
            if($this->POST == 'tuotorRegister'){
                // TuotorRegister処理
                $array = array();
                $array['name'] = h($_POST['name']); //名前
                $array['email'] = h($_POST['email']); //Gmail
                $array['tel'] = h($_POST['tel']); //電話番号
                $array['certification'] = h($_POST['certification']); //資格
                $array['firstDate'] = h($_POST['firstDate']); //第一候補日
                $array['ftime'] = h($_POST['ftime']); //第一候補時間
                $array['secondDate'] = h($_POST['secondDate']); //第二候補日
                $array['stime'] = h($_POST['stime']); //第二候補時間
                $array['thirdDate'] = h($_POST['thirdDate']); //第三候補日
                $array['ttime'] = h($_POST['ttime']); //第三候補時間
                // modelへデータ引き継ぎ
                // $this->model = new MODEL;
                $this->model->tuotorRegister($array);
            }

            ///////////////////////////////////////////
            //t_passgenerate.php
            ///////////////////////////////////////////
            // パスワード作成
            if($this->POST == 'passgene'){
                // パスワードをハッシュ化
                $password = $_POST['pass1'];
                $password = $this->passmd5($password);
                $password = $this->password($password);
                // データ展開
                $tuotor_id = $_POST['tuotor_id'];
                $email = $_POST['email'];
                
                // idとメールアドレスの確認
                $column = 'email';
                $where = 'WHERE `tuotor_id`='.$tuotor_id;
                $res = $this->model->t_tuotorsAnySelect($column, $where);
                if($email != $res['email']){
                    echo 'メールアドレスが異なっております';
                    exit();
                }

                // ログイン用データへ保存
                $this->model->tuotorUpdate($password, $tuotor_id);

                // loginへ
                header('location: http://'.$_SERVER["HTTP_HOST"].'/trackers/login.php?status=tuotor');

            }

            ///////////////////////////////////////////
            //s_passgenerate.php
            ///////////////////////////////////////////
            // パスワード作成
            if($this->POST == 's_passgene'){
                // パスワードをハッシュ化
                $password = $_POST['pass1'];
                $password = $this->passmd5($password);
                $password = $this->password($password);
                // データ展開
                $student_id = $_POST['student_id'];
                $email = $_POST['email'];
                
                // idとメールアドレスの確認
                $column = 'email';
                $where = 'WHERE `student_id`='.$student_id;
                $res = $this->model->s_studentsAnySelect($column, $where);
                if($email != $res['email']){
                    echo 'メールアドレスが異なっております';
                    exit();
                }

                // ログイン用データへ保存
                $this->model->studentUpdate($password, $student_id);

                // loginへ
                header('location: ../login.php?status=student');

            }

            ///////////////////////////////////////////
            //login.php
            ///////////////////////////////////////////

            // ログイン
            if($this->POST == 'login'){
                // password処理
                $password = h($_POST['password']);
                $password = $this->passmd5($password);
                $password = $this->password($password);

                // status確認
                if($_POST['status'] == 1){
                    $table = 't_tuotors';
                }else if($_POST['status'] == 2){
                    $table = 's_students';
                }else{
                    echo 'ログインエラー';
                    exit();
                }

                // データ展開
                $email = h($_POST['email']);
                
                // modelへ引き継ぎ
                $info =$this->model->login($table, $email, $password);

                // login判定
                $this->login_judge($info);

                // データ引き継ぎ
                if($_POST['status'] == 1){
                    $id = $info['tuotor_id'];
                    // sessionスタート
                    $_SESSION['tuotor_id'] = $id;


                    // ログインアップデート
                    $this->model->t_loginUpDate($table, $id);
    
                    // チューターMyPageへ
                    header('location: http://'.$_SERVER["HTTP_HOST"].'/trackers/t_mypage.php?id='.$id);
                    exit();
                }else if($_POST['status'] == 2){
                    // 生徒側処理
                    $id = $info['student_id'];
                    $_SESSION['student_id'] = $id;

                    // ログインアップデート
                    $this->model->s_loginUpDate($table, $id);

                    // ステップアップデート
                    $step = 2;
                    $this->model->studentStep($id, $step);

                    // studentTopPageへ
                    header('location: ../s_mypage.php?id='.$id);
                    exit();

                }

            }

            // チューター会員登録
            if($this->POST == 'tuotorSignUp'){
                
                // 写真アップ処理
                $picture = $this->reSize($_FILES['upfile']);

                // password処理
                $password = $this->password($_POST['password']);

                // データ展開
                $array = array();
                $array['tuotor_id'] = h($_POST['tuotor_id']);
                $array['c_name'] = h($_POST['c_name']);
                $array['k_name'] = h($_POST['k_name']);
                $array['email'] = h($_POST['email']);
                $array['password'] = $password;
                $array['tel'] = h($_POST['tel']);
                $array['picture'] = $picture;
                $array['birthyear'] = h($_POST['birthyear']);
                $array['birthmonth'] = h($_POST['birthmonth']);

                // modelへ引き継ぎ
                $this->model->tuotorSignUp($array);
               
                // 次ページへ
                header('location: http://'.$_SERVER["HTTP_HOST"].'/trackers/tuotor_studyhow.php?id='."'".$array['tuotor_id']."'");
                exit();
                
            }

            ///////////////////////////////////////////
            //tuotor_signUp2.php
            ///////////////////////////////////////////
            // booklist登録
            if($this->POST == 'bookRegister'){
                
                // データ展開
                $array = array();
                $array['tuotor_id'] = $_POST['tuotor_id'];
                
                $datas = $_POST['data'];
                $count = 0;
                foreach($datas as $data){
                    $count++;
                    $array['title'.$count] = $data['title'];
                    $array['imageUrl'.$count] = $data['imageUrl'];
                }
                $array['count'] = $count;

                // modelへ引き継ぎ
                $this->model->booklist($array);

                // チューター情報取得
                $tuotorInfo = $this->model->tuotorInfo($array['tuotor_id']);
                
                // VIEWへ引き継ぎ
                include('view.php');
                $this->view = new VIEW;
                $this->view->tuotorView($array, $tuotorInfo);
                
            }
            ///////////////////////////////////////////
            //tuotor_studyhow.php
            ///////////////////////////////////////////
            // 情報登録
            if($this->POST == 'studyhow'){
                // データ展開
                $array = array();
                $array['tuotor_id'] = h($_POST['tuotor_id']);
                $array['weektime'] = h($_POST['weektime']);
                $array['weekday'] = h($_POST['weekday']);
                $array['holidaytime'] = h($_POST['holidaytime']);
                $array['holiday'] = h($_POST['holiday']);
                $array['booklists'] = $_POST['booklists'];
                $array['howtolists'] = $_POST['howtolists'];
 
                // modelへ引き継ぎ
                // select文
                $monthList = $this->model->studyhowSelect($array['tuotor_id'], $_POST['monthly']);
                $array['monthly'] = $monthList;

                // INSERT文
                $this->model->tuotor_studyhow($array);

                echo $array['tuotor_id'];
            }

            if($this->POST == 'how'){
               $test = $_POST['datakind'];
                var_dump($test);
                exit();
            }

            ///////////////////////////////////////////
            //t_signUp_confirm.php
            ///////////////////////////////////////////
            if($this->POST == 't_signUp'){
                $tableLists1 = [
                    'certification',
                    'k_familyname',
                    'k_firstname',
                    'a_familyname',
                    'a_firstname',
                    'email',
                    'tel',
                    'birthyear',
                    'birthmonth',
                    'status',
                    'academic',
                    'howto',
                    'howmany'
                ];
               
                $tableLists = [
                    'certification',
                    'k_familyname',
                    'k_firstname',
                    'a_familyname',
                    'a_firstname',
                    'email',
                    'tel',
                    'birthyear',
                    'birthmonth',
                    'status',
                    'academic',
                    'howto',
                    'schoolname',
                    'howmany'
                ];

                // データ展開
                $array = array();
                if($_POST['howto'] == 1){
                    foreach($tableLists1 as $tableList){
                        $array[$tableList] = h($_POST[$tableList]);
                    }
                }else{
                    foreach($tableLists as $tableList){
                        $array[$tableList] = h($_POST[$tableList]);
                    }
                }
  
                // modelへ引き継ぎ
                // データ重複がないか確認
                $res = $this->model->t_tuotorsSelect($array, '*');

                // データ重複判定
                if($res){
                    // 重複があった場合
                    include('view.php');
                    $this->view = new VIEW;
                    $this->view->tuotorRegisterError();
                    return;
                }else{
                    // var_dump($array);
                    // exit();
                    // 新規データの場合
                    if(count($array) == count($tableLists1)){
                        $result = $this->model->t_tuotors($array, $tableLists1);
                    }else{
                        $result = $this->model->t_tuotors($array, $tableLists);
                    }
                }

                if($result == null){
                    // tuotor_id取得
                    $id = $this->model->t_tuotorsSelect($array, 'tuotor_id');
                    header('location: http://'.$_SERVER["HTTP_HOST"].'/trackers/t_passgenerate.php?id='.$id['tuotor_id']);
                    exit();
                }else{
                    echo 'データ登録でエラー発生';
                }
            }

            ///////////////////////////////////////////
            //t_signUp2.php
            ///////////////////////////////////////////
            if($this->POST == 'bookLists'){
                // 既に登録があるか確認
                $column = '*';
                $tuotor_id = h($_POST['id']);
                $where = 'WHERE `tuotor_id` ='.$tuotor_id;
                $res = $this->model->t_booklistSelect($column, $where);
                if($res != null){
                    // t_tuotorsのstep更新
                    $step = 2;
                    $this->model->tuotorStep($tuotor_id, $step);
                    return;
                }

                $count = 1;
                // データ数を確認
                if(count($_POST) == 2){
                    // 書籍登録がないため、処理なし
                    echo 'nodata';
                    return;
                }else{
                    // 書籍データがある場合
                    $array = array();
                    
                    foreach($_POST['bookInfo'] as $book){
                        $array['title'.$count] = h($book['title']);
                        $array['imageUrl'.$count] = h($book['imageUrl']);
                        $count++;
                    }
                    // var_dump($array);
                    // exit();
                    // modelへ引き継ぎ
                    $this->model->bookRegister($tuotor_id, $array);
                }
                // t_tuotorsのstep更新
                $step = 2;
                $this->model->tuotorStep($tuotor_id, $step);
            }
            ///////////////////////////////////////////
            //t_signUp3.php
            ///////////////////////////////////////////
            if($this->POST == 'appLists'){
                $count = 1;
                if(count($_POST) == 2){
                    // 書籍登録がないため、処理なし
                    return;
                }else{
                    // 書籍データがある場合
                    $array = array();
                    $tuotor_id = $_POST['id'];
                    foreach($_POST['appInfo'] as $app){
                        $array['sp'.$count] = h($app['smartphone']);
                        $array['app'.$count] = h($app['appName']);
                        $count++;
                    }    
                    // modelへ引き継ぎ
                    $this->model->appRegister($tuotor_id, $array);
                }
            }

            ///////////////////////////////////////////
            //t_howto.php
            ///////////////////////////////////////////
            // howto登録
            if($this->POST == 'howto'){
                $tuotor_id = h($_POST['tuotor_id']);
                // 重複登録の確認
                $monthly = array();
                foreach($_POST['month'] as $month){
                    array_push($monthly, h($month));
                }
                // 未登録月分を抽出
                $monthlist = $this->model->t_howtoSelect($tuotor_id, $monthly);
                if(count($monthlist) == 0){
                    return;
                }

                // 未登録月分の登録
                // データ展開
                $array = array();
                $array['weektime'] = h($_POST['time'][0]);
                $array['weekday'] = h($_POST['time'][1]);
                $array['holidaytime'] = h($_POST['time'][2]);
                $array['holiday'] = h($_POST['time'][3]);

                $books = array();
                foreach($_POST['text'] as $text){
                    array_push($books, h($text));
                }
                $howto = h($_POST['howto']);
                
                if(h($_POST['step']) == 'next' || h($_POST['step']) == 'stop'){
                    $step = 3;
                }else if(h($_POST['step']) == 'finish'){
                    $step = 20;
                }else{
                    return;
                }

                // データ登録
                $this->model->t_howtoRegister($tuotor_id, $monthlist, $array, $howto, $books);
                
                // step更新
                $this->model->tuotorStep($tuotor_id,$step);
            }

            ///////////////////////////////////////////
            //s_signUp_confirm.php
            ///////////////////////////////////////////
            if($this->POST == 's_signUp'){
                // テーブルリスト
                $tableLists = [
                    'k_familyname',
                    'k_firstname',
                    'a_familyname',
                    'a_firstname',
                    'email',
                    'tel',
                    'birthyear',
                    'birthmonth'
                ];
                // データ展開
                $array = array();
                foreach($tableLists as $table){
                    $array[$table] = h($_POST[$table]);
                }
                // var_dump($array);
                // exit();
                // 重複データの確認
                $res = $this->model->s_studentsSelect($array, '*');
                // 重複データ判定
                if($res){
                    // 重複データがあった場合
                    include('view.php');
                    $this->view = new VIEW;
                    echo '重複データあり';
                    exit();
                }else{
                    $res = $this->model->s_students($array, $tableLists);
                }
                
                if($res == null){
                    // student_id取得
                    $id = $this->model->s_studentsSelect($array, 'student_id');
                    
                    header('location: ../s_passgenerate.php?id='.$id['student_id']);
                    exit();
                }else{
                    echo 'データ登録でエラー発生';
                }
            }



        }

        ////////////////////////////////////////////////
        //password_sha256処理
        ////////////////////////////////////////////////

        // password_sha256処理
        private function password($password){
            // password sha256
            $password = h($password);
            $password = hash_hmac('sha256' ,$password , False);
            return $password;
        }

        // password_md5処理
        private function passmd5($password){
            $password = h($password);
            $password = md5($password);
            return $password;
        }

        ////////////////////////////////////////////////
        //login出来なかった処理
        ////////////////////////////////////////////////

        // login不可の場合
        private function login_judge($info){
            if($info == ''){
                echo 'ログイン出来ませんでした';
                exit();
            }
        }

        ////////////////////////////////////////////////
        //写真アップ処理
        ////////////////////////////////////////////////
        public function reSize($fileData){
            // width,height指定
            // $w = 400;
            // $h = 400;
            $keyScore = 400;

            // 加工するファイル指定
            $file = $fileData["tmp_name"];
            // 加工前の画像の情報を取得
            list($original_w, $original_h, $type) = getimagesize($file);

            // 縦長or横長の判定
            if($original_w > $original_h){
                $longLength = $original_w;
            }else{
                $longLength = $original_h;
            }
            
            // 基準値を超えている場合
            if($longLength > $keyScore){
                $stand = $longLength / $keyScore;
                $w = $original_w / $stand;
                $h = $original_h / $stand;
            }

            // var_dump($original_w, $original_h, $type);
            // exit();
            // 加工前のファイルをフォーマット別に読み出す（この他にも対応可能なフォーマット有り）
            switch ($type) {
                case IMAGETYPE_JPEG:
                    $original_image = imagecreatefromjpeg($file);
                    break;
                case IMAGETYPE_PNG:
                    $original_image = imagecreatefrompng($file);
                    break;
                case IMAGETYPE_GIF:
                    $original_image = imagecreatefromgif($file);
                    break;
                default:
                    throw new RuntimeException('対応していないファイル形式です。: ', $type);
            }

            // 新しく描画するキャンバスを作成
            $canvas = imagecreatetruecolor($w, $h);
            imagecopyresampled($canvas, $original_image, 0,0,0,0, $w, $h, $original_w, $original_h);

            $name = $fileData['name']; //ファイル名取得
            $extension = pathinfo($name, PATHINFO_EXTENSION); //拡張子取得(jpg, png, gif)
            $datetime = date("YmdHis"); //日付取得
            $uniq_name = $datetime."." . $extension;  //ユニークファイル名作成
            $file_dir_path = "../upload/";  //画像ファイル保管先

            // FileUpload [--Start--]
            if ( is_uploaded_file( $file ) ) {
                if ( move_uploaded_file( $file, $file_dir_path.$uniq_name ) ) {
                    chmod( $file_dir_path.$uniq_name, 0644 );

                    switch ($type) {
                        case IMAGETYPE_JPEG:
                            imagejpeg($canvas, $file_dir_path.$uniq_name);
                            break;
                        case IMAGETYPE_PNG:
                            imagepng($canvas, $file_dir_path.$uniq_name, 9);
                            break;
                        case IMAGETYPE_GIF:
                            imagegif($canvas, $file_dir_path.$uniq_name);
                            break;
                    }
        
                    // 読み出したファイルは消去
                    imagedestroy($original_image);
                    imagedestroy($canvas);
                    // return $file_dir_path.$uniq_name;
                    return $uniq_name;
                } else {
                    echo '<script>alert("写真変更ができませんでした");location.href="setting.php;</script>';
                }
            }
        }

    }

    $controller = new CONTROLLER;