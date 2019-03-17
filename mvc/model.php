<?php
    include('data.php');

    class MODEL{
        function __construct(){
            $this->db = new DATA;
        }

        //////////////////////////////////////
        //SELECT文
        //////////////////////////////////////

        // 仮ログイン処理
        public function temp_login($array){
            $table = $array['status'];
            $column = '*';
            $conditions = 'WHERE `email` ='."'".$array['email']."'".' AND `password`='."'".$array['password']."'";
            $info = $this->db->select($column, $table, $conditions);
            return $info;
        }

        // ログイン処理
        public function login($array){
            $table = 'tuotors';
            $column = '*';
            $conditions = 'WHERE `email` ='."'".$array['email']."'".'AND `password` ='."'".$array['password']."'";
            $info =$this->db->select($column, $table, $conditions);
            return $info;
        }

        // チューター情報取得
        public function tuotorInfo($id){
            $table = 'tuotors';
            $column = '*';
            $conditions = 'WHERE `tuotor_id` = '."'".$id."'";
            $info = $this->db->select($column, $table, $conditions);
            return $info;
        }

        // 資格取得
        public function certificationList($info){
            $table = 'certifications';
            $column = '*';
            $conditions = 'WHERE `certification_id`='."'".$info."'";
            $certificationList = $this->db->select($column, $table, $conditions);
            return $certificationList;
        }

        //////////////////////////////////////
        //SELECTALL文
        //////////////////////////////////////

        //////////////////////////////////////
        //INSERT文
        //////////////////////////////////////

        public function tuotorRegister($array){
            // データ開封
            // var_dump($array);
            // exit();

            // 送信時間
            $sendtime = date("Y/m/d H:i:s");

            $table = 'tuotorRegisters';
            $column = "`name`, 
                        `email`,
                         `tel`,
                         `certification`,
                         `firstDate`,
                         `ftime`,
                         `secondDate`,
                         `stime`,
                         `thirdDate`,
                         `ttime`,
                         `sendTime`";
            $values = "'".$array['name']."'".",".
                        "'".$array['email']."'".",".
                        "'".$array['tel']."'".",".
                        "'".$array['certification']."'".",".
                        "'".$array['firstDate']."'".",".
                        "'".$array['ftime']."'".",".
                        "'".$array['secondDate']."'".",".
                        "'".$array['stime']."'".",".
                        "'".$array['thirdDate']."'".",".
                        "'".$array['ttime']."'".",".
                        "'".$sendtime."'";
            $this->db->insert($table, $column, $values);

            header('location: http://'.$_SERVER["HTTP_HOST"].'/trackers/tuotor.php?status=registeredowksmdndjchfifu93744rfif8j4bfkd87jenf0f9iwlwls0s8wj2hdpdudn');
            exit();
        }


        //////////////////////////////////////
        //UPDATE文
        //////////////////////////////////////

        // チューター会員登録
        public function tuotorSignUp($array){
            $registerDate = Date("Y/m/d H:i:s");
            $table = 'tuotors';
            $values = '`c_name` ='."'".$array['c_name']."'".",".
                        '`k_name` ='."'".$array['k_name']."'".",".
                        '`email` ='."'".$array['email']."'".",".
                        '`password` ='."'".$array['password']."'".",".
                        '`tel` ='."'".$array['tel']."'".",".
                        '`picture` ='."'".$array['picture']."'".",".
                        '`birthyear` ='."'".$array['birthyear']."'".",".
                        '`birthmonth` ='."'".$array['birthmonth']."'".",".
                        '`loginDate` ='."'".$registerDate."'";
            $conditions = 'WHERE `tuotor_id` ='."'".$array['tuotor_id']."'";
            $this->db->update($table, $values, $conditions);
        }












    }