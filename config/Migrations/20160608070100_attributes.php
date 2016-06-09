<?php

use Phinx\Migration\AbstractMigration;

class Attributes extends AbstractMigration
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
  	$table = $this->table('Attributes');
        $table
            ->addColumn('friendlyname', 'string', [
	            	'limit' => 255,
                'null' => false,
            ])
            ->addColumn('oid', 'string', [
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('schema', 'string', [
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('validation', 'string', [
                'limit' => 255,
                'null' => false,
            ])
      	    ->addColumn('created', 'datetime', [
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'null' => false,
            ])->create();
    }
}
