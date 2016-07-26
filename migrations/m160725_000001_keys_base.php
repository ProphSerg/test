<?php

use yii\db\Migration;

/**
 * Handles the creation for table `key_table`.
 */
class m160725_000001_keys_base extends Migration {

	public function init() {
		$this->db = 'dbKey';
		parent::init();
	}

	/**
	 * @inheritdoc
	 */
	public function up() {
		$this->createTable('key', [
			'ID' => $this->primaryKey(),
			'Number' => $this->text()->notNull(),
			'Comp1' => $this->text()->notNull(),
			'Comp2' => $this->text()->notNull(),
			'Comp3' => $this->text()->notNull(),
		]);
		$this->createIndex('IDX_NUMBER', 'key', 'Number', true);
	}

	/**
	 * @inheritdoc
	 */
	public function down() {
		$this->dropTable('key');
		#return false;
	}

}
