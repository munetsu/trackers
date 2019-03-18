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



    }

