<?php

    class DATA{
        function __construct(){
            $this->pdo = $this->db_con();
        }

        public function db_con(){
            $dbname = 'trackers_new';
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
            // var_dump($column);
            // exit();
            $sql = "INSERT INTO $table ($column) VALUES($values)";
            // var_dump($sql);
            // exit();
            $stmt = $this->pdo->prepare($sql);
            $res = $stmt->execute();
            if($res === false){
                return $this->queryError($stmt);
            }
        }

        // select文(取得データが1件の場合)
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

        // select文(取得データが複数件の場合)
        public function selectAll($column, $table, $conditions){
            $sql = "SELECT $column FROM $table $conditions";
            $stmt = $this->pdo->prepare($sql);
            $res = $stmt->execute();
            if($res === false){
                $this->queryError($stmt);
            }else {
                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $res;
            }
        }

        // UPDATE文
        public function update($table, $values, $conditions){
            $sql = "UPDATE $table SET $values $conditions";
            $stmt = $this->pdo->prepare($sql);
            $res = $stmt->execute();
            if($res === false){
                return $this->queryError($stmt);
            }
        }

        // select inner join文
        public function selectInnerJoin($column, $table1, $table2, $column1, $column2){
            $sql = "SELECT $column FROM $table1 INNER JOIN $table2 ON $column1 = $column2";
            $stmt = $this->pdo->prepare($sql);
            $res = $stmt->execute();
            if($res === false){
                $this->queryError($stmt);
            }else {
                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $res;
            }
        }
    }