<?php
namespace Core;
defined('ROOTHPATH') OR exit('Access denied');


Trait Database {
    private function connect() {
		$str  = TYPE_DB . ':dbname=' . NAME_DB . ';host=' . HOST_DB . ';port=' . PORT_DB . CHAR_DB;
		$conn = new \PDO($str, USER_DB, PASS_DB, OPT_DB);
        return $conn;
    }

    public function query($sql = '', $data = []) {
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $check = $stmt->execute($data);
        if($check) {
            $result = $stmt->fetchAll(\PDO::FETCH_OBJ);
            if(is_array($result) && count($result)) {
                return $result;
            }
        }
        return false;
    }
}