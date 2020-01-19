<?php

    namespace Core;

    /**
    * Хэлпер для работы с базой данных и pdo
    * 
    * @package   Core
    * @author    Levan Buchukuri <Levanbuchukuri1993@gmail.com>
    */
    class DB {
        private $configData;
        private $pdoConnection;

        public function __construct($dbConfig){
            $this->configData  = $dbConfig;
        }

        public function connect() {
            $this->pdoConnection = new \PDO('mysql:host=' . $this->configData['hostname'] . ';dbname=' . $this->configData['dbname'],
                                $this->configData['username'], 
                                $this->configData['password']);

            $this->pdoConnection->query('SET NAMES utf8');
            $this->pdoConnection->query('SET CHARACTER_SET utf8_unicode_ci');

            $this->pdoConnection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
            $this->pdoConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        public function getPDOConnection(){
            return $this->pdoConnection;
        }
    }