<?php
    include('../funcs/funcs.php');
    include('model.php');

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
            //login.php
            ///////////////////////////////////////////

            // 仮ログイン
            if($this->POST == 'temp_login'){
                // データ展開
                $array = array();
                $array['status'] = h($_POST['status']);
                $array['email'] = h($_POST['email']);
                $array['password'] = h($_POST['password']);

                // modelへ引き継ぎ
                $info = $this->model->temp_login($array);
                
                // sessionへsecurity_code登録
                session_start();
                $_SESSION['security_code'] = $info['security_code'];
                
                // 初ログインの場合
                if($info['loginDate'] == NULL){
                    header('location: http://'.$_SERVER["HTTP_HOST"].'/trackers/tuotor_signUp.php?id='.$info['tuotor_id']);
                    exit();
                }else{
                    echo '工事中';
                    exit();
                }

            }

            // ログイン
            if($this->POST == 'login'){
                // password処理
                $password = h($_POST['password']);
                $password = $this->password($password);

                // データ展開
                $array = array();
                $array['email'] = $_POST['email'];
                $array['password'] = $password;

                // modelへ引き継ぎ
                $info =$this->model->login($array);

                // login判定
                $this->login_judge($info);

                // チューターMyPageへ
                header('location: http://'.$_SERVER["HTTP_HOST"].'/trackers/tuotor_mypage.php');
                exit();
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
                echo '登録完了';
                exit();
                
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
                    return $file_dir_path.$uniq_name;
                } else {
                    echo '<script>alert("写真変更ができませんでした");location.href="setting.php;</script>';
                }
            }
        }

    }

    $controller = new CONTROLLER;