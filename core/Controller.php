<?php
namespace Core;

class Controller {
    


    public function __construct(){

    }

    protected function render($view, $vars = []) {
        echo Application::getInstance()->getRenderer()->render($view,$vars);
    }
}

?>