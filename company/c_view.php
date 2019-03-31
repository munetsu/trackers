<?php
    class C_VIEW{
        function __construct(){

        }

        //////////////////////////////////////
        //共通部分
        //////////////////////////////////////

        // ヘッダー
        public function headerView(){
            $header = 
                '<div class="header">
                    <div class="flex">
                        <div class="logo">
                            <img src="../img/logo.png">
                        </div>
                        <div class="logout">
                            <button>ログアウト</button>
                        </div>
                    </div>
                </div>';
            return $header;
        }

        // サイドバー
        public function sideBar(){
            $sideBar = 
                '<div class="sideBar">
                    <li><a href="c_tuotor.php">チューター</a></li>
                    <li><a href="c_certification.php">資格追加</a></li>
                </div>';
            return $sideBar;
        }

        // 共有VIEW
        public function viewCommon(){
            $view = '
                <div class="topbar">
                    <div class="logo">
                        <img src="../img/logo.png">
                    </div>
                    <div class="logout">
                        <a href="c_logout.php">ログアウト</a>
                    </div>
                </div>
                <div class="body">
                    <div class="sidebar">
                        <ul>
                            <li><a href="c_offerlist.php">申請一覧</a></li>
                            <li><a href="c_waitConfirm.php">勉強法承認待ち</a></li>
                            <li><a href="c_adjustmentDate.php">日程調整中<a/></li>
                            <li><a href="c_waitCashList.php">未入金リスト</a></li>
                            <li><a href="c_salaryList.php">振込リスト</a></li>
                        </ul>
                    </div>
                    <div class="main">
                    <div>
                </div>
            ';
            return $view;
        }

        //////////////////////////////////////
        //c_tuotor.php
        //////////////////////////////////////
        // 日程調整前チューター
        public function tuotorList($lists){
            $count = 0;
            $view = '<div><a href="https://docs.google.com/spreadsheets/d/1CaRHTu-Hw-QsJOfFM2GGgcViDfuXrr7fUNbeY9uXxv4/edit#gid=0" target="_blank">日程調整Sheet</a></div>';
            foreach($lists as $list){
                if($count%3 == 0){
                    $view .= '<div class="flex">';
                    $view .= '<div>';
                }else{
                    $view .= '<div>';
                }
                $view .= '<p>氏名；'.$list['name'].'<p>';
                $view .= '<p>アドレス；'.$list['email'].'<p>';
                $view .= '<p>電話番号；'.$list['tel'].'<p>';
                $view .= '
                        <div>
                            <form action="c_controller.php" method="POST">
                                <input type="hidden" name="action" value="interviewConfirm">
                                <input type="hidden" name="tuotorRegisterId" value="'.$list['id'].'">
                                <div>
                                    <label><input type="radio" name="interviewDate" value="'.$list['firstDate']."/".$list['ftime'].'">
                                    第一候補日：'.$list['firstDate'].'<br></label>
                                    時間：'.$list['ftime'].'
                                </div>
                                <div>
                                    <label><input type="radio" name="interviewDate" value="'.$list['secondDate']."/".$list['stime'].'">
                                    第二候補日：'.$list['secondDate'].'<br></label>
                                    時間：'.$list['stime'].'
                                </div>
                                <div>
                                    <label><input type="radio" name="interviewDate" value="'.$list['thirdDate']."/".$list['ttime'].'">
                                    第三候補日：'.$list['thirdDate'].'<br></label>
                                    時間：'.$list['ttime'].'
                                </div>
                                <input type="hidden" name="itime" value="" id="itime">
                                <button>日程確定</button>
                            </form>
                        </div>
                        ';
                if($count%3 == 2){
                    $view .= '</div>';
                    $view .= '</div>';
                }else{
                    $view .= '</div>';
                }
                $count .= 1;
            }
            
            echo $view;
        }

        // 面談予定チューター
        public function interviewTuotor($lists){
            $view = '<div>';
            foreach($lists as $list){
                $view .= '<div class="flex">';
                $view .= '<div>';
                    $view .= '<p>氏名：'.$list['name'].'/時間：'.$list['interviewDate'].'</p>';
                $view .= '</div>';
                $view .= '<div class="flex">';
                    $view .= '<form action="c_controller.php" method="POST">';
                    $view .= '<input type="hidden" name="action" value="exam">';
                    $view .= '<input type="hidden" name="tuotorId" value="'.$list['id'].'">';
                    $view .= '<input type="hidden" name="result" value="2">';
                    $view .= '<button id="ok" class="btn">合格</button>';
                    $view .= '</form>';
                    $view .= '<form action="c_controller.php" method="POST">';
                    $view .= '<input type="hidden" name="action" value="exam">';
                    $view .= '<input type="hidden" name="tuotorId" value="'.$list['id'].'">';
                    $view .= '<input type="hidden" name="result" value="1">';
                    $view .= '<button id="ng" class="btn">不合格</button>';
                    $view .= '</form>';                
                $view .= '</div>';
            }
            $view .= '</div>';
            echo $view;
        }

        // 合格者の登録作業
        public function examOkTuotor($array){
            $view = '
                <div>
                    <p>合格者登録</p>
                    <form action="c_controller.php" method="POST">
                        <input type="hidden" name="action" value="tuotorResitor">
                        <p>氏名：<input type="text" name="name" value="'.$array['name'].'" size="40"></p>
                        <p>メールアドレス：<input type="text" name="email" value="'.$array['email'].'" size="40"></p>
                        <p>電話番号：<input type="tel" name="tel" value="'.$array['tel'].'" size="40"></p>
                        <button>チューター登録する</button>
                    </form>
                </div>
            ';
            echo $view;
        }

        // 登録チューター一覧
        public function tuotors($lists){
            // var_dump($lists);
            // exit();
            $count = 0;
            $view = '';
            foreach($lists as $list){
                if($count%3 == 0){
                    $view .= '<div class="flex">';
                    $view .= '<div>';
                }else{
                    $view .= '<div>';
                }

                $view .= '<div class="flex">';
                $view .= '<div><img src="'.$list['picture'].'" style="width:50px;height:50px"></div>';
                $view .= '<div>';
                    $view .= '<p>氏名：'.$list['c_name'].'</p>';
                    $view .= '<p>氏名：'.$list['k_name'].'</p>';
                    $view .= '<p>mail：'.$list['email'].'</p>';
                    $view .= '<p>tel：'.$list['tel'].'</p>';
                $view .= '</div>';
                $view .= '</div>';

                $view .= '<div><a href="?tutorid='.$list['tuotor_id'].'">合格体験記</a></div>';

                if($count%3 == 2){
                    $view .= '</div>';
                    $view .= '</div>';
                }else{
                    $view .= '</div>';
                }
                $count .= 1;
            }
           echo $view;
        }
    }    