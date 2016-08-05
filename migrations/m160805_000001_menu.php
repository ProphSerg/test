<?php

use yii\db\Migration;

/**
 * Handles the creation for table `key_table`.
 */
class m160805_000001_menu extends Migration {

	/**
	 * @inheritdoc
	 */
	public function safeUp() {
		$timestamp = mktime(0, 0, 0, 8, 5, 2016);

		echo "Get user Admin ... ";
		$admin = $this->db->createCommand('SELECT id FROM user WHERE username = "admin"')->queryOne();
		echo "Done.\n";

		$this->batchInsert('auth_item', ['name', 'type', 'created_at', 'updated_at'], [
			['/report', 2, $timestamp, $timestamp],
			['/report/request-close', 2, $timestamp, $timestamp],
			['Report', 2, $timestamp, $timestamp],
			['РольОтчеты', 1, $timestamp, $timestamp],
		]);

		$this->batchInsert('auth_item_child', ['parent', 'child'], [
			['Report', '/report'],
			['Report', '/report/request-close'],
			['РольОтчеты', 'Report'],
		]);

		$this->batchInsert('auth_assignment', ['item_name', 'user_id', 'created_at'], [
			['РольОтчеты', $admin['id'], $timestamp],
		]);

		$this->insert('menu', ['name' => 'reports']);
		$reports = $this->db->createCommand('SELECT id FROM menu WHERE name = "reports" AND parent IS NULL AND route IS NULL')->queryOne();

		$this->batchInsert('menu', ['parent', 'name', 'route', 'order'], [
			[1, 'Отчеты', '/report', 5],
			[$reports['id'], 'Кол-во закрытых заявок', '/report/request-close', 1],
		]);
	}

	/**
	 * @inheritdoc
	 */
	public function safeDown() {
		if (($reports = $this->db->createCommand('SELECT id FROM menu WHERE name = "reports" AND parent IS NULL AND route IS NULL')->queryOne()) !== false) {
			$this->delete('menu', ['parent' => $reports['id']]);
			$this->delete('menu', ['id' => $reports['id']]);
		}
		$this->delete('auth_assignment', ['item_name' => 'РольОтчеты']);

		$this->delete('auth_item_child', ['parent' => 'Report']);
		$this->delete('auth_item_child', ['parent' => 'РольОтчеты']);

		$this->delete('auth_item', ['name' => 'РольОтчеты']);
		$this->delete('auth_item', ['name' => 'Report']);
		$this->delete('auth_item', ['name' => '/report']);
		$this->delete('auth_item', ['name' => '/report/request-close']);

		#return false;
	}

}
