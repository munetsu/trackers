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

            // チューター面談登録
            if($this->POST == 'tuotorRegister'){
                // TuotorRegister処理
                $array = array();
                $array['name'] = h($_POST['name']); //名前
                $array['email'] = h($_POST['email']); //Gmail
                $array['tel'] = h($_POST['tel']); //電話番号
                $array['certification'] = h($_POST['certification']); //資格
                $array['firstDate'] = h($_POST['firstDate']); //第一候補日
                $array['ftime'] = h($_POST['ftime']); //第一候補時間
                $array['secondDate'] = h($_POST['secondDate']); //第二候補日
                $array['stime'] = h($_POST['stime']); //第二候補時間
                $array['thirdDate'] = h($_POST['thirdDate']); //第三候補日
                $array['ttime'] = h($_POST['ttime']); //第三候補時間
                // modelへデータ引き継ぎ
                $this->model = new MODEL;
                $this->model->tuotorRegister($array);
            }
        }

    }

    $controller = new CONTROLLER;