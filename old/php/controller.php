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

        // 全データ取得
        public function selectAll($table){
            $column = '*';
            $condition = '';
            $data = $this->db->select($column, $table, $condition);
            return $data;
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

        // studentsId取得
        public function selectStudentId($uid){
            $column = 'id';
            $table = 'Students';
            $conditions = 'WHERE `user_id`='."'".$uid."'";
            $studentsId = $this->db->select($column, $table, $conditions);
            return $studentsId[0]['id'];
        }

        // matchingId取得
        public function matchingId($id){
            $column = 'id';
            $table = 'matchings';
            $conditions = 'WHERE `student_id`='."'".$id."'";
            $matchingsId = $this->db->select($column, $table, $conditions);
            return $matchingsId;
        }

        // OfferId取得
        public function offerId($id){
            $column = 'id';
            $table = 'offers';
            $conditions = 'WHERE `student_id`='."'".$id."'";
            $matchingsId = $this->db->select($column, $table, $conditions);
            // $matchingsId = $matchingsId[0]['id'];
            return $matchingsId;
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
            $contract_flag = $user[0]['contract_flag'];
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
                        // 現在の契約状態
                        if($contract_flag != 0){
                            $url = 'student_top.php?uid='.$user[0]['id'];
                            echo $url;
                            exit();
                        }

                        // 選択済み
                        $lists = $this->userDetail();
                        $subject = $lists['certification_id'];
                        $url = 'main.php?subject='.$subject;
                        echo $url;
                        // headerlink
                        // header('Location: http://'.$_SERVER["HTTP_HOST"].'/trackers/main.php?subject='.$subject);
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

        // 科目登録STEP1
        public function subjectsTuotorLists($array){
            $uid = $array[0];
            $status = $array[1]; //1=生徒、2=チューター
            $subjectId = $array[1];

            // 条件分岐
            if($status == 1){
                // 生徒
                // チューターID取得
                $conditions = 'WHERE `user_id` = '."'".$uid."'";
                $studentsId = $this->db->select('*', 'Students', $conditions);
                $studentsId = $studentsId[0]['id'];
                
                // 科目登録
                $table = 'searchConditions';
                $column = "`student_id`, `certification_id`";
                $values = "'".$studentsId."'".','."'".$subjectId."'";
                // var_dump($values);
                // exit();
                $this->db->insert($table, $column, $values);

                // 登録ID取得
                $condition = 'WHERE `student_id` = '."'".$studentsId."'".' AND `certification_id` = '."'".$subjectId."'";
                $searchId = $this->db->select('*', $table, $condition);
                $searchId = $searchId[0]['id'];

                // headerlink
                header('Location: http://'.$_SERVER["HTTP_HOST"].'/trackers/certificationUpdate.php?num='.$subjectId.'&status=1');
            } else {
                // チューター
                // チューターID取得
                $conditions = 'WHERE `user_id` = '."'".$uid."'";
                $tuotorId = $this->db->select('*', 'tuotors', $conditions);
                $tuotorId = $tuotorId[0]['id'];
                
                // 科目登録
                $table = 'subjectsTuotorLists';
                $column = "`tuotor_id`, `certification_id`";
                $values = "'".$tuotorId."'".','."'".$subjectId."'";
                // var_dump($values);
                // exit();
                $this->db->insert($table, $column, $values);

                // 登録ID取得
                $condition = 'WHERE `tuotor_id` = '."'".$tuotorId."'".' AND `certification_id` = '."'".$subjectId."'";
                $certificationId = $this->db->select('*', $table, $condition);
                $certificationId = $certificationId[0]['id'];

                // headerlink
                header('Location: http://'.$_SERVER["HTTP_HOST"].'/trackers/certificationUpdate.php?num='.$certificationId.'?status=2');
            }


            
        }

        // 勉強方法などの登録
        public function certificationUpdate($array){
            // UserTableのFlag更新
            $table = 'users';
            $uid = $_SESSION['id'];
            $value = '`flag` = 2';
            $condition = 'WHERE `id` = '."'".$uid."'";
            $this->db->update($table, $value, $condition);

            // 生徒ID取得
            $studentId = $this->selectStudentId($uid);
            // var_dump($studentId);
            // exit();

            $id = $array[0];
            $status = $array[1];
            $period = $array[2];
            $how = $array[3];
            $knowhow = $array[4];
            $bookIsbn = $array[5];
            $bookTitle = $array[6];
            $bookImage = $array[7];

            // var_dump($how,$knowhow);
            // exit();

            $values = 
                        '`period` = '."'".$period."'".","
                        .'`how` = '."'".$how."'".","
                        .'`knowhow` = '."'".$knowhow."'".","
                        .'`bookIsbn` = '."'".$bookIsbn."'".","
                        .'`bookTitle` = '."'".$bookTitle."'".","
                        .'`bookImage` = '."'".$bookImage."'";
            $conditions = 'WHERE `certification_id` ='."'".$id."'".' AND `student_id` ='."'".$studentId."'";

            // var_dump($conditions);
            // exit();

            // var_dump($status);
            // exit();

            // 条件分岐（生徒/チューター）
            if($status == 1){
                // 生徒
                // Update処理
                $tables = 'searchConditions'; 
                // var_dump($tables, $values, $conditions);
                // exit();
                $this->db->update($tables, $values, $conditions);
                
                // headerlink
                header('Location: http://'.$_SERVER["HTTP_HOST"].'/trackers/main.php?subject='.$id);

            } else {
                // チューター
                    // Update処理
                $table = 'subjectsTuotorLists';
                $this->db->update($table, $values, $conditions);
                
                // headerlink
                header('Location: http://'.$_SERVER["HTTP_HOST"].'/trackers/tuotorMain.php');

            }
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
            // $table = 'tuotors';
            // $column = '*';
            // $conditions = '';
            // $lists = $this->db->select($column, $table, $conditions);
            // return $lists;
            $column = '*';
            $table1 = 'tuotors';
            $table2 = 'subjectsTuotorLists';
            $column1 = 'tuotors.id';
            $column2 = 'subjectsTuotorLists.tuotor_id';
            $lists = $this->db->selectInnerJoin($column, $table1, $table2, $column1, $column2);
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
            $this->view->tuotorRender($tuotor,$age,$index, $uid);
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
            // var_dump($tuotorsLists, $tuotors);
            // exit();
            foreach($tuotorsLists as $tuotorList){
                foreach($tuotors as $tuotor){
                    if($tuotorList['tuotor_id'] == $tuotor['tuotor_id']){
                        $allTuotors[] = $tuotor;
                    }
                }
            }
            return $allTuotors;
        }

        public function userDetail(){
            // ユーザーID
            $uid = $_SESSION['id'];
            // $condition = 'WHERE `user_id` = '.$uid;
            // // ユーザー情報取得
            // $userData = $this->db->select('*', 'Students', $condition);
            // return $userData;

            $column = '*';
            $table1 = 'Students';
            $table2 = 'searchConditions';
            $column1 = 'Students.id';
            $column2 = 'searchConditions.student_id';
            $userDatas = $this->db->selectInnerJoin($column, $table1, $table2, $column1, $column2);
            
            foreach($userDatas as $userData){
                if($userData['user_id'] == $uid){
                    $user = $userData;
                }
            }
            return $user;
        }

        // マッチング判定関数
        public function matching($userData, $lists){
            // var_dump($lists,$userData);
            // exit();
            $tuotorList = array();
            foreach($lists as $list){
                // 勉強方法判定
                $howIndex = $list['how'] - $userData['how'];
                $howIndex = $this->matchingTwo($howIndex);
                // 前提知識
                $knowhowIndex = $list['knowhow'] - $userData['knowhow'];
                $knowhowIndex = $this->matchingTwo($knowhowIndex);

                // var_dump($howIndex,$knowhowIndex);
                // exit();
                if($howIndex == 0 || $knowhowIndex == 0){
                    continue;
                } else {
                    // 勉強期間
                    $periodIndex = $list['period'] - $userData['period'];
                    $periodIndex = $this->matchingTen($periodIndex);
                    $periodIndex = $periodIndex * 2.0;

                    // 学歴判定
                    $gakuIndex = $list['gakureki'] - $userData['gakureki'];
                    $gakuIndex = $this->matchingFive($gakuIndex);
                    $gakuIndex = $gakuIndex * 1.5;
                    // 年齢判定
                    $ageIndex = $list['year'] - $userData['year'];
                    $ageIndex = $this->matchingSix($ageIndex);
                    $ageIndex = $ageIndex * 0.7;
                    // 属性
                    $statusIndex = $list['zokusei'] - $userData['zokusei'];
                    $statusIndex = $this->matchingSix($statusIndex);
                    $statusIndex = $statusIndex * 1.5;
                    // 休日
                    $holidayIndex = $list['holiday'] - $userData['holiday'];
                    $holidayIndex = $this->matchingThree($holidayIndex);
                    $holidayIndex = $holidayIndex * 0.8;
                    // 生活スタイル
                    $lifeIndex = $list['lifeStyle'] - $userData['lifeStyle'];
                    $lifeIndex = $this->matchingTwo($lifeIndex);
                    $lifeIndex = $lifeIndex * 0.6;
                    // 性格
                    $personalIndex = $list['personality'] - $userData['personality'];
                    $personalIndex = $this->matchingTwo($personalIndex);
                    $personalIndex = $personalIndex * 1.0;
                    // 性別
                    $genderIndex = $list['gender'] - $userData['gender'];
                    $genderIndex = $this->matchingTwo($genderIndex);
                    $genderIndex = $genderIndex * 0.1;
                    // 勉強スタイル
                    $studySytleIndex = $list['studyStyle'] - $userData['studyStyle'];
                    $studySytleIndex = $this->matchingTwo($studySytleIndex);
                    $studySytleIndex = $studySytleIndex * 0.8;
                    // 勉強方法
                    $studyTypeIndex = $list['studyType'] - $userData['studyType'];
                    $studyTypeIndex = $this->matchingTwo($studyTypeIndex);
                    $studyTypeIndex = $studyTypeIndex * 1.0;

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
                    // keyを元に降順にする
                    // krsort($tuotorList);
                    // var_dump($tuotorList);
                    // exit();
                    return $tuotorList;
                }

                echo '対象チューターがいません';
                exit();
            }            
        }

        // マッチング判定指数関数
        public function matchingTen($data){
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
                $num = 6;
                return $num;
            } else if($data == 5 || $data == -5){
                $num = 5;
                return $num;
            } else if($data == 6 || $data == -6){
                $num = 4;
                return $num;
            } else if($data == 7 || $data == -7){
                $num = 3;
                return $num;
            } else if($data == 8 || $data == -8){
                $num = 2;
                return $num;
            } else if($data == 9 || $data == -9){
                $num = 1;
                return $num;
            } else {
                $num = 0;
                return $num;
            }
        }




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

        // 面談依頼処理
        public function offers($array){
            // studentsIdの取得
            $studentId = $this->selectStudentId($array[1]);
            // tuotorId
            $tuotorId = $array[0];
            // 面談候補日（第一）
            $date1 = $array[2];
            $date1_start= $array[3];
            $date1_finish = $array[4];
            $date1_start = $date1.' '.$date1_start;
            $date1_finish = $date1.' '.$date1_finish;
            
            // offersテーブル更新
            $count = count($array);
            $table = 'offers';
            $column = "`student_id`, `tuotor_id`, `flag`,";
            $value = "'".$studentId."'".","."'".$tuotorId."'".","."1".",";

            // 第一希望のみしか記入されていない場合
            if($count == 5){
                $column = $column.'`date1_start`, `date1_finish`';
                $values = $value."'".$date1_start."'".",".
                            "'".$date1_finish."'";
                $this->db->insert($table, $column, $values);
    
            // 第二希望までしか記入されていない場合
            } else if ($count == 8){
                // 面談候補日（第二）
                $date2 = $array[5];
                $date2_start= $array[6];
                $date2_finish = $array[7];
                $date2_start = $date2.' '.$date2_start;
                $date2_finish = $date2.' '.$date2_finish;

                // DBUpdate
                $column = $column.'`date1_start`, `date1_finish`,
                                    `date2_start`, `date2_finish`';
                
                $values = $value."'".$date1_start."'".","."'".$date1_finish."'".",".
                                "'".$date2_start."'".","."'".$date2_finish."'";
                $this->db->insert($table, $column, $values);

            } else if($count == 11){
                // 面談候補日（第二）
                $date2 = $array[5];
                $date2_start= $array[6];
                $date2_finish = $array[7];
                $date2_start = $date2.' '.$date2_start;
                $date2_finish = $date2.' '.$date2_finish;
                
                // 面談候補日（第三）
                $date3 = $array[8];
                $date3_start= $array[9];
                $date3_finish = $array[10];
                $date3_start = $date3.' '.$date3_start;
                $date3_finish = $date3.' '.$date3_finish;

                // DBUpdate
                $column = $column.'`date1_start`, `date1_finish`,
                                    `date2_start`, `date2_finish`,
                                    `date3_start`, `date3_finish`';
                
                $values = $value."'".$date1_start."'".","."'".$date1_finish."'".",".
                                "'".$date2_start."'".","."'".$date2_finish."'".",".
                                "'".$date3_start."'".","."'".$date3_finish."'";
                $this->db->insert($table, $column, $values);
    
            }

            // Userテーブル更新
            $table = 'users';
            $values = 'contract_flag = 1';
            $condition = 'WHERE id='."'".$array[1]."'";
            $this->db->update($table, $values, $condition);

            header('Location: http://'.$_SERVER["HTTP_HOST"].'/trackers/student_top.php?uid='.$array[1]);
        }

        // offer内容取得
        public function offerDetail($ids){
            $details = array();
            foreach($ids as $id){
                $id = $id['id'];
                $column = '*';
                $table = 'offers';
                $condition = 'WHERE id='."'".$id."'";
                $detail = $this->db->select($column, $table, $condition);
                if($detail[0]['flag'] == 99){
                    continue;
                } else {
                    $details[] = $detail;
                }
            }
            // var_dump($details);
            // exit();
            return $details;
        }

        // お気に入り登録
        public function likes($studentId, $tuotorId){
            $table = 'likes';
            $column = "`student_id`, `tuotor_id`, `flag`";
            $values = "'".$studentId."'".","
                    ."'".$tuotorId."'".","
                    ."0";
            $this->db->insert($table, $column, $values);
        }
    }
            
    