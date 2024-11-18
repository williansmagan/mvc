<?php
class Admin {
    use \Core\Controller;

    public function __construct() {
        if(empty($_SESSION['user_logged'])) {
            redirect('/login');
        }     
    }

    public function index() {
        $data = [
            'page_title' => 'Dashboard | ',
            'session'    => $_SESSION['user_logged'],
        ];

        $this->view('admin/header', $data);
        $this->view('admin/home', $data);
        $this->view('admin/footer');
    }

    public function user($param1 = '', $param2 = '') {
        $error   = '';
        $success = '';

        $user = new User();
        if(!empty($_POST)) {
            if($user->validateCreate($_POST)) {
                $values = [
                    'user_firstName' => $_POST['user_firstName'],
                    'user_lastName' => $_POST['user_lastName'],
                    'user_email' => $_POST['user_email'],
                    'user_password' => hash_password($_POST['user_password'],),
                    'user_dateRegistered' => default_date(),
                    'user_profile_id' => 2, 
                    'user_status_id' => 1, 
                    'user_dateStatus' => default_date(),
                ];
                $result = $user->create($values);
                $success = 'Usuário cadastrado com sucesso!';
            }
            $error = $user->error;
        }

        $read_columns = [
            'user_id',
            'user_firstName',
            'user_lastName',
            'user_email',
            'user_status_id',
        ];
        $read_where = [];
        $read_order_columns = ['user_id',];
        $read_order_type = 'ASC';
        $read_limit = '';
        $read_offset = '';
        $result = $user->read($read_columns, $read_where, $read_order_columns, $read_order_type, $read_limit, $read_offset);

        $data = [
            'page_title'  => 'User Dashboard | ',
            'result_user' => $result,
            'error'       => $error,
            'success'     => $success,
            'session'    => $_SESSION['user_logged'],
        ];

        $this->view('admin/header', $data);
        $this->view('admin/user/home', $data);
        $this->view('admin/footer');  
    }
}