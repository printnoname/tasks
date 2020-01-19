<?php

use Phinx\Migration\AbstractMigration;

class CreateUserTable extends AbstractMigration
{
    public function change(){
        $users = $this->table('users');
        $users->addColumn('username', 'string', ['limit' => 20])
              ->addColumn('password_hash', 'string', ['limit' => 100])
              ->addIndex(['username'], ['unique' => true])
              ->create();
    }
}
