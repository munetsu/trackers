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
                $array['f_startTime'] = h($_POST['f_startTime']); //第一候補時間
                $array['f_finishTime'] = h($_POST['f_finishTime']); //第一候補時間
                $array['secondDate'] = h($_POST['secondDate']); //第二候補日
                $array['s_startTime'] = h($_POST['s_startTime']); //第二候補時間
                $array['s_finishTime'] = h($_POST['s_finishTime']); //第二候補時間
                $array['thirdDate'] = h($_POST['thirdDate']); //第三候補日
                $array['t_startTime'] = h($_POST['t_startTime']); //第三候補時間
                $array['t_finishTime'] = h($_POST['t_finishTime']); //第三候補時間
                // modelへデータ引き継ぎ
                $this->model = new MODEL;
                $this->model->tuotorRegister($array);
            }
        }

    }

    $controller = new CONTROLLER;