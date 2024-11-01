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
                    header('Location: ../company/c_top.php');
                    exit();
                }

            }

            /////////////////////////////////////////////
            //c_adminPage.php処理
            /////////////////////////////////////////////

            // 面談日程確定
            if($this->POST == 'interviewConfirm'){
                $array = array();
                $array['tuotorRegisterId'] = h($_POST['tuotorRegisterId']);
                $array['interviewDate'] = h($_POST['interviewDate']);
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
                $array['tuotorId'] = h($_POST['tuotorId']);
                $array['result'] = h($_POST['result']);
            
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
                $array['c_name'] = h($_POST['name']);
                $array['email'] = h($_POST['email']);
                $array['tel'] = h($_POST['tel']);

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

            //////////////////////////////////////////////
            // c_certification.php処理
            /////////////////////////////////////////////

            // 資格登録
            if($this->POST == 'certification'){
                $certifiction = h($_POST['certification']);

                // modelへ引き継ぎ
                $this->model->certificationRegister($certifiction);
                header('Location: http://'.$_SERVER["HTTP_HOST"].'/trackers/company/c_certification.php');
            }

            //////////////////////////////////////////////
            // チューター登録承認処理
            /////////////////////////////////////////////
            if($this->POST == 'ok'){
                // データ展開
                $tuotor_id = h($_POST['id']);
                $step = 3;

                // modelへ引き継ぎ
                // step更新
                $this->model->tuotorOk($tuotor_id, $step);

                // メール送信
                $to = h($_POST['email']);
                $from = 'info@trackers.co.jp';
                $subject = '【Trackers】ご登録ありがとうございました';
                $message = ''
                    ."\n"
                    ."身分証明書等の送付ありがとうございました。\n"
                    ."ご確認させていただきました。\n"
                    ."続いて、資格試験の勉強方法に関してのご登録をお願いします。\n"
                    ."====================================\n"
                    ."【ログインページ】\n"
                    .'<a href="http://trackers.co.jp/trackers/login.php?status=tuotor">\n
                    http://yumefukuro.sakura.ne.jp/trackers/login.php?status=tuotor</a>\n'
                    ."ご不明点等ございましたら、下記アドレスまでご連絡ください\n"
                    ."連絡先：info@trackers.co.jp\n"
                    ."====================================\n"
                    ;
                $this->model->sendEmail($to, $from, $subject, $message);
            }

            ///////////////////////////////////////////////
            // booklist取得
            //////////////////////////////////////////////
            if($this->POST == 'bookedit'){
                $id = h($_POST['id']);
                // modelへ
                $table = 't_booklists';
                $column = '*';
                $where = 'WHERE `tuotor_id` ='."'".$id."'";
                $booklists = $this->model->selectFree($table, $column, $where);
                $booklists = json($booklists);
                echo $booklists;
            }

            ///////////////////////////////////////////////
            // booklist登録
            //////////////////////////////////////////////
            if($this->POST == 'booklist'){
                $tuotor_id = $_POST['tuotor_id'];
                $booklists = $_POST['bookInfoLists'];
                // modelへ
                $this->model->booklistsRegister($tuotor_id, $booklists);

                // step更新
                $step = 10;
                $this->model->tuotorOk($tuotor_id, $step);
            }

            ///////////////////////////////////////////////
            // howto詳細取得
            //////////////////////////////////////////////
            if($this->POST == 'getHowto'){
                $howto_id = $_POST['howto_id'];
                
                // modelへ
                $table = 't_howtos';
                $column = '*';
                $where = 'WHERE `howto_id` ='."'".$howto_id."'";
                $howto = $this->model->anyselect($table, $column, $where);
                
                
                // textデータ取得
                $textlist = array();
                for($i = 1;$i<11;$i++){
                    if($howto['text'.$i] == null){
                        break;
                    }else{
                        array_push($textlist,$howto['text'.$i]);
                    }
                }
                
                // modelへ
                $booklists = array();
                $table = 'booklists';
                $column = '`title`, `imageUrl`';
                foreach($textlist as $text){
                    if($text == 0){
                        $noimage = array();
                        $noimage['title'] = "指定教材";
                        $noimage['imageUrl'] = '<img src="../img/school.png" >';
                        array_push($booklists, $noimage);
                        continue;
                    }
                    $where = 'WHERE `booklist_id` ='."'".$text."'";
                    $res = $this->model->anyselect($table, $column, $where);
                    array_push($booklists, $res);
                }
                $array = array();
                array_push($array, $howto);
                array_push($array, $booklists);
                $array = json($array);
                echo $array;
            }

            ///////////////////////////////////////////////
            // howto承認処理
            //////////////////////////////////////////////
            if($this->POST == 'howtoJudge'){
                $howto_id = h($_POST['howto_id']);
                // modelへ引き継ぎ
                $table = 't_howtos';
                $values = '`agree` =  20';
                $where = 'WHERE `howto_id` ='."'".$howto_id."'";
                $this->model->anyUpdate($table, $values, $where);
            }

            ///////////////////////////////////////////////
            // howto不承認処理
            //////////////////////////////////////////////
            if($this->POST == 'Nohowto'){
                $howto_id = h($_POST['howto_id']);
                $reason = h($_POST['reason']);
                
                // modelへ
                $table = 't_howtos';
                $values = '`agree` = 2 , `comment` = '."'".$reason."'";
                $where = 'WHERE `howto_id` ='."'".$howto_id."'";
                $this->model->anyUpdate($table, $values, $where);
            }
        }


    }

    $c_controller = new C_CONTROLLER;