<?php 

require './vendor/autoload.php';

	use Core\Application;
	use App\Models\Task;

	session_start();
	
	$config = require('./configs/config-local.php');

	Application::init($config);
	Application::getInstance()->run();
?>