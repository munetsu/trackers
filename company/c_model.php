<?php
    include('c_data.php');

    class C_MODEL{
        function __construct(){
           $this->db = new DATA;
        }

        /////////////////////////////////////////
        //SELECT文(1件分のみ)
        /////////////////////////////////////////

        // ログイン処理
        public function login($array){
            $table = 'company_users';
            $column = '*';
            $conditions = 'WHERE `email` = '."'".$array['email']."'".
                            'AND `password` = '."'".$array['password']."'";
            $res = $this->db->select($column, $table, $conditions);
            return $res;
        }

        // 合格登録チューター情報
        public function examOk($id){
            $table = 'tuotorRegisters';
            $column = '*';
            $conditions = 'WHERE `id` ='."'".$id."'".'AND `result` = 2';
            $res = $this->db->select($column, $table, $conditions);
            return $res;
        }

        // select文
        public function anyselect($table, $column, $conditions){
            $table = $table;
            $column = $column;
            $conditions = $conditions;
            $res = $this->db->select($column, $table, $conditions);
            return $res;
        }


        /////////////////////////////////////////
        //SELECT文(複数件)
        /////////////////////////////////////////

        // 日程調整リスト取得
        public function interviewList(){
            $table = 'tuotorRegisters';
            $column = '*';
            $condictions = 'WHERE `result` = 0 AND `interviewDate` is NULL';
            $res = $this->db->selectAll($column, $table, $condictions);
            return $res;
        }

        // チューター面談リスト
        public function examTuotor(){
            $table = 'tuotorRegisters';
            $column = '*';
            $conditions = 'WHERE `interviewDate` is NOT Null AND `result` = 0';
            $res = $this->db->selectAll($column, $table, $conditions);
            return $res;
        }

        // チューター登録者一覧
        public function tuotorList(){
            $table = 'tuotors';
            $column = '*';
            $conditions = '';
            $lists = $this->db->selectAll($column, $table, $conditions);
            return $lists;
        }

        // GroupBySelect
        public function countGroupBy($table, $col){
            $table = $table;
            $column = '`'.$col.'`, COUNT("*")';
            $conditions = 'GROUP BY `'.$col.'`';
            $num = $this->db->selectAll($column, $table, $conditions);
            return $num;
        }

        // selectFree
        public function selectFree($table, $column, $where){
            $table = $table;
            $column = $column;
            $conditions = $where;
            $res = $this->db->selectAll($column, $table, $conditions);
            return $res;
        }

        /////////////////////////////////////////
        //INSERT文
        /////////////////////////////////////////

        // 新規ユーザー登録
        public function signUp($array){
            $registerTime = date("Y/m/d H:i:s");
            $table = 'company_users';
            $column = "`name`,
                        `email`,
                        `password`,
                        `datetime`";
            $values = "'".$array['name']."'".",".
                        "'".$array['email']."'".",".
                        "'".$array['password']."'".",".
                        "'".$registerTime."'";
            var_dump($values);
            $this->db->insert($table, $column, $values);
            header('Location: http://'.$_SERVER["HTTP_HOST"].'/trackers/company/c_login.php');
            exit();
        }

        // 合格チューター登録
        public function tuotorRegister($array){
            $registerTime = date("Y/m/d H:i:s");
            $password = mt_rand();

            $table = 'tuotors';
            $column = "`c_name`,
                        `email`,
                        `password`,
                        `tel`,
                        `picture`,
                        `security_code`,
                        `registerDate`";
            $values = "'".$array['c_name']."'".",".
                        "'".$array['email']."'".",".
                        "'".$password."'".",".
                        "'".$array['tel']."'".",".
                        '"../upload/noimage.svg"'.','.
                        "'".$array['security_code']."'".",".
                        "'".$registerTime."'";
            $this->db->insert($table, $column, $values);
            header('Location: http://'.$_SERVER["HTTP_HOST"].'/trackers/company/c_tuotor.php');
            exit();
        }

        // 資格登録
        public function certificationRegister($certification){
            $table = 'certifications';
            $column = "`certification_kind`";
            $values = "'".$certification."'";
            $this->db->insert($table, $column, $values);
        }

        // booklists登録
        public function booklistsRegister($tuotor_id, $booklists){
            $table = 'booklists';
            $columns = '`tuotor_id`,
                        `title`,
                        `imageUrl`,
                        `isbn`,
                        `link`'; 
            // データ展開
            foreach($booklists as $book){
                // 重複確認
                $table = 'booklists';
                $column = 'isbn';
                $where = 'WHERE `tuotor_id` ='."'".$tuotor_id."'".'AND `isbn` = '."'".$book['isbn']."'";
                $info = $this->selectFree($table, $column, $where);
                if($info != null){
                    continue;
                }
                $values = "'".$tuotor_id."'".",";
                $values .= "'".$book['title']."'".",";
                $values .= "'".$book['imageUrl']."'".",";
                $values .= "'".$book['isbn']."'".",";
                $values .= "'".$book['link']."'";
                $this->db->insert($table, $columns, $values);
            }
        }

        /////////////////////////////////////////
        //UPDATE文
        /////////////////////////////////////////

        // チューター面談日程確定
        public function interviewConfirm($array){
            $table = 'tuotorRegisters';
            $values = '`interviewDate` = '."'".$array['interviewDate']."'";
            $conditions = 'WHERE `id`='."'".$array['tuotorRegisterId']."'";
            $this->db->update($table, $values, $conditions);
        }


        // チューター合否更新
        public function examResult($array){
            $table = 'tuotorRegisters';
            $values = '`result` = '."'".$array['result']."'";
            $conditions = 'WHERE `id` ='."'".$array['tuotorId']."'";
            $this->db->update($table, $values, $conditions);
        }

        // チューター承認
        public function tuotorOk($tuotor_id, $step){
            $table = 't_tuotors';
            $values = '`step` ='."'".$step."'";
            $conditions = 'WHERE `tuotor_id` ='."'".$tuotor_id."'";
            $this->db->update($table, $values, $conditions);
        }

        // update処理
        public function anyUpdate($table, $values, $where){
            $table = $table;
            $values = $values;
            $conditions = $where;
            $this->db->update($table, $values, $conditions);
        }

        /////////////////////////////////////////////////////////
        // DB操作以外
        //////////////////////////////////////////////////////////
        // メール送信
        public function sendEmail($to, $from, $subject, $message){
            // ヘッダー処理
            $header = "From: {$from}\r\n";
            $header.= "\n";
            $header.= "Bcc: info@trackers.co.jp";

            // 送信処理
            mb_language('ja');
            mb_internal_encoding('UTF-8');
            if(mb_send_mail($to, $subject, $message, $header)){
                echo 'メール送信に成功致しました。';
            }else{
                echo 'メール送信に失敗致しました。';
            }
        }
    }