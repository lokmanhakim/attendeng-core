<?php

use Phinx\Migration\AbstractMigration;

class CreateTableTransaction extends AbstractMigration
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
        $transaction = $this->table('transactions')
            ->addColumn('terminal_id', 'string', array('limit' => 30))
            ->addColumn('terminal_time', 'integer')
            ->addColumn('device_id',  'string', array('default' => 30))
            ->addColumn('device_time', 'integer')
            ->addColumn('action', 'string', array('limit' => 2))
            ->addColumn('username', 'string', array('limit' => 25))
            ->addColumn('created_at', 'timestamp', array('default' => 'CURRENT_TIMESTAMP'))
            ->create();
    }
}
