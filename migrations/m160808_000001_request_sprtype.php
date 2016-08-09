<?php

use yii\db\Migration;
use app\models\request\arRequest;
/**
 * Handles the creation for table `key_table`.
 */
class m160808_000001_request_sprtype extends Migration {

	public function init() {
		$this->db = 'dbRequest';
		parent::init();
	}

	/**
	 * @inheritdoc
	 */
	public function safeUp() {

		$this->createTable('sprType', [
			'ID' => $this->integer()->notNull()->unique(),
			'Name' => $this->text()->notNull(),
		]);

		$this->batchInsert('sprType', ['ID', 'Name'], [
			[arRequest::REQUEST_SD,'Заявки с SD'],
			[arRequest::REQUEST_TS,'Заявки от ТСП'],
			[arRequest::REQUEST_ATM,'Заявки на банкоматы'],
		]);
	}

	/**
	 * @inheritdoc
	 */
	public function down() {
		$this->dropTable('sprType');
	}

}
