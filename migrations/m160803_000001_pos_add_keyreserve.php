<?php

use yii\db\Migration;

/**
 * Handles the creation for table `key_table`.
 */
class m160803_000001_pos_add_keyreserve extends Migration {

	public function init() {
		$this->db = 'dbPos';
		parent::init();
	}

	/**
	 * @inheritdoc
	 */
	public function safeUp() {
		$this->createTable('KeyReserve', [
			'Number' => $this->text()->notNull(),
			'Comment' => $this->text()->notNull(),
			'PRIMARY KEY (Number)'
		]);
		#$this->createIndex('IDX_KR_NUMBER', 'KeyReserve', 'Number', true);
		
	}

	/**
	 * @inheritdoc
	 */
	public function safeDown() {
		$this->dropTable('KeyReserve');
		#return false;
	}

}
