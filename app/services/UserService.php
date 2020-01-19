<?php
namespace App\Services;

use Core\Service;

/**
 * Сервис для работы с пользователем и авторизацией
 * 
 * 
 * @package   App\Services
 * @author    Levan Buchukuri <Levanbuchukuri1993@gmail.com>
 */
class UserService extends Service
{

    public function validateUserPassword($username, $password)
    {

        $status = [];

        if ($username && $password) {
            try {
                $sql = "SELECT * FROM users where username = ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$username]);
                $result = $stmt->fetch();

                $password_hash = $result['password_hash'];

                if (password_verify($password, $password_hash)) {
                    $status = ['status' => true];
                } else {
                    $status = ['status' => false, 'errorMsg' => 'Неверный логин или пароль'];
                }

            } catch (\Exceptions $dbException) {
                $status = ['status' => false, 'errorMsg' => 'Ошибка запроса к базе данных'];
            }

        } else {
            $status = ['status' => false, 'errorMsg' => 'Одно из полей пустое'];
        }

        return $status;
    }


    public function getProfileData($username)
    {

        $status = [];

        if ($username) {
            try {
                $sql = "SELECT * FROM users where username = ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$username]);
                $result = $stmt->fetch();

                return ['status'=>true, 'data'=> $result];

            } catch (\Exceptions $dbException) {
                $status = ['status' => false, 'errorMsg' => 'Ошибка запроса к базе данных'];
            }

        } else {
            $status = ['status' => false, 'errorMsg' => 'Имя пользователя не указано'];
        }

        return $status;
    }
}
