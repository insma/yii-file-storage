<?php

use yii\db\Schema;
use yii\db\Migration;

class m150619_080000_storeage_item extends Migration
{
	public function up()
	{
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}

		$this->createTable('{{%storeage_item}}', [
			'id' => Schema::TYPE_PK,
			'mime_type' => Schema::TYPE_STRING . ' NOT NULL',
			'file_path' => Schema::TYPE_STRING . ' NOT NULL',

			'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
			'updated_at' => Schema::TYPE_INTEGER . ' NULL',
		], $tableOptions);

		if ($this->db->driverName === 'mysql') {
			$this->alterColumn('{{%storeage_item}}', 'id', Schema::TYPE_INTEGER . '(10) UNSIGNED NOT NULL AUTO_INCREMENT');
			$this->alterColumn('{{%storeage_item}}', 'created_at', Schema::TYPE_INTEGER . '(10) UNSIGNED NOT NULL');
			$this->alterColumn('{{%storeage_item}}', 'updated_at', Schema::TYPE_INTEGER . '(10) UNSIGNED NULL');
		}
	}

	public function down()
	{
		$this->dropTable('{{%storeage_item}}');
	}
}
