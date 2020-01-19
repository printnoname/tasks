<?php

namespace App\Services;

use App\Models\Task;
use Core\Service;

/**
 * Сервис для работы с задачами
 * 
 * 
 * @package   App\Services
 * @author    Levan Buchukuri <Levanbuchukuri1993@gmail.com>
 */
class TaskService extends Service
{

    public function getTaskById($id)
    {
        $task = new Task();

        $stmt = $this->pdo->prepare('SELECT * FROM tasks WHERE `id` = ?');
        $stmt->setFetchMode(\PDO::FETCH_INTO, $task);
        $stmt->execute([$id]);
        
        $task = $stmt->fetch();
        return $task;

    }

    public function createTask($data)
    {

        $task = new Task();

        $task->fill(
            null,
            $data['username'],
            $data['email'],
            $data['text'],
            false,
            false
        );

        $validation = $task->validateNewTask();

        if ($validation['status']) {
            try {
                $sql = "INSERT INTO  `tasks` (username,email,text,status,edited) VALUES(:username,:email,:text,false,false)";

                $stmn = $this->pdo->prepare($sql);
                $stmn->bindParam(':username', $data['username']);
                $stmn->bindParam(':email', $data['email']);
                $stmn->bindParam(':text', $data['text']);
                $stmn->execute();
            } catch (\Exception $ex) {
                return ['status' => false, 'errorMsg' => ['При записи в базу произошла непредвиденная ошибка',$ex->getMessage()]];
            }
        }

        return $validation;
    }

    public function updateTask($data)
    {
        

        $id = $data['id'];

        $edited = false;

        $taskOld = $this->getTaskById($id);
        
        if(!$taskOld->edited) {
            if($taskOld->text != $data['text']) {
                $edited = true;
            }
        } else {
            $edited = true;
        }
        
        $task = new Task();
        $task->fill(
            $data['id'],
            $data['username'],
            $data['email'],
            $data['text'],
            $data['status'],
            $edited
        );

        $validation = $task->validateEditedTask();

        if ($validation['status']) {
            try {
                $sql = "UPDATE tasks  SET username=?, email=?, text=?, status=?, edited=? WHERE id=?";
                $stmn = $this->pdo->prepare($sql);
                $result = $stmn->execute([$task->username,$task->email,$task->text,(int) $task->status,(int) $task->edited,$task->id]);
            } catch (\Exception $ex) {
                return ['status' => false, 'errorMsg' => ['При записи в базу произошла непредвиденная ошибка',$ex->getMessage()]];
            }
        }

        return $validation;
    }

    public function getTaskList($sort, $asc, $limit, $offset)
    {
        if($asc == 0) {
            $asc = "DESC";
        } else {
            $asc = "ASC";
        }

        $stmt = $this->pdo->query('SELECT * FROM tasks ORDER BY ' . $sort . ' ' . $asc . ' LIMIT ' . $limit . ' OFFSET ' .  $offset);
        $tasks = $stmt->fetchAll();

        return $this->toArrayOfTasks($tasks);
    }

    public function getTotalEntries()
    {

        $sql = "SELECT count(*) FROM `tasks`";

        $result = $this->pdo->prepare($sql);
        $result->execute();

        return $result->fetchColumn();
    }

    private function  toArrayOfTasks($tasksArray) {
        $objects = [];
        foreach ($tasksArray as $task) {

            $taskObj = new Task();

            $taskObj->fill(
                $task['id'],
                $task['username'],
                $task['email'],
                $task['text'],
                $task['status'],
                $task['edited']
            );

            $objects[] = $taskObj;
        }

        return $objects;
    }

}
