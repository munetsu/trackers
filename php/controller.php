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
                    // 科目選択済みか判定
                    if($flag == 2){
                        // 選択済み
                        $url = 'main.php';
                        echo $url;    
                    }else{
                        // 科目未選択
                        $url = 'selectSubject.php';
                        echo $url;
                    }
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
            header('Location: http://'.$_SERVER["HTTP_HOST"].'/trackers/main.php');
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
        
            // // tuotorsテーブルの更新
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
            header('Location: http://'.$_SERVER["HTTP_HOST"].'/trackers/viewer.php');
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

        // // チューター詳細取得
        public function getTuotorList($array){
            $table = 'tuotors';
            $column = '*';
            $uid = $array[0];
            $age = $array[1];
            $conditions = 'WHERE `id` = '.$uid;
            $tuotor = $this->db->select($column,$table,$conditions);

            // 学歴取得
            $gakureki = $this->getTuotorDetail('gakurekis', 'level', $tuotor[0]['gakureki']);
            $tuotor[0]['gakureki'] = $gakureki[0]['level'];
            // 専攻取得
            $senkou = $this->getTuotorDetail('senkous','major', $tuotor[0]['senkou']);
            $tuotor[0]['senkou'] = $senkou[0]['major'];
            // ライフスタイル
            $lifestyle = $this->getTuotorDetail('lifestyles', 'style', $tuotor[0]['lifeStyle']);
            $tuotor[0]['lifeStyle'] = $lifestyle[0]['style'];
            // 勉強スタイル
            $studystyle = $this->getTuotorDetail('studystyles', 'style', $tuotor[0]['studyStyle']);
            $tuotor[0]['studyStyle'] = $studystyle[0]['style'];
            // 勉強タイプ
            $studytype = $this->getTuotorDetail('studytypes', 'type', $tuotor[0]['studyType']);
            $tuotor[0]['studyType'] = $studytype[0]['type'];
            // 性格
            $personality = $this->getTuotorDetail('personalitys', 'personal', $tuotor[0]['personality']);
            $tuotor[0]['personality'] = $personality[0]['personal'];

            // $tuotor = json_encode($tuotor, JSON_UNESCAPED_UNICODE);
            // var_dump($tuotor);
            // exit();
            // echo $tuotor;
            $this->view->tuotorRender($tuotor,$age);
        }

        // チューター各詳細の置き換え
        public function getTuotorDetail($table, $column, $level){
            $table= $table;
            $column = $column;
            $conditions = 'WHERE `id` = '.$level;
            $gakureki = $this->db->select($column, $table, $conditions);
            return $gakureki;
        }

        // 科目一覧取得
        public function subjectSelect(){
            $table = 'certifications';
            $column = '*';
            $conditions = '';
            $subjectLists = $this->db->select($column, $table, $conditions);
            return $subjectLists;
        }

        // 資格ごとのチューター情報取得
        public function subjectsTuotors($subId){
            $table = 'subjectsTuotorLists';
            $column = 'tuotor_id';
            $conditions = 'WHERE `certification_id` = '.$subId;
            $tuotorsLists = $this->db->select($column, $table, $conditions);
            var_dump($tuotorsLists);
            exit();
        }


    }