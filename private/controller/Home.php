<?php
defined('ROOTHPATH') OR exit('Access denied');
class Home {
    use \Core\Controller;

    public function index() {
        try {
            $str  = TYPE_DB . ':dbname=' . NAME_DB . ';host=' . HOST_DB . ';port=' . PORT_DB . CHAR_DB;
            $conn = new \PDO($str, USER_DB, PASS_DB, OPT_DB);
        } catch (PDOException $e) {
            redirect('/install');
        }


        $data = [
            'page_title' => '',
        ];

        $this->view('header', $data);
        $this->view('home/home');
        $this->view('footer');
    }
}