<?php

use yii\db\Migration;

/**
 * Handles the creation for table `key_table`.
 */
class m160811_000001_menu extends Migration {

	/**
	 * @inheritdoc
	 */
	public function safeUp() {
		$timestamp = mktime(0, 0, 0, 8, 11, 2016);

		echo "Get user Admin ... ";
		$admin = $this->db->createCommand('SELECT id FROM user WHERE username = "admin"')->queryOne();
		echo "Done.\n";

		$this->batchInsert('auth_item', ['name', 'type', 'created_at', 'updated_at'], [
			['/pos', 2, $timestamp, $timestamp],
			['/pos/key-reserve', 2, $timestamp, $timestamp],
			['/pos/enter-key-reserve', 2, $timestamp, $timestamp],
			['/pos/register', 2, $timestamp, $timestamp],
			['Pos', 2, $timestamp, $timestamp],
			['Keys', 2, $timestamp, $timestamp],
			['РольPos', 1, $timestamp, $timestamp],
			['РольKeys', 1, $timestamp, $timestamp],
		]);

		$this->batchInsert('auth_item_child', ['parent', 'child'], [
			['Pos', '/pos'],
			['Pos', '/pos/key-reserve'],
			['Pos', '/pos/register'],
			['Keys', '/pos/enter-key-reserve'],
			['РольPos', 'Pos'],
			['РольKeys', 'Keys'],
			['РольAdmin', 'РольPos'],
			['РольAdmin', 'РольKeys'],
		]);

		/*
		  $this->batchInsert('auth_assignment', ['item_name', 'user_id', 'created_at'], [
		  ['РольОтчеты', $admin['id'], $timestamp],
		  ]);
		 */

		$this->update('menu', ['order' => 20], ['parent' => 1, 'name' => 'Банкоматы']);
		$this->insert('menu', ['name' => 'pos']);
		$pos = $this->db->createCommand('SELECT id FROM menu WHERE name = "pos" AND parent IS NULL AND route IS NULL')->queryOne();

		$this->batchInsert('menu', ['parent', 'name', 'route', 'order'], [
			[1, 'Терминалы', '/pos', 10],
			[$pos['id'], 'Регистрационные данные', '/pos/register', 1],
			[$pos['id'], 'Зарезервировать ключ', '/pos/key-reserve', 20],
			[$pos['id'], 'Ввести новый диапазон ключей', '/pos/enter-key-reserve', 100],
		]);
	}

	/**
	 * @inheritdoc
	 */
	public function safeDown() {
		$this->delete('menu', ['parent' => 1, 'name' => 'Терминалы']);
		if (($reports = $this->db->createCommand('SELECT id FROM menu WHERE name = "pos" AND parent IS NULL AND route IS NULL')->queryOne()) !== false) {
			$this->delete('menu', ['parent' => $reports['id']]);
			$this->delete('menu', ['id' => $reports['id']]);
		}
		$this->delete('auth_assignment', ['item_name' => 'РольPos']);
		$this->delete('auth_assignment', ['item_name' => 'РольKeys']);

		$this->delete('auth_item_child', ['like', 'child', 'РольPos']);
		$this->delete('auth_item_child', ['like', 'parent', 'РольPos']);
		$this->delete('auth_item_child', ['like', 'parent', 'Pos']);
		$this->delete('auth_item_child', ['like', 'child', 'РольKeys']);
		$this->delete('auth_item_child', ['like', 'parent', 'РольKeys']);
		$this->delete('auth_item_child', ['like', 'parent', 'Keys']);

		$this->delete('auth_item', ['like', 'name', 'РольPos']);
		$this->delete('auth_item', ['like', 'name', 'Pos']);
		$this->delete('auth_item', ['like', 'name', 'РольKeys']);
		$this->delete('auth_item', ['like', 'name', 'Keys']);
		$this->delete('auth_item', ['like', 'name', '/pos']);

		#return false;
	}

}
