<?php
    include('../../mvc/data.php');

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
    }