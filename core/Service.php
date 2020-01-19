<?php

namespace Core;

/**
 * Базовый сервис
 * Содержит ссылку на pdo для манипуляции данными
 * 
 * 
 * @package   Core
 * @author    Levan Buchukuri <Levanbuchukuri1993@gmail.com>
 */
abstract class Service {
    
    protected $pdo;

    function __construct(){
        $this->pdo = Application::getInstance()->getPDOConnection();
    }
};

?>