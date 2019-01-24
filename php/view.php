<?php
    class VIEW{

        function __construct(){

        }

        // チューター詳細表示画面
        public function tuotorRender($tuotor,$age){
            var_dump($tuotor,$age);
            exit();
            $view = '
                <div>
                    <div class="header">
                        <p>'.$tuotor['familyNameCharacter'].$tuotor['firstNameCharacter'].'</p>
                    </div>
                    <div>
                        <div><img src="'.$tuotor['img'].'" style="width:150px; height: 150px;"></div>
                        <div></div>
                    <div>
                    <div>
                        <table>
                            <tr>
                                <th>年齢：</th>
                                <th>'.$age.'</th>
                            </tr>
                            <tr>
                                <th>学歴：</th>
                                <th></th>
                            </tr>
                        </table>
                    </div>
                </div>
            ';
        }





    }