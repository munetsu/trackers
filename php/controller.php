<?php
    session_start();
    // DATAクラス引き継ぎ
    include('data.php');
    include('view.php');

    class CONTROLLER{
        function __construct(){
            $this->db = new DATA;
            $this->view = new VIEW;
        }

        // 会員登録操作
        public function signUp($array){
            $column = 'email'.','.'password'.','.'datetime';
            $values = "'".$array[0]."'".','."'".$array[1]."'".','."'".date("Y/m/d")."'";
            $table = 'users';
            $this->db->insert($table, $column, $values);
            $url = 'viewer.php';
            return $url;
        }

        // ログイン操作
        public function login($array){
            $table = 'users';
            $column = '*';
            $mail = $array[0];
            $pass = $array[1];
            $conditions = 'WHERE `email` = '."'".$mail."'".' AND `password` = '."'".$pass."'";
            $user = $this->db->select($column,$table,$conditions);
            
            // 初回ログインかどうかを確認
            $flag = $user[0]['flag'];
            $_SESSION['id'] = $user[0]['id'];
            if($flag === '0'){
                $url = 'signUp.php';
                echo $url;
            }else{
                // チューターか生徒か判定
                $status = $user[0]['status'];
                if($status == 1){
                    // 生徒
                    // 科目選択済みか判定
                    if($flag == 2){
                        // 選択済み
                        $url = 'main.php';
                        echo $url;    
                    }else{
                        // 科目未選択
                        $url = 'selectSubject.php?num=1';
                        echo $url;
                    }
                }else{
                    // チューター
                }
            }
        }

        // サインアップ操作
        public function register($array){
            // userテーブルの更新
            $uid = $array[0];
            $table = 'users';
            $values = '`flag` = 1 , `status` = 1';
            $conditions = 'WHERE `id` = '."'".$uid."'";
            $this->db->update($table, $values, $conditions);
        
            // // studentsテーブルの更新
            $tables = 'Students';
            $column = $this->signUpPalamataColumn();
            $value = $this->signUpPalamatavalue($uid,$array);
            $this->db->insert($tables,$column,$value);
            header('Location: http://'.$_SERVER["HTTP_HOST"].'/trackers/selectSubject.php?num=1');
            exit();
        }

        // チューターサインアップ操作
        public function tuotorRegister($array){
            // userテーブルの更新
            $uid = $array[0];
            $table = 'users';
            $values = '`flag` = 1 , `status` = 2';
            $conditions = 'WHERE `id` = '."'".$uid."'";
            $this->db->update($table, $values, $conditions);
        
            // // tuotorsテーブルの更新
            $tables = 'tuotors';
            $column = $this->signUpPalamataColumn();
            $value = $this->signUpPalamatavalue($uid,$array);
            $this->db->insert($tables,$column,$value);
            header('Location: http://'.$_SERVER["HTTP_HOST"].'/trackers/selectSubject.php?num=2');
            exit();
        }

        // チューター科目登録
        public function subjectsTuotorLists($array){
            $uid = $array[0];
            $subjectId = $array[1];

            // チューターID取得
            $conditions = 'WHERE `user_id` = '."'".$uid."'";
            $tuotorId = $this->db->select('*', 'tuotors', $conditions);
            $tuotorId = $tuotorId[0]['id'];
            
            // 科目登録
            $column = "`tuotor_id`, `certification_id`";
            $values = "'".$tuotorId."'".','."'".$subjectId."'";
            // var_dump($values);
            // exit();
            $this->db->insert('subjectsTuotorLists', $column, $values);
            

        }

        // サインアップのパラメータ
        public function signUpPalamataColumn(){
            $column = 'user_id,
                        familyNameCharacter,
                        firstNameCharacter,
                        familyNameKana,
                        firstNameKana,
                        img,
                        year,
                        month,
                        day,
                        gender,
                        gakureki,
                        senkou,
                        born,
                        zokusei,
                        holiday,
                        lifeStyle,
                        studyStyle,
                        studyType,
                        personality,
                        bookIsbn,
                        bookTitle,
                        bookImage,
                        timestamp';
            return $column;
        }

        public function signUpPalamatavalue($uid,$array){
            $value = "'".$uid."'".','.
                        "'".$array[1]."'".','.
                        "'".$array[2]."'".','.
                        "'".$array[3]."'".','.
                        "'".$array[4]."'".','.
                        "'".$array[5]."'".','.
                        "'".$array[6]."'".','.
                        "'".$array[7]."'".','.
                        "'".$array[8]."'".','.
                        "'".$array[9]."'".','.
                        "'".$array[10]."'".','.
                        "'".$array[11]."'".','.
                        "'".$array[12]."'".','.
                        "'".$array[13]."'".','.
                        "'".$array[14]."'".','.
                        "'".$array[15]."'".','.
                        "'".$array[16]."'".','.
                        "'".$array[17]."'".','.
                        "'".$array[18]."'".','.
                        "'".$array[19]."'".','.
                        "'".$array[20]."'".','.
                        "'".$array[21]."'".','.
                        "'".date("Y/m/d H:i:s")."'";
            return $value;
        }

        // 写真理サイズ処理
        public function reSize($fileData){
            // width,height指定
            // $w = 400;
            // $h = 400;
            $keyScore = 400;

            // 加工するファイル指定
            $file = $fileData["tmp_name"];
            // 加工前の画像の情報を取得
            list($original_w, $original_h, $type) = getimagesize($file);

            // 縦長or横長の判定
            if($original_w > $original_h){
                $longLength = $original_w;
            }else{
                $longLength = $original_h;
            }
            
            // 基準値を超えている場合
            if($longLength > $keyScore){
                $stand = $longLength / $keyScore;
                $w = $original_w / $stand;
                $h = $original_h / $stand;
            }

            // var_dump($original_w, $original_h, $type);
            // exit();
            // 加工前のファイルをフォーマット別に読み出す（この他にも対応可能なフォーマット有り）
            switch ($type) {
                case IMAGETYPE_JPEG:
                    $original_image = imagecreatefromjpeg($file);
                    break;
                case IMAGETYPE_PNG:
                    $original_image = imagecreatefrompng($file);
                    break;
                case IMAGETYPE_GIF:
                    $original_image = imagecreatefromgif($file);
                    break;
                default:
                    throw new RuntimeException('対応していないファイル形式です。: ', $type);
            }

            // 新しく描画するキャンバスを作成
            $canvas = imagecreatetruecolor($w, $h);
            imagecopyresampled($canvas, $original_image, 0,0,0,0, $w, $h, $original_w, $original_h);

            $name = $fileData['name']; //ファイル名取得
            $extension = pathinfo($name, PATHINFO_EXTENSION); //拡張子取得(jpg, png, gif)
            $datetime = date("YmdHis"); //日付取得
            $uniq_name = $datetime."." . $extension;  //ユニークファイル名作成
            $file_dir_path = "../upload/";  //画像ファイル保管先

            // FileUpload [--Start--]
            if ( is_uploaded_file( $file ) ) {
                if ( move_uploaded_file( $file, $file_dir_path.$uniq_name ) ) {
                    chmod( $file_dir_path.$uniq_name, 0644 );

                    switch ($type) {
                        case IMAGETYPE_JPEG:
                            imagejpeg($canvas, $file_dir_path.$uniq_name);
                            break;
                        case IMAGETYPE_PNG:
                            imagepng($canvas, $file_dir_path.$uniq_name, 9);
                            break;
                        case IMAGETYPE_GIF:
                            imagegif($canvas, $file_dir_path.$uniq_name);
                            break;
                    }
        
                    // 読み出したファイルは消去
                    imagedestroy($original_image);
                    imagedestroy($canvas);
                    return 'upload/'.$uniq_name;
                } else {
                    echo '<script>alert("写真変更ができませんでした");location.href="setting.php;</script>';
                }
            }
        }

        // 写真アップロード処理
        public function photoUpload($photo,$photourl,$uid){
            //情報取得
            $file_name = $photo;         //"1.jpg"ファイル名取得
            $tmp_path  = $photourl; //"/usr/www/tmp/1.jpg"アップロード先のTempフォルダ
            $file_dir_path = "../upload/";  //画像ファイル保管先
    
            //***File名の変更***
            $extension = pathinfo($file_name, PATHINFO_EXTENSION); //拡張子取得(jpg, png, gif)
            $datetime = date("YmdHis");
            $uniq_name = $uid . $datetime."." . $extension;  //ユニークファイル名作成
            // $file_name = $file_dir_path.$uniq_name; //ユニークファイル名とパス
        
            // FileUpload [--Start--]
            if ( is_uploaded_file( $tmp_path ) ) {
                if ( move_uploaded_file( $tmp_path, $file_dir_path.$uniq_name ) ) {
                    chmod( $file_dir_path.$uniq_name, 0644 );
                    return 'upload/'.$uniq_name;
                } else {
                    echo '<script>alert("写真変更ができませんでした");location.href="setting.php;</script>';
                }
            }
        // FileUpload [--End--]
        }

        // チューター一覧取得
        public function tuotorsList(){
            $table = 'tuotors';
            $column = '*';
            $conditions = '';
            $lists = $this->db->select($column, $table, $conditions);
            return $lists;
        }

        // // チューター詳細取得
        public function getTuotorList($array){
            $table = 'tuotors';
            $column = '*';
            $uid = $array[0];
            $age = $array[1];
            $index = $array[2];
            $conditions = 'WHERE `id` = '.$uid;
            $tuotor = $this->db->select($column,$table,$conditions);

            // 学歴取得
            $gakureki = $this->getTuotorDetail('gakurekis', 'level', $tuotor[0]['gakureki']);
            $tuotor[0]['gakureki'] = $gakureki[0]['level'];
            // 専攻取得
            $senkou = $this->getTuotorDetail('senkous','major', $tuotor[0]['senkou']);
            $tuotor[0]['senkou'] = $senkou[0]['major'];
            // 属性取得
            $zokusei = $this->getTuotorDetail('zokuseis','zokusei', $tuotor[0]['zokusei']);
            $tuotor[0]['zokusei'] = $zokusei[0]['zokusei'];
            // 休み取得
            $holiday = $this->getTuotorDetail('holidays','holiday', $tuotor[0]['holiday']);
            $tuotor[0]['holiday'] = $holiday[0]['holiday'];
            // ライフスタイル
            $lifestyle = $this->getTuotorDetail('lifestyles', 'style', $tuotor[0]['lifeStyle']);
            $tuotor[0]['lifeStyle'] = $lifestyle[0]['style'];
            // 勉強スタイル
            $studystyle = $this->getTuotorDetail('studystyles', 'style', $tuotor[0]['studyStyle']);
            $tuotor[0]['studyStyle'] = $studystyle[0]['style'];
            // 勉強タイプ
            $studytype = $this->getTuotorDetail('studytypes', 'type', $tuotor[0]['studyType']);
            $tuotor[0]['studyType'] = $studytype[0]['type'];
            // 性格
            $personality = $this->getTuotorDetail('personalitys', 'personal', $tuotor[0]['personality']);
            $tuotor[0]['personality'] = $personality[0]['personal'];

            // $tuotor = json_encode($tuotor, JSON_UNESCAPED_UNICODE);
            // var_dump($tuotor);
            // exit();
            // echo $tuotor;
            $this->view->tuotorRender($tuotor,$age,$index);
        }

        // チューター各詳細の置き換え
        public function getTuotorDetail($table, $column, $level){
            $table= $table;
            $column = $column;
            $conditions = 'WHERE `id` = '.$level;
            $gakureki = $this->db->select($column, $table, $conditions);
            return $gakureki;
        }

        // 科目一覧取得
        public function subjectSelect(){
            $table = 'certifications';
            $column = '*';
            $conditions = '';
            $subjectLists = $this->db->select($column, $table, $conditions);
            return $subjectLists;
        }

        // 資格ごとのチューター情報取得
        public function subjectsTuotors($subId){
            $table = 'subjectsTuotorLists';
            $column = 'tuotor_id';
            $conditions = 'WHERE `certification_id` = '.$subId;
            $tuotorsLists = $this->db->select($column, $table, $conditions);
            // var_dump($tuotorsLists);
            // exit();
            $tuotors = $this->tuotorsList();

            // マッチするチューター取得
            $allTuotors = array();
            foreach($tuotorsLists as $tuotorList){
                foreach($tuotors as $tuotor){
                    if($tuotorList['tuotor_id'] == $tuotor['id']){
                        $allTuotors[] = $tuotor;
                    }
                }
            }
            return $allTuotors;
        }

        public function userDetail(){
            // ユーザーID
            $uid = $_SESSION['id'];
            $condition = 'WHERE `user_id` = '.$uid;
            // ユーザー情報取得
            $userData = $this->db->select('*', 'Students', $condition);
            return $userData;
        }

        // マッチング判定関数
        public function matching($userData, $lists){
            // var_dump($lists);
            // exit();
            $tuotorList = array();
            foreach($lists as $list){
                // 学歴判定
                $gakuIndex = $list['gakureki'] - $userData['gakureki'];
                $gakuIndex = $this->matchingFive($gakuIndex);
                $gakuIndex = $gakuIndex * 0.7;
                // 年齢判定
                $ageIndex = $list['year'] - $userData['year'];
                $ageIndex = $this->matchingSix($ageIndex);
                $ageIndex = $ageIndex * 0.8;
                // 属性
                $statusIndex = $list['zokusei'] - $userData['zokusei'];
                $statusIndex = $this->matchingSix($statusIndex);
                $statusIndex = $statusIndex * 0.9;
                // 休日
                $holidayIndex = $list['holiday'] - $userData['holiday'];
                $holidayIndex = $this->matchingThree($holidayIndex);
                $holidayIndex = $holidayIndex * 1.0;
                // 生活スタイル
                $lifeIndex = $list['lifeStyle'] - $userData['lifeStyle'];
                $lifeIndex = $this->matchingTwo($lifeIndex);
                $lifeIndex = $lifeIndex * 0.7;
                // 性格
                $personalIndex = $list['personality'] - $userData['personality'];
                $personalIndex = $this->matchingTwo($personalIndex);
                $personalIndex = $personalIndex * 0.8;
                // 性別
                $genderIndex = $list['gender'] - $userData['gender'];
                $genderIndex = $this->matchingTwo($genderIndex);
                $genderIndex = $genderIndex * 0.4;
                // 勉強スタイル
                $studySytleIndex = $list['studyStyle'] - $userData['studyStyle'];
                $studySytleIndex = $this->matchingTwo($studySytleIndex);
                $studySytleIndex = $studySytleIndex * 0.7;
                // 勉強方法
                $studyTypeIndex = $list['studyType'] - $userData['studyType'];
                $studyTypeIndex = $this->matchingTwo($studyTypeIndex);
                $studyTypeIndex = $studyTypeIndex * 0.9;

                // マッチング度
                $matchIndex = $gakuIndex
                                +$ageIndex
                                +$statusIndex
                                +$holidayIndex
                                +$lifeIndex
                                +$personalIndex
                                +$genderIndex
                                +$studySytleIndex
                                +$studyTypeIndex;
            
                // チューター詳細に追加
                $list = $list + array('index'=>$matchIndex);
                $tuotorList[] = $list;
            }
            // keyを元に降順にする
            // krsort($tuotorList);
            // var_dump($tuotorList);
            // exit();
            return $tuotorList;
            
        }

        // マッチング判定指数関数
        public function matchingSix($data){
            if($data == 0){
                $num = 10;
                return $num;
            } else if($data == 1 || $data == -1){
                $num = 9;
                return $num;
            } else if($data == 2 || $data == -2){
                $num = 8;
                return $num;
            } else if($data == 3 ||$data == -3){
                $num = 7;
                return $num;
            } else if($data == 4 || $data == -4){
                $num = 5;
                return $num;
            } else if($data == 5 || $data == -5){
                $num = 2;
                return $num;
            } else {
                $num = 0;
                return $num;
            }
        }

        public function matchingFive($data){
            if($data == 0){
                $num = 10;
                return $num;
            } else if($data == 1 || $data == -1){
                $num = 8;
                return $num;
            } else if($data == 2 || $data == -2){
                $num = 6;
                return $num;
            } else if($data == 3 || $data == -3){
                $num = 4;
                return $num;
            } else if($data == 4 || $data == -4){
                $num = 2;
                return $num;
            } else {
                $num = 0;
                return $num;
            }
        }

        public function matchingThree($data){
            if($data == 0){
                $num = 10;
                return $num;
            } else if($data == 1 || $data == -1){
                $num = 6;
                return $num;
            } else {
                $num = 0;
                return $num;
            }
        }

        public function matchingTwo($data){
            if($data == 0){
                $num = 10;
                return $num;
            } else {
                $num = 0;
                return $num;
            }
        }



    }