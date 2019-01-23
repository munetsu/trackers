<?php
    session_start();
    // DATAクラス引き継ぎ
    include('data.php');
    include('view.php');

    class CONTROLLER{
        function __construct(){
            $this->db = new DATA;
            $this->view = new VIEW;
        }

        // 会員登録操作
        public function signUp($array){
            $column = 'email'.','.'password'.','.'datetime';
            $values = "'".$array[0]."'".','."'".$array[1]."'".','."'".date("Y/m/d")."'";
            $table = 'users';
            $this->db->insert($table, $column, $values);
            $this->view->login();
        }

        // ログイン操作
        public function login($array){
            $table = 'users';
            $column = '*';
            $mail = $array[0];
            $pass = $array[1];
            $conditions = 'WHERE `email` = '."'".$mail."'".' AND `password` = '."'".$pass."'";
            $user = $this->db->select($column,$table,$conditions);
            
            // 初回ログインかどうかを確認
            $flag = $user[0]['flag'];
            if($flag == 0){
                $_SESSION['id'] = $user[0]['id'];
                $url = 'signUp.php';
                echo $url;
            }else{
                // チューターか生徒か判定
                $status = $user[0]['status'];
                if($status == 1){
                    // 生徒
                    $url = 'main.php';
                    echo $url;
                }else{
                    // チューター
                }
            }
        }

        // サインアップ操作
        public function register($array){
            // userテーブルの更新
            $uid = $array[0];
            $table = 'users';
            $values = '`flag` = 1 , `status` = 1';
            $conditions = 'WHERE `id` = '."'".$uid."'";
            $this->db->update($table, $values, $conditions);
        
            // // studentsテーブルの更新
            $tables = 'Students';
            $column = 'user_id,
                        familyNameCharacter,
                        firstNameCharacter,
                        familyNameKana,
                        firstNameKana,
                        img,
                        year,
                        month,
                        day,
                        gender,
                        gakureki,
                        senkou,
                        born,
                        lifeStyle,
                        studyStyle,
                        studyType,
                        personality,
                        timestamp';
            $value = "'".$uid."'".','.
                        "'".$array[1]."'".','.
                        "'".$array[2]."'".','.
                        "'".$array[3]."'".','.
                        "'".$array[4]."'".','.
                        "'".$array[5]."'".','.
                        "'".$array[6]."'".','.
                        "'".$array[7]."'".','.
                        "'".$array[8]."'".','.
                        "'".$array[9]."'".','.
                        "'".$array[10]."'".','.
                        "'".$array[11]."'".','.
                        "'".$array[12]."'".','.
                        "'".$array[13]."'".','.
                        "'".$array[14]."'".','.
                        "'".$array[15]."'".','.
                        "'".$array[16]."'".','.
                        "'".date("Y/m/d H:i:s")."'";
            $this->db->insert($tables,$column,$value);
            $lists = $this->tuotorsList();
            header('Location: http://'.$_SERVER["HTTP_HOST"].'/trackers/main.php?'.$lists);
            exit();
        }

        // チューターサインアップ操作
        public function tuotorRegister($array){
            // userテーブルの更新
            $uid = $array[0];
            $table = 'users';
            $values = '`flag` = 1 , `status` = 2';
            $conditions = 'WHERE `id` = '."'".$uid."'";
            $this->db->update($table, $values, $conditions);
        
            // // studentsテーブルの更新
            $tables = 'tuotors';
            $column = 'user_id,
                        familyNameCharacter,
                        firstNameCharacter,
                        familyNameKana,
                        firstNameKana,
                        img,
                        year,
                        month,
                        day,
                        gender,
                        gakureki,
                        senkou,
                        born,
                        lifeStyle,
                        studyStyle,
                        studyType,
                        personality,
                        datetime';
            $value = "'".$uid."'".','.
                        "'".$array[1]."'".','.
                        "'".$array[2]."'".','.
                        "'".$array[3]."'".','.
                        "'".$array[4]."'".','.
                        "'".$array[5]."'".','.
                        "'".$array[6]."'".','.
                        "'".$array[7]."'".','.
                        "'".$array[8]."'".','.
                        "'".$array[9]."'".','.
                        "'".$array[10]."'".','.
                        "'".$array[11]."'".','.
                        "'".$array[12]."'".','.
                        "'".$array[13]."'".','.
                        "'".$array[14]."'".','.
                        "'".$array[15]."'".','.
                        "'".$array[16]."'".','.
                        "'".date("Y/m/d H:i:s")."'";
            $this->db->insert($tables,$column,$value);
            header('Location: http://'.$_SERVER["HTTP_HOST"].'/trackers/main.php');
            exit();
        }

        // 写真アップロード処理
        public function photoUpload($photo,$photourl,$uid){
            //情報取得
            $file_name = $photo;         //"1.jpg"ファイル名取得
            $tmp_path  = $photourl; //"/usr/www/tmp/1.jpg"アップロード先のTempフォルダ
            $file_dir_path = "../upload/";  //画像ファイル保管先
    
            //***File名の変更***
            $extension = pathinfo($file_name, PATHINFO_EXTENSION); //拡張子取得(jpg, png, gif)
            $datetime = date("YmdHis");
            $uniq_name = $uid . $datetime."." . $extension;  //ユニークファイル名作成
            // $file_name = $file_dir_path.$uniq_name; //ユニークファイル名とパス
        
            // FileUpload [--Start--]
            if ( is_uploaded_file( $tmp_path ) ) {
                if ( move_uploaded_file( $tmp_path, $file_dir_path.$uniq_name ) ) {
                    chmod( $file_dir_path.$uniq_name, 0644 );
                    return 'upload/'.$uniq_name;
                } else {
                    echo '<script>alert("写真変更ができませんでした");location.href="setting.php;</script>';
                }
            }
        // FileUpload [--End--]
        }

        // チューター一覧取得
        public function tuotorsList(){
            $table = 'tuotors';
            $column = '*';
            $conditions = '';
            $lists = $this->db->select($column, $table, $conditions);
            return $lists;
        }


    }