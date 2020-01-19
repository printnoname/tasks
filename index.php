<?php 

/**
 * Входная точка приложения
 * Здесь инициализируется ядро сайта
 */
require './vendor/autoload.php';

	use Core\Application;
	use App\Models\Task;

	session_start();
	
	$config = require('./configs/config-local.php');

	Application::init($config);
	Application::getInstance()->run();
?>