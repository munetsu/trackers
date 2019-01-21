<?php
    class VIEW{
        function __construct(){
           
        }

        // ログイン画面
        public function login(){
            $view = '
                <!-- ログイン画面 -->
                <div id="login" class="login">
                    <p>会員の方はこちら</p>
                    <div>
                        <p>ログインID</p>
                        <input type="text" name="email" id="loginId" placeholder="email">
                    </div>
                    <div>
                        <p>パスワード</p>
                        <input type="password" name="password" id="password" placeholder="password">
                    </div>
                    <button id="loginBtn" class="btn">ログイン</button>
                </div>
            ';
            echo $view;
        }

        
    }
