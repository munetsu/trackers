<?php
    // DATAクラス引き継ぎ
    include('data.php');

    class CONTROLLER{
        function __construct(){
            $this->db = new DATA;
        }

        // 会員登録操作
        public function signUp($array){
            $column = 'email'.','.'password'.','.'datetime';
            $value = "'".$array[0]."'".','."'".$array[1]."'".','."'".date("Y/m/d")."'";
            $table = 'users';
            $this->db->insert($table, $column, $value);
        }

        // ログイン操作
        public function login($array){

        }


    }