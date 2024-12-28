<?php
defined('ROOTHPATH') OR exit('Access denied');
class Register {
    use \Core\Controller;

    public function index() {
        $user = new User();
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $res = [];
            $res = $user->createUser($_POST);
            if($res) {
                redirect('/admin/login');
            }
        }

        $data = [
            'page_title' => 'Criar Conta | ',
            'message'    => $user->message,
        ];

        $this->view('header', $data);
        $this->view('home/register', $data);
        $this->view('footer');
    }
}