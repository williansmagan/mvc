<?php
defined('ROOTHPATH') OR exit('Access denied');
class _404 {
    use \Core\Controller;

    public function index() {
        $this->view('error/404');
    }
}