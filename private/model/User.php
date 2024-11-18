<?php
class User {
    use \Core\Model;

    protected $table = 'user';
    protected $allowedColumns = [
        'user_firstName',
        'user_lastName',
        'user_email',
        'user_password',
        'user_image',
        'user_dateRegistered',
        'user_profile_id',
        'user_status_id',
        'user_dateStatus',
    ];

    public function validateCreate($data) {
        $this->error = [];

        if(empty($data['user_firstName'])) {
            $this->error['user_firstName'] = 'Primeiro Nome vazio!';
        }

        if(empty($data['user_lastName'])) {
            $this->error['user_lastName'] = 'Sobrenome vazio!';
        }

        if(empty($data['user_email'])) {
            $this->error['user_email'] = 'E-mail vazio!';
        } elseif(!filter_var($data['user_email'], FILTER_VALIDATE_EMAIL)) {
            $this->error['user_email'] = 'E-mail inválido!';
        }
        
        $read_columns = ['user_email'];
        $read_where = ['user_email' => '%'.$data['user_email'].'%'];
        $read_order_columns = [];
        $read_order_type = '';
        $read_limit = '';
        $read_offset = '';
        $result = $this->read($read_columns, $read_where, $read_order_columns, $read_order_type, $read_limit, $read_offset);
        if(!empty($result)) {
            $this->error['user_email'] = 'E-mail já cadastrado!';
        }


        if(empty($data['user_password'])) {
            $this->error['user_password'] = 'Senha vazia!';
        }

        if(empty($this->error)) {
            return true;
        }
        return false;
    }

    public function validateLogin($data) {
        $this->error = [];

        if(empty($data['user_email'])) {
            $this->error['user_email'] = 'E-mail vazio!';
        } elseif(!filter_var($data['user_email'], FILTER_VALIDATE_EMAIL)) {
            $this->error['user_email'] = 'E-mail inválido!';
        }

        if(empty($data['user_password'])) {
            $this->error['user_password'] = 'Senha vazia!';
        }
        
        $read_columns = ['user_firstName, user_lastName, user_email, user_password, user_profile_id, user_status_id, user_image'];
        $read_where = ['user_email' => '%'.$data['user_email'].'%'];
        $read_order_columns = [];
        $read_order_type = '';
        $read_limit = '1';
        $read_offset = '0';
        $result = $this->read($read_columns, $read_where, $read_order_columns, $read_order_type, $read_limit, $read_offset);
        if(empty($result)) {
            $this->error['user_email'] = 'Cadastro não localizado!';
        }

        if(empty($this->error)) {
            return $result;
        }
        return false;
    }
}