<?php

use yii\db\Schema;
use yii\db\Migration;

class m150619_080000_storage_item extends Migration
{
	public function up()
	{
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}

		$this->createTable('{{%storage_item}}', [
			'id' => $this->primaryKey(10)->unsigned(),
			'mime_type' => $this->string()->notNull(),
			'file_path' => $this->string()->notNull(),

			'created_at' => $this->integer(10)->unsigned()->notNull(),
			'updated_at' => $this->integer(10)->unsigned()->null(),
		], $tableOptions);
	}

	public function down()
	{
		$this->dropTable('{{%storage_item}}');
	}
}
