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
                        <div class="dialogFlex">
                            <div class="tuotorImage">
                                <img src="'.$tuotor['img'].'" class="dialogImage">
                            </div>
                            <div class="name">
                                <p>'.$tuotor['familyNameCharacter'].$tuotor['firstNameCharacter'].'</p>
                            </div>
                        </div>
                    </div>
                        
                    <div class="tuotorId" id="graph"></div>
                    
                    <div class="contents">
                        <table>
                            <tr>
                                <th class="index">年齢：</th>
                                <th class="value">'.$age.'</th>
                            </tr>
                            <tr>
                                <th class="index">学歴：</th>
                                <th class="value">'.$tuotor['gakureki'].'</th>
                            </tr>
                            <tr>
                                <th class="index">専攻：</th>
                                <th class="value">'.$tuotor['senkou'].'</th>
                            </tr>
                            <tr>
                                <th class="index">属性：</th>
                                <th class="value">'.$tuotor['zokusei'].'</th>
                            </tr>
                            <tr>
                                <th class="index">休み：</th>
                                <th class="value">'.$tuotor['holiday'].'</th>
                            </tr>
                            <tr>
                                <th class="index">生活：</th>
                                <th class="value">'.$tuotor['lifeStyle'].'</th>
                            </tr>
                            <tr>
                                <th class="index">性格：</th>
                                <th class="value">'.$tuotor['personality'].'</th>
                            </tr>
                            <tr>
                                <th class="index">期間：</th>
                                <th class="value">'.$tuotor['studyStyle'].'</th>
                            </tr>
                            <tr>
                                <th class="index">方法：</th>
                                <th class="value">'.$tuotor['studyType'].'</th>
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