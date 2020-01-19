<?php

use Phinx\Migration\AbstractMigration;

class CreteAdminUser extends AbstractMigration
{
    public function up()
    {

        $adminUser = [
            'username' => 'admin',
            'password_hash' => password_hash("123",PASSWORD_DEFAULT),
        ];

        $table = $this->table('users');
        $table->insert($adminUser);
        $table->saveData();

    }

    public function down()
    {
        $this->execute('DELETE FROM users');
    }
}
