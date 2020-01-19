<?php

use Phinx\Migration\AbstractMigration;

class CreateTaskTable extends AbstractMigration
{
    public function change(){
        $tasks = $this->table('tasks');
        $tasks->addColumn('username', 'string', ['limit' => 100])
              ->addColumn('email', 'string', ['limit' => 100])
              ->addColumn('text', 'string', ['limit' => 500])
              ->addColumn('status','boolean')
              ->addColumn('edited','boolean')
              ->create();
    }
}
