<?php
    include('../mvc/data.php');

    class C_MODEL{
        function __construct(){
           $this->db = new DATA;
        }

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
            $this->db->insert($table, $column, $values);
            header('Location: http://'.$_SERVER["HTTP_HOST"].'/trackers/company/c_login.php');
            exit();
        }

        // ログイン処理
        public function login($array){
            $table = 'company_users';
            $column = '*';
            $conditions = 'WHERE `email` = '."'".$array['email']."'".
                            'AND `password` = '."'".$array['password']."'";
            $res = $this->db->select($column, $table, $conditions);
           return $res;
        }

        // チューター面談リスト取得
        public function interviewList(){
            $table = 'tuotorRegisters';
            $column = '*';
            $condictions = 'WHERE `result` = 0';
            $res = $this->db->selectAll($column, $table, $condictions);
            return $res;
        }
    }