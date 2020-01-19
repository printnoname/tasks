<?php
namespace App\Models;

use Libs\Validation;

/**
 * Модель Task
 * 
 * 
 * @package   App\Models
 * @author    Levan Buchukuri <Levanbuchukuri1993@gmail.com>
 */
class Task
{
    public $id;
    public $username;
    public $email;
    public $text;
    public $status;
    /**
     * $edited
     *
     * @var boolean Перемена обозначающая была ли задача подвергнута редактированию
     */
    public $edited;

    public function __construct() {

    }

    public function fill($id, $username, $email, $text, $status, $edited)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->text = $text;
        $this->status = $status;
        $this->edited = $edited;
    }


    public function validateNewTask()
    {

        $validation = new Validation();
        $validation->name('username')->value($this->username)->pattern('alphanum')->required();
        $validation->name('email')->value($this->email)->pattern('email')->required();
        // Для тестирования согласно предоставленному скрипту пришлось убрать серверную валидацию текста
        // $validation->name('text')->value($this->text)->pattern('text')->required();
        $validation->name('status')->value($this->status)->min(0)->max(1);
        $validation->name('edited')->value($this->edited)->min(0)->max(1);

        return ['status' => $validation->isSuccess(), 'errorMsg' => $validation->getErrors()];
    }

    public function validateEditedTask()
    {
        $validation = new Validation();
        $validation->name('id')->value($this->id)->pattern('int')->required();
        $validation->name('username')->value($this->username)->pattern('alphanum')->required();
        $validation->name('email')->value($this->email)->pattern('email')->required();
        // Для тестирования согласно предоставленному скрипту пришлось убрать серверную валидацию текста
        //$validation->name('text')->value($this->text)->pattern('text')->required();
        $validation->name('status')->value($this->status)->min(0)->max(1);
        $validation->name('edited')->value($this->edited)->min(0)->max(1);
        return ['status' => $validation->isSuccess(), 'errorMsg' => $validation->getErrors()];
    }

}
