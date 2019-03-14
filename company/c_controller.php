<?php
    include('../funcs/funcs.php');
    include('c_model.php');

    class C_CONTROLLER{
        function __construct(){
            $this->POST = $_POST['action'];
            $this->c_judge();
        }

        // password_sha256処理
        private function password($password){
            // password sha256
            $password = h($password);
            $password = hash_hmac('sha256' ,$password , False);
            return $password;
        }

        // 処理切り分け
        private function c_judge(){

            // 会社メンバー登録
            if($this->POST == 'signUp'){

                // password sha256
                $password = $this->password($_POST['password']);

                // データ配列化
                $array = array();
                $array['name'] = h($_POST['name']);
                $array['email'] = h($_POST['email']);
                $array['password'] = $password;

                // modelへデータ引き継ぎ
                $this->model = new C_MODEL;
                $this->model->signUp($array);

            }

            // ログイン処理
            if($this->POST == 'login'){

                // password_sha256
                $password = $this->password($_POST['password']);
                // データ配列
                $array = array();
                $array['email'] = h($_POST['email']);
                $array['password'] = $password;

                // modelへ引き継ぎ
                $this->model = new C_MODEL;
                $res = $this->model->login($array);

                // 条件分岐
                if(!$res){
                    echo 'ログインエラー';
                    exit();
                }else{
                    header('Location: http://'.$_SERVER["HTTP_HOST"].'/trackers/company/c_adminPage.php');
                    exit();
                }

            }
        }


    }

    $c_controller = new C_CONTROLLER;