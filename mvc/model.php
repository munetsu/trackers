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
        public function tuotorInfo($id, $column){
            $table = 'tuotors';
            $column = $column;
            $conditions = 'WHERE `tuotor_id` ='.$id;
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

        // 勉強法登録検索
        public function studyhowSelect($tuotor_id, $monthly){
            $table = 'studyHows';
            $column = 'monthly';
            $monthList = array();
            foreach($monthly as $month){
                $conditions = 'WHERE `tuotor_id` ='.$tuotor_id.' AND `monthly` ='."'".$month."'";
                $res = $this->db->select($column, $table, $conditions);
                if($res == ''){
                    // 未登録月
                    array_push($monthList, $month);
                }
            }
            return $monthList;
        }

        //////////////////////////////////////
        //SELECTALL文
        //////////////////////////////////////
        // howtoリスト
        public function howtoMonth($id, $select){
            $table= 'studyHows';
            $column = $select;
            $conditions = 'WHERE `tuotor_id`='.$id;
            $monthLists = $this->db->selectAll($column, $table, $conditions);
            return $monthLists;
        }

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

        public function booklist($array){
            $table = 'booklists';
            if($array['count'] == 1){
                $column = "`tuotor_id`,
                        `title1`,
                        `imageUrl1`";
                $values = "'".$array['tuotor_id']."'".",".
                            "'".$array['title1']."'".",".
                            "'".$array['imageUrl1']."'";
            }else if($array['count'] == 2){
                $column = "`tuotor_id`,
                        `title1`,
                        `imageUrl1`,
                        `title2`,
                        `imageUrl2`";
                $values = "'".$array['tuotor_id']."'".",".
                            "'".$array['title1']."'".",".
                            "'".$array['imageUrl1']."'".",".
                            "'".$array['title2']."'".",".
                            "'".$array['imageUrl2']."'";
            }else{
                $column = "`tuotor_id`,
                        `title1`,
                        `imageUrl1`,
                        `title2`,
                        `imageUrl2`,
                        `title3`,
                        `imageUrl3`";
                $values = "'".$array['tuotor_id']."'".",".
                            "'".$array['title1']."'".",".
                            "'".$array['imageUrl1']."'".",".
                            "'".$array['title2']."'".",".
                            "'".$array['imageUrl2']."'".",".
                            "'".$array['title3']."'".",".
                            "'".$array['imageUrl3']."'";
            }
            $this->db->insert($table, $column, $values);
        }

        // studyhow部分(from:controller.php)
        public function tuotor_studyhow($array){
            $datetime = date("Y/m/d"); //日付取得
            $booklists = $array['booklists'];
            $howtolists = $array['howtolists'];
            $columnlist = '';
            $valuelist = '';
            for($i = 0;$i<count($booklists);$i++){
                $columnlist .= "`kind".$i."`,
                                `title".$i."`,
                                `imageUrl".$i."`,
                                `authors".$i."`,
                                `howto".$i."`,";
                $valuelist .= "'".h($booklists[$i]['kind'])."'".",".
                            "'".h($booklists[$i]['title'])."'".",".
                            "'".h($booklists[$i]['imageUrl'])."'".",".
                            "'".h($booklists[$i]['authors'])."'".",".
                            "'".h($howtolists[$i]['content'])."'".",";
            }
            
            $table = 'studyHows';
            $column = "`tuotor_id`,
                        `weektime`,
                        `weekday`,
                        `holidaytime`,
                        `holiday`,
                        ".$columnlist."                       
                        `registerDate`,
                        `monthly`
                    ";
            
            foreach($array['monthly'] as $monthly){
                $values = "'".$array['tuotor_id']."'".",".
                        "'".$array['weektime']."'".",".
                        "'".$array['weekday']."'".",".
                        "'".$array['holidaytime']."'".",".
                        "'".$array['holiday']."'".",".
                        $valuelist.
                        "'".$datetime."'".",".
                        "'".h($monthly)."'";
                // var_dump($column."::://".$values.",,,,".$monthly);
                $this->db->insert($table, $column, $values);
            }
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