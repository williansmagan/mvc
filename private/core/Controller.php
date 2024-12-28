<?php
namespace Core;
defined('ROOTHPATH') OR exit('Access denied');

Trait Controller {
    private $view = '404';

    public function view($value, $data = []) {
        if(!empty($data)) {
            extract($data);
        }
        
        $viewFile = '../private/view/'.$value.'.phtml';
        if(file_exists($viewFile)) {
            $this->view = $value;
        }
        require_once '../private/view/'.$this->view.'.phtml';
    }
}