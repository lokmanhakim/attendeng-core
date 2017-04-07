<?php

use Phinx\Migration\AbstractMigration;

class CreateTableUser extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $users = $this->table('users')
            ->addColumn('username', 'string', array('limit' => 25))
            ->addColumn('email', 'string', array('limit' => 50))
            ->addColumn('password', 'string', array('limit' => 100))
            ->addColumn('token_hash', 'string', array('limit' => 100, 'null' => true))
            ->addColumn('token_expiry', 'timestamp', array('null' => true))
            ->addColumn('status', 'string', array('limit' => 15, 'default' => 'active'))
            ->addColumn('created_at', 'timestamp', array('default' => 'CURRENT_TIMESTAMP'))
            ->addColumn('updated_at', 'timestamp', array('null' => true))
            ->addColumn('deleted_at', 'timestamp', array('null' => true))
            ->addIndex(array('email'), array('unique' => true))
            ->addIndex(array('username'), array('unique' => true))
            ->create();
    }
}
