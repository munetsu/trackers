<?php
    include('controller.php');
    class VIEW{
        function __construct(){
            $this->CL = new CONTROLLER;
        }

        public function signUp($array){
            $this->CL->signUp($array);
            $view = '<div>';
            $view .= '<p>登録完了</p>';
            $view .= '</div>';

            echo $view;
        }
    }
