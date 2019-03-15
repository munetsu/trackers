<?php
    include('data.php');

    class MODEL{
        function __construct(){
            $this->db = new DATA;
        }

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

        // ログイン処理
        public function login($array){
            $table = $array['status'];
            $column = '*';
            $conditions = 'WHERE `email` ='."'".$array['email']."'".' AND `password`='."'".$array['password']."'";
            $info = $this->db->select($column, $table, $conditions);
            return $info;
        }












    }