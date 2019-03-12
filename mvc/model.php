<?php
    include('data.php');

    class MODEL{
        function __construct(){
            $this->db = new DATA;
        }

        public function tuotorRegister($array){
            // データ開封
            // var_dump($array);
            // exit();

            // 送信時間
            $sendtime = date("Y/m/d H:i:s");

            $table = 'tuotorRegisters';
            $column = "`name`, 
                        `email`,
                         `tel`,
                         `certification`,
                         `firstDate`,
                         `firstStartTime`,
                         `firstFinishTime`,
                         `secondDate`,
                         `secondStartTime`,
                         `secondFinishTime`,
                         `thirdDate`,
                         `thirdStartTime`,
                         `thirdFinishTime`,
                         `sendTime`";
            $values = "'".$array['name']."'".",".
                        "'".$array['email']."'".",".
                        "'".$array['tel']."'".",".
                        "'".$array['certification']."'".",".
                        "'".$array['firstDate']."'".",".
                        "'".$array['f_startTime']."'".",".
                        "'".$array['f_finishTime']."'".",".
                        "'".$array['secondDate']."'".",".
                        "'".$array['s_startTime']."'".",".
                        "'".$array['s_finishTime']."'".",".
                        "'".$array['thirdDate']."'".",".
                        "'".$array['t_startTime']."'".",".
                        "'".$array['t_finishTime']."'".",".
                        "'".$sendtime."'";
            $this->db->insert($table, $column, $values);
            echo '日程に関しては、頂いたメールアドレス宛に返信します。';
            exit();
        }












    }