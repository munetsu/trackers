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
                    <li><a href="#">面談リスト</a></li>
                    <li><a href="#">資格追加</a></li>
                </div>';
            return $sideBar;
        }
    }    