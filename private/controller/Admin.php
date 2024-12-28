<?php
defined('ROOTHPATH') OR exit('Access denied');
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

    public function user($action = '', $param = '') {
        $user = new User();
        $result = [];

        if($action == 'create') {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $res = $user->createUser($_POST);
                if($res) {
                    redirect('/admin/user');
                }
            }
        } elseif($action == 'edit') {
            $result = $user->listUniqueUser($param);
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST['user_id'] = $param;
                if($user->updateUser($_POST)) {
                    redirect('/admin/user');                
                }
            }
        } elseif($action == 'delete') {
            $result = $user->listUniqueUser($param);
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST['user_id'] = $param;
                if($user->deleteUser($_POST)) {
                    redirect('/admin/user');                
                }
            }
        } else {
            $result = $user->listUser();
        }

        $data = [
            'page_title' => 'User Dashboard | ',
            'action'     => $action,
            'message'    => $user->message,
            'session'    => $_SESSION['user_logged'],
            'result'     => $result,
        ];

        $this->view('admin/header', $data);
        $this->view('admin/user/home', $data);
        $this->view('admin/footer');  
    }
}