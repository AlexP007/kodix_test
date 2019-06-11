<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class CreateCarTable extends AbstractMigration
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
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        //creating table car
        $table = $this->table('car', ['id' => false , 'primary_key' => 'car_id']);
        
        //creating columns
        
        $table->addColumn('car_id', 'string', ['limit'=> 27])
              ->addColumn('brand', 'string')
              ->addColumn('model', 'string')
              ->addColumn('price', 'integer', ['signed' => false])
              ->addColumn(
                  'status',
                  'set',
                  ['values' => ['В пути', 'На складе', 'Продан', 'Снят с продажи']]
              )
              ->addColumn('run', 'integer', ['limit' => MysqlAdapter::INT_MEDIUM, 'signed' => false])
              ->create();
    }
}
