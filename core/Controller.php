<?php
namespace Core;

/**
 * 
 * Базовый контроллер
 * 
 * @package   Core
 * @author    Levan Buchukuri <Levanbuchukuri1993@gmail.com>
 */
class Controller {
    


    /**
     * __construct
     *
     * @return void
     */
    public function __construct(){

    }

    /**
     * Обертка для рендеринга страниц с помощью Twig Loader'а
     *
     * @param mixed $view имя представления
     * @param mixed $vars параметры
     * @return void
     */
    protected function render($view, $vars = []) {
        echo Application::getInstance()->getRenderer()->render($view,$vars);
    }
}

?>