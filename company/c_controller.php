<?php
    include('../funcs/funcs.php');
    include('c_model.php');
    include('c_view.php');

    class C_CONTROLLER{
        function __construct(){
            $this->model = new C_MODEL;
            $this->view = new C_VIEW;
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

        /////////////////////////////////////////////
        //処理切り分け
        /////////////////////////////////////////////
        private function c_judge(){

            /////////////////////////////////////////////
            //c_login.php処理
            /////////////////////////////////////////////

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
                // $this->model = new C_MODEL;
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
                // $this->model = new C_MODEL;
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

            /////////////////////////////////////////////
            //c_adminPage.php処理
            /////////////////////////////////////////////

            // 面談日程確定
            if($this->POST == 'interviewConfirm'){
                $array = array();
                $array['tuotorRegisterId'] = $_POST['tuotorRegisterId'];
                $array['interviewDate'] = $_POST['interviewDate'];
                // modelへデータ引き継ぎ
                // $this->model = new C_MODEL;
                $this->model->interviewConfirm($array);

                header('Location: http://'.$_SERVER["HTTP_HOST"].'/trackers/company/c_adminPage.php');
                exit();
            }

            //////////////////////////////////////////////
            // c_tuotor.php処理
            /////////////////////////////////////////////

            // 日程調整前リスト
            if($this->POST == 'beforeAjax'){
                $lists = $this->model->interviewList();
                // viewへ引き継ぎ
                // include('c_view.php');
                // $this->view = new C_VIEW;
                $this->view->tuotorList($lists);
            }

            // 面談リスト
            if($this->POST == 'interviewAjax'){
                // modelへ引き継ぎ
                $lists = $this->model->examTuotor();
                // viewへ引き継ぎ
                // include('c_view.php');
                // $this->view = new C_VIEW;
                $this->view->interviewTuotor($lists);
            }

            // 合格判定結果処理
            if($this->POST == 'exam'){
                // データ引き継ぎ
                $array = array();
                $array['tuotorId'] = $_POST['tuotorId'];
                $array['result'] = $_POST['result'];
            
                // modelへ引き継ぎ
                // 合格登録
                $this->model->examResult($array);
                // 合格者情報取得
                $info = $this->model->examOk($_POST['tuotorId']);
                
                // viewへ引き継ぎ
                $this->view->examOkTuotor($info);

            }

            // 合格チューター登録
            if($this->POST == 'tuotorResitor'){
                // データ引き継ぎ
                $array = array();
                $array['c_name'] = $_POST['name'];
                $array['email'] = $_POST['email'];
                $array['tel'] = $_POST['tel'];

                // security_code作成
                $security1 = $this->password($_POST['email']);
                $security2 = $this->password($_POST['tel']);
                $temp = date("Ymd");
                $security3 = $this->password($temp);
                $array['security_code'] = $security1.$security2.$security3;

                // modelへ引き継ぎ
                $this->model->tuotorRegister($array);
            }

            // チューター一覧
            if($this->POST == 'tuotorListAjax'){
                // modelへ引き継ぎ
                $lists = $this->model->tuotorList();
                // var_dump($lists);
                // exit();
                // viewへ引き継ぎ
                $this->view->tuotors($lists);
            }

            

        }


    }

    $c_controller = new C_CONTROLLER;