<?php

namespace App\Controllers;

use App\Services\TaskService;
use Core\Controller;
use Core\Paginator;

/**
 * Основной контроллер.
 * 
 * 
 * @package   App\Controllers
 * @author    Levan Buchukuri <Levanbuchukuri1993@gmail.com>
 */
class SiteController extends Controller
{

    public function list($page = 1, $sort = "id", $asc = 0)
    {

        if(isset($_GET['page'])) {
            $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_SPECIAL_CHARS);
        }

        if(isset($_GET['sort'])) {
            $sort = filter_input(INPUT_GET, 'sort', FILTER_SANITIZE_SPECIAL_CHARS);

            if(!in_array($sort,['username','email','status'])) {
                $sort = "id";
            }
        }

        if(isset($_GET['asc'])) {
            $asc = filter_input(INPUT_GET, 'asc', FILTER_SANITIZE_SPECIAL_CHARS);

            if(!in_array($asc,[0,1])) {
                $asc = 0;
            }
        }

        $taskService = new TaskService();
        
        $totalPages = \ceil($taskService->getTotalEntries() / 3);

        $paginator = new Paginator(3, $page, $totalPages);

        $tasks = $taskService->getTaskList($sort, $asc, 3, $paginator->getOffset());

        echo $this->render("index.html", ['tasks' => $tasks, 'page' => $paginator->getCurrentPage(), 'totalPages' => $totalPages, 'asc' => $asc, 'sort'=> $sort]);
    }

    public function addTask()
    {
        if (empty($_POST)) {
            $this->render("add-task.html", []);
        } else {

            $taskService = new TaskService();

            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
            $text = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_SPECIAL_CHARS);

            $result = $taskService->createTask(
                [
                    'username' => $username,
                    'email' => $email,
                    'text' => $text,
                ]
            );

            echo \json_encode($result);
        }
    }

    public function updateTask()
    {
        $taskService = new TaskService();
        if (empty($_POST)) {
            if ($_GET['id']) {
                $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
                $this->render("update-task.html", ['task' => $taskService->getTaskById($id)]);
            } else {
                header("Location : /");
            }
        } else {

            $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);

            if($id) {
                $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
                $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
                $text = \trim($text);
                $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_SPECIAL_CHARS);

                if($status == "true") {
                    $status = 1;
                } else {
                    $status = 0;
                }
                $result = $taskService->updateTask(
                    [   'id' => $id,
                        'username' => $username,
                        'email' => $email,
                        'text' => $text,
                        'status' => $status,
                    ]
                );

                echo \json_encode($result);
            } else {
                echo \json_encode(['status'=>false,'errorMessage'=>'Ошибка в запросе']);
            }
        }
    }
}
