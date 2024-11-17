<?php
namespace Core;

class App {
    private $controller = '_404';
    private $method     = 'index';

    private function splitURL() {
        $url = $_GET['url'] ?? 'home';
        $url = explode('/', trim($url, '/'));
        return $url;
    }
    
    public function loadController() {
        $url  = $this->splitURL();
        $file = '../private/controller/'.ucfirst($url[0]).'.php';
        if(file_exists($file)) {
            $this->controller = ucfirst($url[0]);
            unset($url[0]);
        }
        require_once '../private/controller/'.$this->controller.'.php';

        $this->controller = new $this->controller;

        if(!empty($url[1])) {
            if(method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }
        call_user_func_array([$this->controller, $this->method], $url);
    }
}