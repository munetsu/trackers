<?php
    class VIEW{

        function __construct(){

        }

        // チューター詳細表示画面
        public function tuotorRender($tuotor,$age,$index, $uid){
            // $tuotor = json_decode($tuotor);
            $tuotor = $tuotor[0];
            $index = $index;
            
            // var_dump($tuotor['id']);
            // exit();
            $view = '
                <div id="dialog" data-value="'.$uid.'" style="display:none;">
                    <div class="header">
                        <p>'.$tuotor['familyNameCharacter'].$tuotor['firstNameCharacter'].'</p>
                    </div>
                    <div class="flex">
                        <div><img src="'.$tuotor['img'].'" style="width:150px; height: 150px;"></div>
                        <div class="tuotorId" id="graph"></div>
                    </div>
                    <div class="contents">
                        <table>
                            <tr>
                                <th>年齢：</th>
                                <th>'.$age.'</th>
                            </tr>
                            <tr>
                                <th>学歴：</th>
                                <th>'.$tuotor['gakureki'].'</th>
                            </tr>
                            <tr>
                                <th>専攻：</th>
                                <th>'.$tuotor['senkou'].'</th>
                            </tr>
                            <tr>
                                <th>属性：</th>
                                <th>'.$tuotor['zokusei'].'</th>
                            </tr>
                            <tr>
                                <th>休み：</th>
                                <th>'.$tuotor['holiday'].'</th>
                            </tr>
                            <tr>
                                <th>生活リズム：</th>
                                <th>'.$tuotor['lifeStyle'].'</th>
                            </tr>
                            <tr>
                                <th>性格：</th>
                                <th>'.$tuotor['personality'].'</th>
                            </tr>
                            <tr>
                                <th>勉強スタイル：</th>
                                <th>'.$tuotor['studyStyle'].'</th>
                            </tr>
                            <tr>
                                <th>勉強法：</th>
                                <th>'.$tuotor['studyType'].'</th>
                            </tr>
                        </table>
                    </div>
                </div>
                <script>
                    var per = "'.$index.'";
                    function graph(per){
                        $("#graph").circularloader({
                        progressPercent: per,
                        backgroundColor: "#ffffff",//background colour of inner circle
                        fontColor: "#000000",//font color of progress text
                        fontSize: "40px",//font size of progress text
                        radius: 80,//radius of circle
                        progressBarBackground: "#ffffff",//background colour of circular progress Bar
                        progressBarColor: "#F4A460",//colour of circular progress bar
                        progressBarWidth: 15,//progress bar width
                        showText: true,//show progress text or not
                        title: "マッチ度",//show header title for the progress bar
                    });
                    };
                    $("#graph").append(graph(per));
                </script>                
            ';

            echo $view;
        }





    }