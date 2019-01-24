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
                $this->cl->login($array);
            }

            // 会員登録処理
            if($this->POST == 'register'){
                $array = $this->post();
                $this->cl = new CONTROLLER;
                return $this->cl->signUp($array);
            }
            
            // サインアップ処理
            if($this->POST == 'signUp'){
                // 写真アップロード処理
                if (isset($_FILES["upfile"] ) && $_FILES["upfile"]["error"] ==0 ) {
                    $uid = h($_POST['uid']);
                    $photo = $_FILES["upfile"]["name"];
                    $photourl = $_FILES["upfile"]["tmp_name"];
                    $this->cl = new CONTROLLER;
                    $photo = $this->cl->photoUpload($photo,$photourl,$uid);
                }

                // ユーザーデータ更新
                $array = array();
                $array[] = h($_POST['uid']);
                $array[] = h($_POST['familyNameCharacter']);
                $array[] = h($_POST['firstNameCharacter']);
                $array[] = h($_POST['familyNameKana']);
                $array[] = h($_POST['firstNameKana']);
                $array[] = $photo;
                $array[] = h($_POST['year']);
                $array[] = h($_POST['month']);
                $array[] = h($_POST['day']);
                $array[] = h($_POST['gender']);
                $array[] = h($_POST['gakureki']);
                $array[] = h($_POST['senkou']);
                $array[] = h($_POST['born']);
                $array[] = h($_POST['lifeStyle']);
                $array[] = h($_POST['studyStyle']);
                $array[] = h($_POST['studyType']);
                $array[] = h($_POST['personality']);
                
                // 登録情報分岐
                $status = $_POST['status'];
                if($status == 1){
                    // チューター登録
                    $this->cl->tuotorRegister($array);
                }else{
                    // 生徒登録
                    $this->cl->register($array);
                }
            }

            // // チューター詳細取得
            if($this->POST == 'tuotorList'){
                $array = array();
                $array[] = $_POST['id'];
                $array[] = $_POST['age'];
                // var_dump($uid);
                // exit();
                $this->cl = new CONTROLLER;
                $this->cl->getTuotorList($array);
            }
        }
    }

    $ajax = new AJAX;
