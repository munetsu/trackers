<?php
    class DATA{
        function __construct(){
            $this->pdo = $this->db_con();
        }

        public function db_con(){
            $dbname = 'trackers';
            $id = 'root';
            $pw = '';
            try{
                $pdo = new PDO('mysql:dbname='.$dbname.';charset=utf8;host=localhost',$id,$pw);
            } catch (PDOException $e){
                exit('DbConnectError:'.$e->getMessage());
            }
            return $pdo;
        }

        public function queryError($stmt){
            //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
            $error = $stmt->errorInfo();
            exit("QueryError:".$error[2]);
        }

        // INSERT文
        public function insert($table, $column, $values){
            $sql = "INSERT INTO $table ($column) VALUES($values)";
            $stmt = $this->pdo->prepare($sql);
            $res = $stmt->execute();
            if($res === false){
                $this->queryError($stmt);
            }
        }

        // select文
        public function select($column, $table, $conditions){
            $sql = "SELECT $column FROM $table $conditions";
            $stmt = $this->pdo->prepare($sql);
            $res = $stmt->execute();
            if($res === false){
                $this->queryError($stmt);
            }else {
                $res = $stmt->fetch(PDO::FETCH_ASSOC);
                return $res;
            }

        }


    }