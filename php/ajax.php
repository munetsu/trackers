<?php
    include('include/funcs.php');
    include('view.php');
    class AJAX{
        function __construct(){
            $this->POST = $_POST['action'];
            $this->judge();
        }

        // サインアップ処理
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
                $this->view = new VIEW;
                return $this->view->tuotor($array);
            }
            // サインアップ処理
            if($this->POST == 'register'){
                $array = $this->post();
                $this->view = new VIEW;
                return $this->view->signUp($array);
            }
                
        }
    }

    $ajax = new AJAX;
