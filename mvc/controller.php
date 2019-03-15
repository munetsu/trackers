<?php
    include('../funcs/funcs.php');
    include('model.php');

    class CONTROLLER{
        function __construct(){
            $this->model = new MODEL;
            $this->POST = $_POST['action'];
            $this->judge();
        }

        // 処理切り分け
        private function judge(){

            ///////////////////////////////////////////
            //tuotorRegister.php
            ///////////////////////////////////////////

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
                // $this->model = new MODEL;
                $this->model->tuotorRegister($array);
            }

            ///////////////////////////////////////////
            //login.php
            ///////////////////////////////////////////

            // ログイン
            if($this->POST == 'login'){
                // データ展開
                $array = array();
                $array['status'] = $_POST['status'];
                $array['email'] = $_POST['email'];
                $array['password'] = $_POST['password'];

                // modelへ引き継ぎ
                $info = $this->model->login($array);
                
                // 初ログインの場合
                if($info['loginDate'] == NULL){
                    header('location: http://'.$_SERVER["HTTP_HOST"].'/trackers/tuotor_signUp.php?id='.$info['tuotor_id']);
                    exit();
                }else{
                    echo '工事中';
                    exit();
                }

            }

        }

    }

    $controller = new CONTROLLER;