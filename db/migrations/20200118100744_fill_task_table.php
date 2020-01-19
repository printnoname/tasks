<?php

use Phinx\Migration\AbstractMigration;

class FillTaskTable extends AbstractMigration
{
    public function up()
    {

        $tasks = [
            [
                'username' => 'user1',
                'email' => 'user1@gmail.com',
                'text' => 'Task1 description',
                'status' => false,
                'edited' => false,
            ],
            [
                'username' => 'user1',
                'email' => 'user1@gmail.com',
                'text' => 'Task2 description',
                'status' => false,
                'edited' => false,
            ],
            [
                'username' => 'user2',
                'email' => 'user2@gmail.com',
                'text' => 'Task3 description',
                'status' => true,
                'edited' => false,
            ],
            [
                'username' => 'user1',
                'email' => 'user1@gmail.com',
                'text' => 'Task4 description',
                'status' => false,
                'edited' => false,
            ],
            [
                'username' => 'user2',
                'email' => 'user2@gmail.com',
                'text' => 'Task5 description',
                'status' => true,
                'edited' => false,
            ],
        ];

        $this->table('tasks')->insert($tasks)->save();
    }

    public function down()
    {
        $this->execute('DELETE FROM tasks');
    }
}
