<?php
namespace Core;
defined('ROOTHPATH') OR exit('Access denied');

Trait Model {
    use \Core\Database;

    protected $limit  = 100;
    protected $offset = 0;
    public    $error  = []; 

    public function create($data) {
        if(!empty($this->allowedColumns)) {
            foreach ($data as $key => $value) {
                if(!in_array($key, $this->allowedColumns)) {
                    unset($data[$key]);
                }
            }
        }
        
        $sql = '';
        $keys = array_keys($data);
        $sql = 'INSERT INTO ' . $this->table . ' (' .  implode(', ', $keys). ') VALUES (:' .  implode(', :', $keys). ')';
        $res = $this->query($sql, $data);
        return false;   
    }

    public function read($read_columns = [], $read_where = [], $read_order_columns = [], $read_order_type = '', $read_limit = '', $read_offset = '') {
        $sql = '';
        if(!empty($read_columns)) {
            $sql = 'SELECT ';
            $values = array_values($read_columns);
            foreach($values as $value) {
                $sql .= $value . ', ';
            }
            $sql = trim($sql, ', ');
            $sql .= ' FROM ' . $this->table;
        } else {
            $sql = 'SELECT * FROM ' . $this->table;
        }


        if(!empty($read_where)) {
            $sql .= ' WHERE ';
            $keys = array_keys($read_where);
            foreach($keys as $key) {
                $sql .= $key . ' LIKE :' . $key . ' && ';
            }
            $sql = trim($sql, ' && ');
        }

        if(!empty($read_order_columns)) {
            $sql .= ' ORDER BY ';
            $value = array_values($read_order_columns);
            foreach($value as $value) {
                $sql .= $value . ', ';
            }
            $sql = trim($sql, ', ');
        }

        if(!empty($read_order_type)) {
            $sql .= ' ' . $read_order_type;
        }

        if(!empty($read_limit)) {
            $sql .= ' LIMIT ' . $read_limit;
        } else {
            $sql .= ' LIMIT ' . $this->limit;
        }

        if(!empty($read_offset)) {
            $sql .= ' OFFSET ' . $read_offset;
        } else {
            $sql .= ' OFFSET ' . $this->offset;
        }

        if(!empty($read_where)) {
            $data = array_merge($read_where);
        } else {
            $data = [];
        }

        $res = $this->query($sql, $data);
        if($res) {
            return $res;
        }
        return false;    
    }

    public function update($update_key, $update_param) {
        $sql = '';
        if(!empty($this->allowedColumns)) {
            foreach ($update_key as $key => $value) {
                if(!in_array($key, $this->allowedColumns)) {
                    unset($update_key[$key]);
                }
            }
        }

        $keys   = array_keys($update_key);
        $params = array_keys($update_param);

        $sql = 'UPDATE ' . $this->table . ' SET ';
        foreach($keys as $key) {
            $sql .= $key . ' = :' . $key . ', ';
        }
        $sql = trim($sql, ', ');

        $sql .= ' WHERE ';
        foreach($params as $param) {
            $sql .= $param . ' = :' . $param . ' && ';
        }
        $sql = trim($sql, ' && ');

        $data = array_merge($update_key, $update_param);
        $res = $this->query($sql, $data);
        if($res) {
            return $res;
        }
        return false;
    }

    public function delete($delete_key, $delete_param) {
        $sql = '';
        if(!empty($this->allowedColumns)) {
            foreach ($delete_key as $key => $value) {
                if(!in_array($key, $this->allowedColumns)) {
                    unset($delete_key[$key]);
                }
            }
        }

        $keys   = array_keys($delete_key);
        $params = array_keys($delete_param);

        $sql = 'UPDATE ' . $this->table . ' SET ';
        foreach($keys as $key) {
            $sql .= $key . ' = :' . $key . ', ';
        }
        $sql = trim($sql, ', ');

        $sql .= ' WHERE ';
        foreach($params as $param) {
            $sql .= $param . ' = :' . $param . ' && ';
        }
        $sql = trim($sql, ' && ');

        $data = array_merge($delete_key, $delete_param);
        $res = $this->query($sql, $data);
        return false;
    }
}