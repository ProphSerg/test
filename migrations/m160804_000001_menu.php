<?php

use yii\db\Migration;

/**
 * Handles the creation for table `key_table`.
 */
class m160804_000001_menu extends Migration {

	/**
	 * @inheritdoc
	 */
	public function safeUp() {

		$timestamp = mktime(0, 0, 0, 8, 4, 2016);

		echo "Check user Admin ... ";
		if ($this->db->createCommand('SELECT * FROM user WHERE username = "admin"')->queryOne() === false) {
			echo "No user. Create ... ";
			$this->insert('user', [
				'username' => 'admin',
				'auth_key' => Yii::$app->security->generateRandomString(),
				'password_hash' => Yii::$app->security->generatePasswordHash('admin'),
				'email' => 'admin@local.local',
				'status' => 10,
				'created_at' => $timestamp,
				'updated_at' => $timestamp,
			]);
		}
		$admin = $this->db->createCommand('SELECT id FROM user WHERE username = "admin"')->queryOne();
		echo "Done.\n";

		$this->batchInsert('auth_item', ['name', 'type', 'created_at', 'updated_at'], [
			['/admin', 2, $timestamp, $timestamp],
			['/atm', 2, $timestamp, $timestamp],
			['/atm/atmlist', 2, $timestamp, $timestamp],
			['/atm/orders', 2, $timestamp, $timestamp],
			['/atm/techs', 2, $timestamp, $timestamp],
			['/gii', 2, $timestamp, $timestamp],
			['/info', 2, $timestamp, $timestamp],
			['/info/phpinfo', 2, $timestamp, $timestamp],
			['/request', 2, $timestamp, $timestamp],
			['/request/actived', 2, $timestamp, $timestamp],
			['/request/add/1', 2, $timestamp, $timestamp],
			['/request/add/2', 2, $timestamp, $timestamp],
			['/request/closed', 2, $timestamp, $timestamp],
			['/site/login', 2, $timestamp, $timestamp],
			['/site/logout', 2, $timestamp, $timestamp],
			['AllUser', 2, $timestamp, $timestamp],
			['Atm', 2, $timestamp, $timestamp],
			['GII', 2, $timestamp, $timestamp],
			['Info', 2, $timestamp, $timestamp],
			['RBAC', 2, $timestamp, $timestamp],
			['Request', 2, $timestamp, $timestamp],
			['РольAdmin', 1, $timestamp, $timestamp],
			['РольAtm', 1, $timestamp, $timestamp],
			['РольЗаявки', 1, $timestamp, $timestamp],
		]);

		$this->batchInsert('auth_item_child', ['parent', 'child'], [
			['AllUser', '/site/logout'],
			['Atm', '/atm'],
			['Atm', '/atm/atmlist'],
			['Atm', '/atm/orders'],
			['Atm', '/atm/techs'],
			['GII', '/gii'],
			['Info', '/info'],
			['Info', '/info/phpinfo'],
			['RBAC', '/admin'],
			['Request', '/request'],
			['Request', '/request/actived'],
			['Request', '/request/add/1'],
			['Request', '/request/add/2'],
			['Request', '/request/closed'],
			['РольAdmin', 'GII'],
			['РольAdmin', 'Info'],
			['РольAdmin', 'RBAC'],
			['РольAdmin', 'РольAtm'],
			['РольAdmin', 'РольЗаявки'],
			['РольAtm', 'Atm'],
			['РольЗаявки', 'AllUser'],
			['РольЗаявки', 'Request'],
		]);

		$this->batchInsert('auth_assignment', ['item_name', 'user_id', 'created_at'], [
			['РольAdmin', $admin['id'], $timestamp],
			['AllUser', $admin['id'], $timestamp],
		]);

		$this->batchInsert('menu', ['id', 'name', 'parent', 'order'], [
			[1, 'TopMenu', null, null],
			[2, 'atm', null, null],
			[3, 'request', null, null],
			[4, 'systemInfo', null, null],
			[5, 'Admin', 1, 50],
		]);

		$this->batchInsert('menu', ['parent', 'name', 'route', 'order'], [
			[1, 'Заявки', '/request', 1],
			[1, 'Банкоматы', '/atm', 2],
			[1, "CODE:return '<li>' . yii\\helpers\\Html::beginForm(['/site/logout'], 'post', ['class' => 'navbar-form']) . yii\\helpers\\Html::submitButton('Выйти (' . Yii::\$app->user->identity->username . ')', ['class' => 'btn btn-link']) . yii\\helpers\\Html::endForm() . '</li>';", '/site/logout', 100],
			[1, 'Вход', '/site/login', 10],
			[2, 'Заявки', '/atm/orders', 1],
			[2, 'Список банкоматов', '/atm/atmlist', 10],
			[2, 'Инженеры', '/atm/techs', 20],
			[3, 'Активные заявки', '/request/actived', 1],
			[3, 'Закрытые заявки', '/request/closed', 2],
			[3, 'Добавить заявку ТСП', '/request/add/1', 10],
			[3, 'Добавить заявку по банкомату', '/request/add/2', 11],
			[4, 'PHP Info', '/info/phpinfo', 10],
			[5, 'Gii', '/gii', 100],
			[5, 'RBAC', '/admin', 99],
			[5, 'System Info', '/info', 50],
		]);
	}

	/**
	 * @inheritdoc
	 */
	public function safeDown() {
		#return false;
	}

}
