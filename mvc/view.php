<?php
    class VIEW{
        function __construct(){

        }

        //////////////////////////////////////////
        // チューター情報のVIEW（controller.php/booklist）
        //////////////////////////////////////////
        public function tuotorView($array, $tuotorInfo){
            $booklist = '<div class="flex">';
            for($i =1;$i<=$array['count'];$i++){
                $booklist .= '<div>';
                $booklist .= '<p>'.$i.'冊目</p>';
                $booklist .= '<p>'.$array['title'.$i].'</p>';
                $booklist .= '<img src="'.$array['imageUrl'.$i].'">';
            }
            $booklist .= '</div>';

            $view = '
                <div>
                    <p>サイト上でのプロフィール
                    <div class="flex">
                        <div>
                            <img src="upload/'.$tuotorInfo['picture'].'" class="picture">
                        </div>
                        <div>
                            <p>名前：'.$tuotorInfo['c_name'].'</p>
                            <p>生まれ：'.$tuotorInfo['birthyear'].'年</p>
                        </div>
                    </div>
                    <div>
                        <p>利用参考書</p>
                        '.$booklist.'
                    </div>
                </div>
            ';
            echo $view;
        }

        //////////////////////////////////////////
        // controller.php_'t_signUp'
        //////////////////////////////////////////
        // （既にチューター登録済みの場合）
        public function tuotorRegisterError(){
            $view = '
                <div>
                    <p>先ほど記載頂いたメールアドレスまたは携帯番号は既に登録頂いております。</p>
                    <a href="../t_signUp.php">登録ページに戻る</a>
                </div>
            ';
            echo $view;
        }

        //////////////////////////////////////////
        // t_mypage.phpの共通部分
        //////////////////////////////////////////
        public function viewCommon($id){
            $view = '
                <div>
                    <!-- 固定上段-->
                    <div class="topbar">
                        <div class="logoarea">
                            <a href="t_mypage.php"><img src="img/logo.png" class="logo"></a>
                        </div>
                        <div class="logout">
                            <a href="logout.php?status=tuotor">ログアウト</a>
                        </div>
                        <div id="nav_toggle">
                            <div>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                            <nav>
                                <ul>
                                    <li><a href="t_adjustmentlist.php">日程調整中</a></li>
                                    <li><a href="t_resevationlist.php">実施予定</a></li>
                                    <li><a href="t_donelist.php" class="closed">過去実施（工事中）</a></li>
                                    <li><a href="t_howtoedit.php" class="closed">勉強方法（工事中）</a></li>
                                    <li><a href="t_pgofile.php" class="closed">プロフィール（工事中）</a></li>
                                    <li><a href="logout.php?status=tuotor">ログアウト</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="flex">
                        <!-- サイドバー部分 -->
                        <div class="sidebar">
                            <ul>
                                <li><a href="t_adjustmentlist.php">日程調整中</a></li>
                                <li><a href="t_resevationlist.php">実施予定</a></li>
                                <li><a href="t_donelist.php" class="closed">過去実施（工事中）</a></li>
                                <li><a href="t_howtoedit.php" class="closed">勉強方法（工事中）</a></li>
                                <li><a href="t_pgofile.php" class="closed">プロフィール（工事中）</a></li>
                            </ul>
                        </div>
                        <!-- メイン部分 -->
                        <div class="main"></div>
                    </div>
                </div>
            ';
            return $view;
        }

        //////////////////////////////////////////
        // s_mypage.phpの共通部分
        //////////////////////////////////////////
        // s_mypageのトップバー
        public function viewStudentTopbar(){
            $view = '
            <div class="topbar">
            <!-- left -->
            <div class="left">
                <div class="logo">
                    <a href="s_mypage.php"><img src="img/logo.png"></a>
                </div>
                <div class="search">
                    <p class="selectCertification">資格で絞り込む</p>
                    <ul class="certificaionList"></ul>
                </div>
            </div>
            <!-- right -->
            <div class="right">
                <div class="mypage">
                    <p class="resevationlist"><a href="s_matchConsullist.php">予約リスト</a></p>
                    <p class="resevationlist"><a href="s_adjustmentlist.php">日程調整中リスト</a></p>
                    <p><a href="logout.php?status=student">ログアウト</a></p>
                </div>
            </div>
            </div>
            ';
            return $view;
        }


        


        






    }

