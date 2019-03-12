<?php
    include('../../funcs/funcs.php');
    include('c_model.php');

    class C_CONTROLLER{
        function __construct(){
            $this->POST = $_POST['action'];
            $this->c_judge();
        }

        // 処理切り分け
        private function c_judge(){

            // 会社メンバー登録
            if($this->POST == 'signUp'){

                // password sha256
                $password = h($_POST['password']);
                $password = hash_hmac('sha256' ,$password , False);
                // データ配列化
                $array = array();
                $array['name'] = h($_POST['name']);
                $array['email'] = h($_POST['email']);
                $array['password'] = $password;

                // modelへデータ引き継ぎ
                $this->model = new C_MODEL;
                $this->model->signUp($array);

            }
        }


    }

    $c_controller = new C_CONTROLLER;