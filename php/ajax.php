<?php
    include('include/funcs.php');
    include('controller.php');
    class AJAX{
        function __construct(){
            $this->POST = $_POST['action'];
            $this->judge();
        }

        // POSTデータの文字列化処理
        private function post(){
            $array = array();
            $array[] = h($_POST['id']);
            $array[] = h($_POST['pass']);
            return $array;
        }

        // ajaxごとに振り分け
        public function judge(){
            // ログイン
            if($this->POST == 'login'){
                $array = $this->post();
                $this->cl = new CONTROLLER;
                return $this->cl->login($array);
            }
            // サインアップ処理
            if($this->POST == 'register'){
                $array = $this->post();
                $this->cl = new CONTROLLER;
                return $this->cl->signUp($array);
            }
                
        }
    }

    $ajax = new AJAX;
