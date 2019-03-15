<?php
    class C_VIEW{
        function __construct(){

        }

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
                    <li><a href="#">資格追加</a></li>
                </div>';
            return $sideBar;
        }

        //////////////////////////////////////
        //Tuotorメニュー（チューター一覧）
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

    }    