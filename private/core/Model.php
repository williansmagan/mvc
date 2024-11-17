<?php
namespace Core;

Trait Model {
    use \Core\Database;

    protected $limit  = 100;
    protected $offset = 0;

    public function test() {
        $sql = 'SELECT * FROM user';
        $res = $this->query($sql);    }

    public function create($data) {
        if(!empty($this->allowedColumns)) {
            foreach ($data as $key => $value) {
                if(!in_array($key, $this->allowedColumns)) {
                    unset($data[$key]);
                }
            }
        }
        
        $keys = array_keys($data);
        $sql = 'INSERT INTO ' . $this->table . ' (' .  implode(', ', $keys). ') VALUES (:' .  implode(', :', $keys). ')';
        $res = $this->query($sql, $data);
        return false;   
    }

    public function read($read_columns = [], $read_where = [], $read_order_columns = [], $read_order_type = '', $read_limit = '', $read_offset = '') {
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

        $data = array_merge($read_where);
        $res = $this->query($sql, $data);
        if($res) {
            return $res;
        }
        return false;    
    }

    public function update($update_keys, $update_param) {
        if(!empty($this->allowedColumns)) {
            foreach ($data as $key => $value) {
                if(!in_array($key, $this->allowedColumns)) {
                    unset($data[$key]);
                }
            }
        }

        $keys   = array_keys($update_keys);
        $params = array_keys($update_param);

        $sql = 'UPDATE ' . $this->table . ' SET ';
        foreach($keys as $key) {
            $sql .= $key . ' = :' . $key . ' && ';
        }
        $sql = trim($sql, ' && ');

        $sql .= ' WHERE ';
        foreach($params as $param) {
            $sql .= $param . ' = :' . $param . ' && ';
        }
        $sql = trim($sql, ' && ');

        $data = array_merge($update_keys, $update_param);
        $res = $this->query($sql, $data);
        if($res) {
            return $res;
        }
        return false;
    }

    public function delete($delete_keys, $delete_params) {
        if(!empty($this->allowedColumns)) {
            foreach ($data as $key => $value) {
                if(!in_array($key, $this->allowedColumns)) {
                    unset($data[$key]);
                }
            }
        }

        $keys   = array_keys($delete_keys);
        $params = array_keys($delete_params);

        $sql = 'UPDATE ' . $this->table . ' SET ';
        foreach($keys as $key) {
            $sql .= $key . ' = :' . $key . ' && ';
        }
        $sql = trim($sql, ' && ');

        $sql .= ' WHERE ';
        foreach($params as $param) {
            $sql .= $param . ' = :' . $param . ' && ';
        }
        $sql = trim($sql, ' && ');

        $data = array_merge($delete_keys, $delete_params);
        $res = $this->query($sql, $data);
        return false;
    }
}