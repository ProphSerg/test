<?php

use yii\db\Migration;

/**
 * Handles the creation for table `key_table`.
 */
class m160726_000002_menu extends Migration {

	/**
	 * @inheritdoc
	 */
	public function safeUp() {
		$timestamp = mktime(0, 0, 0, 7, 26, 2016);

		echo "Get user Admin ... ";
		$admin = $this->db->createCommand('SELECT id FROM user WHERE username = "admin"')->queryOne();
		echo "Done.\n";

		$this->batchInsert('auth_item', ['name', 'type', 'created_at', 'updated_at'], [
			['/report', 2, $timestamp, $timestamp],
			['/report/range/request-close', 2, $timestamp, $timestamp],
			['Report', 2, $timestamp, $timestamp],
			['РольОтчеты', 1, $timestamp, $timestamp],
		]);

		$this->batchInsert('auth_item_child', ['parent', 'child'], [
			['Report', '/report'],
			['Report', '/report/range/request-close'],
			['РольОтчеты', 'Report'],
			['РольAdmin', 'РольОтчеты'],
		]);

		/*
		  $this->batchInsert('auth_assignment', ['item_name', 'user_id', 'created_at'], [
		  ['РольОтчеты', $admin['id'], $timestamp],
		  ]);
		 */

		$this->insert('menu', ['name' => 'reports']);
		$reports = $this->db->createCommand('SELECT id FROM menu WHERE name = "reports" AND parent IS NULL AND route IS NULL')->queryOne();

		$this->batchInsert('menu', ['parent', 'name', 'route', 'order'], [
			[1, 'Отчеты', '/report', 30],
			[$reports['id'], 'Кол-во закрытых заявок', '/report/range/request-close', 1],
		]);
	}

	/**
	 * @inheritdoc
	 */
	public function safeDown() {
		$this->delete('menu', ['parent' => 1, 'name' => 'Отчеты']);
		if (($reports = $this->db->createCommand('SELECT id FROM menu WHERE name = "reports" AND parent IS NULL AND route IS NULL')->queryOne()) !== false) {
			$this->delete('menu', ['parent' => $reports['id']]);
			$this->delete('menu', ['id' => $reports['id']]);
		}
		$this->delete('auth_assignment', ['item_name' => 'РольОтчеты']);

		$this->delete('auth_item_child', ['parent' => 'Report']);
		$this->delete('auth_item_child', ['parent' => 'РольОтчеты']);
		$this->delete('auth_item_child', ['child' => 'РольОтчеты']);

		$this->delete('auth_item', ['name' => 'РольОтчеты']);
		$this->delete('auth_item', ['name' => 'Report']);
		$this->delete('auth_item', ['like', 'name', '/report']);

		#return false;
	}

}
