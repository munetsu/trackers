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

        // t_tuotor登録情報の照合
        public function t_tuotorsSelect($array, $column){
            $table = 't_tuotors';
            $column = $column;
            $conditions = 'WHERE `email` = '."'".$array['email']."'".'AND `tel` = '."'".$array['tel']."'";
            $res = $this->db->select($column, $table, $conditions);
            return $res;
        }

        // t_tuotor登録情報照合(id検索)
        public function t_tuotorsAnySelect($column, $where){
            $table = 't_tuotors';
            $column = $column;
            $conditions = $where;
            $res = $this->db->select($column, $table, $conditions);
            return $res;
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

        // t_signUpのチューター登録処理
        public function t_tuotors($array, $tableLists){
            //日付取得
            $datetime = Date("Y/m/d H:i:s"); 
            $code = $array['email'].$datetime.$array['a_familyname'];
            // security_code処理
            $security_code = hash_hmac('sha256' ,$code, False);
            // DB登録処理
            $table = 't_tuotors';
            $column = '';
            $values = '';
            foreach($tableLists as $tableList){
                $column .= "`".$tableList."`,";
                $values .= "'".$array[$tableList]."'".",";
            }
            $column .= "`registerDate`,`security_code`";
            $values .= "'".$datetime."'".","."'".$security_code."'";
            $res = $this->db->insert($table, $column, $values);
            // sessionスタート
            session_start();
            $_SESSION['security_code'] = $security_code;
            return $res;
        }

        // t_signUp2_book登録
        public function bookRegister($tuotor_id, $array){
            $table = 't_booklists';
            $column = '';
            $values = '';
            $count = 1;
            $minus = -1;
            
            foreach($array as $book){
                if($count == 1){
                    $column .= "`title".$count.'`,';
                    $values .= "'".$book."'".",";
                }else if($count % 2 != 0){
                    $column .= "`title".($count+$minus).'`,';
                    $values .= "'".$book."'".",";
                    $minus--;
                }else{
                    $column .= "`imageUrl".($count+$minus).'`,';
                    $values .= "'".$book."'".",";
                }
                $count++;
            }
            $column .= '`tuotor_id`';
            $values .= "'".$tuotor_id."'";
            $this->db->insert($table, $column, $values);
        }

        // t_signUp3_book登録
        public function appRegister($tuotor_id, $array){
            $table = 't_applists';
            $column = '';
            $values = '';
            $count = 1;
            $minus = -1;
            
            foreach($array as $app){
                if($count == 1){
                    $column .= "`sp".$count.'`,';
                    $values .= "'".$app."'".",";
                }else if($count % 2 != 0){
                    $column .= "`sp".($count+$minus).'`,';
                    $values .= "'".$app."'".",";
                    $minus--;
                }else{
                    $column .= "`app".($count+$minus).'`,';
                    $values .= "'".$app."'".",";
                }
                $count++;
            }
            $column .= '`tuotor_id`';
            $values .= "'".$tuotor_id."'";
            $this->db->insert($table, $column, $values);
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

        // パスワード登録
        public function tuotorUpdate($password, $tuotor_id){
            $table = 't_tuotors';
            $values = '`password` ='."'".$password."'";
            $conditions = 'WHERE `tuotor_id` ='.$tuotor_id;
            $this->db->update($table, $values, $conditions);
        }












    }