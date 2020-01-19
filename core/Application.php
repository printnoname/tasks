<?php

namespace Core;

use \Bramus\Router\Router;

class Application
{

    private static $instance = null;

    private $router;
    private $db;
    private $config;
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

    protected function __construct($config)
    {
        $this->config = $config;
        $this->router = $this->initRouter();

        $this->db = $this->initDbConnection($config);

        $loader = new \Twig\Loader\FilesystemLoader(dirname(__DIR__) . "/app/views/templates");
        $twig = new \Twig\Environment($loader, []);

        $twig->addGlobal('session', $_SESSION);

        $this->twig = $twig;
    }

    public function run()
    {
        $this->db->connect();
        $this->router->run();
    }

    private function initRouter()
    {

        $_router = new Router;
        $_router->setNamespace('\App\Controllers');

        $_router->get('/', 'SiteController@list');
        $_router->get('/list', 'SiteController@list');

        $_router->post('/login', 'UserController@login');

        $_router->get('/login', 'UserController@login');

        $_router->get('/profile', 'UserController@profile');

        $_router->post('/logout','UserController@logout');

        $_router->get('/task/add','SiteController@addTask');
        $_router->post('/task/add','SiteController@addTask');

        $_router->get('/task/update','SiteController@updateTask');
        $_router->post('/task/update','SiteController@updateTask');

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
