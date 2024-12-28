<?php
defined('ROOTHPATH') OR exit('Access denied');
class Logoff {
    use \Core\Controller;

    public function index() {
        if(!empty($_SESSION['user_logged'])) {
            unset($_SESSION['user_logged']);
            redirect('/');
        }
    }
}