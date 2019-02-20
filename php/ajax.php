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
                // 写真リサイズ＋保存
                $fileData = $_FILES['upfile'];
                // var_dump($file);
                // exit();
                $this->cl = new CONTROLLER;
                $photo = $this->cl->reSize($fileData);
                // var_dump($photo);
                // exit();


                // 写真アップロード処理
                // if (isset($_FILES["upfile"] ) && $_FILES["upfile"]["error"] ==0 ) {
                //     $uid = h($_POST['uid']);
                //     $photo = $_FILES["upfile"]["name"];
                //     $photourl = $_FILES["upfile"]["tmp_name"];
                //     $this->cl = new CONTROLLER;
                //     $photo = $this->cl->photoUpload($photo,$photourl,$uid);
                
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
                $array[] = h($_POST['zokusei']);
                $array[] = h($_POST['holiday']);
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
                $array[] = $_POST['index'];
                // var_dump($uid);
                // exit();
                $this->cl = new CONTROLLER;
                $this->cl->getTuotorList($array);
            }

            // // 生徒資格選択
            // if($this->POST == 'subject'){
            //     $uid = $_POST['uid'];
            //     $subId = $_POST['subject'];
            //     // headerlink
            //     header('Location: http://'.$_SERVER["HTTP_HOST"].'/trackers/certificationUpdate.php?num='.$subId.'?status=1');
                
            // }

            // チューターの資格登録
            if($this->POST == 'subjectTuotor'){
                $array = array();
                $array[] = $_POST['uid'];
                $array[] = $_POST['status'];
                $array[] = $_POST['subject'];
                $this->cl = new CONTROLLER;
                $this->cl->subjectsTuotorLists($array);
            }

            // CertificationTable_Update
            if($this->POST == 'certificationUpdate'){
                $array = array();
                $array[] = $_POST['id']; //資格番号
                $array[] = $_POST['status']; //生徒=1,チューター=2
                $array[] = $_POST['period'];
                $array[] = $_POST['how'];
                $array[] = $_POST['knowhow'];

                // 書籍に関する条件分岐
                if(h($_POST['books']) == 'yes'){
                    $array[] = '9874'.h($_POST['isbn']);
                    $array[] = h($_POST['bookTitle']);
                    $array[] = h($_POST['bookImage']);
                } else {
                    $array[] = '';
                    $array[] = '';
                    $array[] = '';
                }
                $this->cl = new CONTROLLER;
                $this->cl->certificationUpdate($array);
            }

            // 面談希望処理
            if($this->POST == 'offers'){
                $array = array();
                $array[] = $_POST['tuotorId'];
                $array[] = $_POST['userId'];
                $array[] = $_POST['date1'];
                $array[] = $_POST['time1_start'];
                $array[] = $_POST['time1_finish'];
                if($_POST['date2ex'] == 1){
                    $array[] = $_POST['date2'];
                    $array[] = $_POST['time2_start'];
                    $array[] = $_POST['time2_finish'];
                } 
                if($_POST['date3ex'] == 1){
                    $array[] = $_POST['date3'];
                    $array[] = $_POST['time3_start'];
                    $array[] = $_POST['time3_finish'];
                }

                $this->cl = new CONTROLLER;
                $this->cl->offers($array); 
            }

            // like処理
            if($this->POST == 'likes'){
                $tuotorId = $_POST['tuotorId']; //チューターID
                $uid = $_POST['uid']; //生徒のUserID

                $this->cl = new CONTROLLER;
                // 生徒ID取得
                $studentId = $this->cl->selectStudentId($uid);

                // お気に入り登録
                $this->cl->likes($studentId, $tuotorId);
            }
        }
    }

    $ajax = new AJAX;
