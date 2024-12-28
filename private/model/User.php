<?php
defined('ROOTHPATH') OR exit('Access denied');

class User {
    use \Core\Model;

    protected $table = 'user';
    protected $allowedColumns = [
        'user_code_unique',
        'user_firstName',
        'user_lastName',
        'user_email',
        'user_password',
        'user_image',
        'user_dateRegistered',
        'user_dateUpdate',
        'user_profile_id',
        'user_status_id',
        'user_dateStatus',
    ];
    public $message = [];

    public function listUser() {
        $read_columns = [
            'user_id',
            'user_code_unique',
            'user_firstName',
            'user_lastName',
            'user_email',
            'user_status_id',
        ];
        $read_where= [];
        $read_order_columns = ['user_id',];
        $read_order_type = 'DESC';
        $read_limit = '';
        $read_offset = '';
        $result = $this->read($read_columns, $read_where, $read_order_columns, $read_order_type, $read_limit, $read_offset);
        return $result;
    }

    public function validateCreate($data) {
        $this->message = [];

        if(empty($data['user_code_unique'])) {
            $this->message['error_user_code_unique'] = 'CPF vazio!';
        }

        if(empty($data['user_firstName'])) {
            $this->message['error_user_firstName'] = 'Primeiro Nome vazio!';
        }

        if(empty($data['user_lastName'])) {
            $this->message['error_user_lastName'] = 'Sobrenome vazio!';
        }

        if(empty($data['user_email'])) {
            $this->message['error_user_email'] = 'E-mail vazio!';
        } elseif(!filter_var($data['user_email'], FILTER_VALIDATE_EMAIL)) {
            $this->message['error_user_email'] = 'E-mail inválido!';
        }
        
        $read_columns = ['user_code_unique'];
        $read_where = ['user_code_unique' => '%'.$data['user_code_unique']. '%'];
        $read_order_columns = [];
        $read_order_type = '';
        $read_limit = '';
        $read_offset = '';
        $result = $this->read($read_columns, $read_where, $read_order_columns, $read_order_type, $read_limit, $read_offset);
        if(!empty($result)) {
            $this->message['error_user_code_unique'] = 'CPF já cadastrado!';
        }

        if(strlen($data['user_code_unique']) != 11) {
            $this->message['error_user_code_unique'] = 'CPF inválido!';
        }

        $read_columns = ['user_email'];
        $read_where = ['user_email' => '%'.$data['user_email']. '%'];
        $read_order_columns = [];
        $read_order_type = '';
        $read_limit = '';
        $read_offset = '';
        $result = $this->read($read_columns, $read_where, $read_order_columns, $read_order_type, $read_limit, $read_offset);
        if(!empty($result)) {
            $this->message['error_user_email'] = 'E-mail já cadastrado!';
        }


        if(empty($data['user_password'])) {
            $this->message['error_user_password'] = 'Senha vazia!';
        }

        if(empty($this->message)) {
            return true;
        }
        return false;
    }

    public function validateLogin($data) {
        $this->message = [];

        if(empty($data['user_email'])) {
            $this->message['error_user_email'] = 'E-mail vazio!';
        } elseif(!filter_var($data['user_email'], FILTER_VALIDATE_EMAIL)) {
            $this->message['error_user_email'] = 'E-mail inválido!';
        }

        if(empty($data['user_password'])) {
            $this->message['error_user_password'] = 'Senha vazia!';
        }
        
        $read_columns = ['user_firstName, user_lastName, user_email, user_password, user_profile_id, user_status_id, user_image'];
        $read_where = ['user_email' => '%'.$data['user_email'].'%'];
        $read_order_columns = [];
        $read_order_type = '';
        $read_limit = '1';
        $read_offset = '0';
        $result = $this->read($read_columns, $read_where, $read_order_columns, $read_order_type, $read_limit, $read_offset);
        if(empty($result)) {
            $this->message['error_user_email'] = 'Cadastro não localizado!';
        }

        if(empty($this->message)) {
            return $result;
        }
        return false;
    }

    public function createUser($data) {
        if(!empty($data)) {
            if($this->validateCreate($data)) {
                $values = [
                    'user_code_unique'    => $data['user_code_unique'],
                    'user_firstName'      => $data['user_firstName'],
                    'user_lastName'       => $data['user_lastName'],
                    'user_email'          => $data['user_email'],
                    'user_password'       => hash_password($data['user_password']),
                    'user_dateRegistered' => default_date(),
                    'user_dateUpdate'     => default_date(),
                    'user_profile_id'     => 2, 
                    'user_status_id'      => 1, 
                    'user_dateStatus'     => default_date(),
                ];
                $result = $this->create($values);
                $this->message['success'] = 'Usuário cadastrado com sucesso!';
            }
        }
        return false;
    }

    public function updateUser($data) {
        if(!empty($data)) {
            if(!empty($data['user_password'])) {
                $values['user_password'] = hash_password($data['user_password']);
            }

            $values = [
                'user_firstName'  => $data['user_firstName'],
                'user_lastName'   => $data['user_lastName'],
            ];
            $param = [
                'user_id' => $data['user_id'],
            ];

            $result = $this->update($values, $param);
            $this->message['success'] = 'Usuário atualizado com sucesso!';
        }
        return false;
    }

    public function deleteUser($data) {
        if(!empty($data)) {
            $values = [
                'user_status_id'  => 3,
                'user_dateUpdate' => default_date(),
            ];
            $param = [
                'user_id' => $data['user_id'],
            ];

            $result = $this->update($values, $param);
            $this->message['success'] = 'Usuário deletado com sucesso!';
        }
        return false;
    }

    public function listUniqueUser($id) {
        $read_columns = [
            'user_id',
            'user_code_unique',
            'user_firstName',
            'user_lastName',
            'user_email',
            'user_status_id',
        ];
        $read_where = ['user_id' => $id];
        $read_order_columns = [];
        $read_order_type = '';
        $read_limit = '';
        $read_offset = '';
        $result = $this->read($read_columns, $read_where, $read_order_columns, $read_order_type, $read_limit, $read_offset);
        return $result;
    }



}