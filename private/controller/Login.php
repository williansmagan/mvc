<?php
class Login {
    use \Core\Controller;

    public function index() {
        $error1 = '';
        $error = '';
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user = new User();
            if(!empty($_POST)) {
                if($result = $user->validateLogin($_POST)) {
                    $res = $result[0];
                    if($res->user_status_id == 3) {
                        $error1 = 'Usuário/senha inválidos';
                    } elseif($res->user_status_id == 2) {
                        $error1 = 'Favor ativar sua conta antes de realizar o login!';
                    } else {
                        if(password_verify($_POST['user_password'], $res->user_password)) {
                            $_SESSION['user_logged'] = $res;
                            redirect('/admin');
                        } else {
                            $error1 = 'Usuário/senha inválidos';
                        }
                    }
                }
            }
            $error = $user->error;
        }

        $data = [
            'page_title' => 'Login | ',
            'error'      => $error,
            'error1'     => $error1,
        ];

        $this->view('header', $data);
        $this->view('admin/login', $data);
        $this->view('footer');
    }
}