<?php

namespace Core;

use \Bramus\Router\Router;
use App\Controllers\SiteController;
use App\Controllers\UserController;

/**
 * 
 * Application является центральном ядром системы. Через него осуществляется доступ к шаблонизатору, дб и роутингу
 * 
 * @package   Core
 * @author    Levan Buchukuri <Levanbuchukuri1993@gmail.com>
 */

class Application
{

    private static $instance = null;

    /**
     * $router
     *
     * \Bramus\Router\Router Роутер
     */
    private $router;
    /**
     * $db
     *
     * \Core\DB хелпер для доступа к базе
     */
    private $db;
    /**
     * $twig ссылка на TwigLoader
     *
     * @var undefined
     */
    private $twig;

    public static function init($config)
    {
        if (!self::$instance) {
            self::$instance = new Application($config);
        }
    }

    public static function getInstance()
    {
        return self::$instance;
    }

    /**
     * __construct
     * 
     * При создании экзэмпляра Application создаются также экзэмпляры DB и Роутера
     * 
     * @param array $config Конфигурационный массив с данными для подключения базы данных
     * @return void
     */
    protected function __construct($config)
    {
        $this->router = $this->initRouter();

        $this->db = $this->initDbConnection($config);

        $loader = new \Twig\Loader\FilesystemLoader(dirname(__DIR__) . "/app/views/templates");
        $twig = new \Twig\Environment($loader, []);

        $twig->addGlobal('session', $_SESSION);

        $this->twig = $twig;
    }

    
    /**
     * run
     *
     * Установка соединения с DB и запуск Роутера
     * @return void
     */
    public function run()
    {
        $this->db->connect();
        $this->router->run();
    }


    /**
     * initRouter
     * 
     * Установка путей и midllewares
     *
     * @return void
     */
    private function initRouter()
    {

        $_router = new Router;

        $siteController = new SiteController();
        $userController = new UserController();

        $_router->get('/', function() {
            $siteController->list();
        });

        $_router->get('/list', function() {
            $siteController->list();
        });

        $_router->get('/login', function() {
            $userController->login();
        });

        $_router->post('/login', function() {
            $userController->login();
        });

        $_router->get('/profile', function() {
            $userController->profile();
        });

        $_router->post('/logout', function() {
            $userController->logout();
        });


        $_router->get('/task/add', function() {
            $userController->addTask();
        });

        $_router->post('/task/add', function() {
            $userController->addTask();
        });

        $_router->get('/task/update', function() {
            $userController->updateTask();
        });

        $_router->post('/task/update', function() {
            $userController->updateTask();
        });

        $_router->before('GET', '/profile.*', function () {
            if(!isset($_SESSION['username'])) {
                header("Location: /login");
                exit();
            }
        });

        $_router->before('POST', '/logout.*', function () {
            if(!isset($_SESSION['username'])) {
                header("Location: /login");
                exit();
            }    
        });

        $_router->before('GET|POST', '/login.*', function () {
            if(isset($_SESSION['username'])) {
                header("Location: /");
                exit();
            }
        });

        $_router->before('GET', '/task/update*', function () {
            if(!isset($_SESSION['username'])) {
                header("Location: /login");
                exit();
            }
        });

        $_router->before('POST', '/task/update*', function () {
            if(!isset($_SESSION['username'])) {
                echo \json_encode(['status'=>false,'code'=>403]);
                exit();
            }
        });

        return $_router;
    }

    private function initDbConnection($config)
    {
        return new DB($config['db']);
    }

    public function getPDOConnection()
    {
        return $this->db->getPDOConnection();
    }

    public function getRenderer()
    {
        return $this->twig;
    }
}
