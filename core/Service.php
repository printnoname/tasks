<?php

namespace Core;

abstract class Service {
    
    protected $pdo;

    function __construct(){
        $this->pdo = Application::getInstance()->getPDOConnection();
    }
};

?>