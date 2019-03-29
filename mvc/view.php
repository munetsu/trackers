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
        public function viewCommon(){
            $view = '
                <div>
                    <!-- 固定上段-->
                    <div class="topbar">
                        <div>
                            <a href="#"><img src="img/logo.png"></a>
                        </div>
                        <div>
                            <a href="logout.php?status=tuotor">ログアウト</a>
                        </div>
                    </div>
                    <div class="flex">
                        <!-- サイドバー部分 -->
                        <div class="sidebar">
                            <ul>
                                <li>実施予定</li>
                                <li>過去実施</li>
                                <li>勉強方法</li>
                                <li>プロフィール</li>
                            </ul>
                        </div>
                        <!-- メイン部分 -->
                        <div class="mainarea"></div>
                    </div>
                </div>
            ';
            return $view;
        }

        


        






    }

