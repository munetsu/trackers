<?php
    include('../funcs/funcs.php');
    include('model.php');

    class CONTROLLER{
        function __construct(){
            $this->POST = $_POST['action'];
            $this->judge();
        }

        // 処理切り分け
        private function judge(){

            if($this->POST == 'tuotorRegister'){
                // TuotorRegister処理
                $array = array();
                $array[] = h($_POST['name']); //名前
                $array[] = h($_POST['email']); //Gmail
                $array[] = h($_POST['tel']); //電話番号
                $array[] = h($_POST['certification']); //資格
                $array[] = h($_POST['firstDay']); //第一候補日
                $array[] = h($_POST['firstTime']); //第一候補時間
                $array[] = h($_POST['secondDay']); //第二候補日
                $array[] = h($_POST['secondTime']); //第二候補時間
                $array[] = h($_POST['thirdDay']); //第三候補日
                $array[] = h($_POST['thirdTime']); //第三候補時間

                // modelへデータ引き継ぎ
                $this->model = new MODEL;
                $this->model->tuotorRegister($array);
            }
        }

    }

    $controller = new CONTROLLER;