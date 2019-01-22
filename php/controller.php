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
            $flag = $user['flag'];
            if($flag == 0){
                $_SESSION['id'] = $user['id'];
            }else{
                // チューターか生徒か判定
                $status = $user['status'];
                if($status == 1){
                    // チューター
                }else{
                    // 生徒
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
                        "'".date("Y/m/d H:i:s")."'";
            $this->db->insert($tables,$column,$value);
            header('Location: http://'.$_SERVER["HTTP_HOST"].'/trackers/main.php');
            exit();
        }


    }