<?php
class _404 {
    use \Core\Controller;

    public function index() {
        $this->view('error/404');
    }
}