<?php

use yii\db\Migration;

/**
 * Handles the creation for table `key_table`.
 */
class m160725_000003_atm_base extends Migration {

	public function init() {
		$this->db = 'dbATM';
		parent::init();
	}

	/**
	 * @inheritdoc
	 */
	public function safeUp() {
		/*
		  CREATE TABLE 'ATMOrder'
		 * ('ID' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
		 * 'Number' TEXT NOT NULL, 
		 * 'EnterDate' DATETIME NOT NULL, 
		 * 'EnterBy' TEXT NOT NULL, 
		 * 'Serial' TEXT NOT NULL)		 
		 */
		$this->createTable('ATMOrder', [
			'ID' => $this->primaryKey(),
			'Number' => $this->text()->notNull(),
			'EnterDate' => $this->dateTime()->notNull(),
			'EnterBy' => $this->text()->notNull(),
			'Serial' => $this->text()->notNull(),
		]);
		$this->createIndex('IDX_NUMBER_ATMORDER', 'ATMOrder', '[[Number]]', true);

		/*
		  CREATE TABLE 'ATMOrderRemark' (
		 * 'ID' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
		 * 'ATMOrder_ID' INTEGER NOT NULL, 
		 * 'Date' DATETIME NOT NULL,
		 * 'Autor' TEXT NOT NULL,
		 * 'Text' TEXT NOT NULL)
		 */
		$this->createTable('ATMOrderRemark', [
			'ID' => $this->primaryKey(),
			'ATMOrder_ID' => $this->integer()->notNull(),
			'Date' => $this->dateTime()->notNull(),
			'Autor' => $this->text()->notNull(),
			'Text' => $this->text()->notNull(),
			'FOREIGN KEY(ATMOrder_ID) REFERENCES ATMOrder(ID) ON UPDATE CASCADE ON DELETE CASCADE',
		]);
		$this->createIndex('IDX_DATE_ATMREMARK', 'ATMOrderRemark', ['[[ATMOrder_ID]]', '[[Date]]'], true);

		/*
		  CREATE TABLE 'ATMOrderStatus' (
		 * 'ID' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
		 * 'ATMOrder_ID' INTEGER NOT NULL, 
		 * 'Date' DATETIME NOT NULL, 
		 * 'Status' TEXT NOT NULL)
		 */
		$this->createTable('ATMOrderStatus', [
			'ID' => $this->primaryKey(),
			'ATMOrder_ID' => $this->integer()->notNull(),
			'Date' => $this->dateTime()->notNull(),
			'Status' => $this->text()->notNull(),
			'FOREIGN KEY(ATMOrder_ID) REFERENCES ATMOrder(ID) ON UPDATE CASCADE ON DELETE CASCADE',
		]);
		$this->createIndex('IDX_DATE_ATMSTATUS', 'ATMOrderStatus', ['[[ATMOrder_ID]]', '[[Date]] DESC'], true);

		/*
		  CREATE TABLE 'ATMOrderTech' (
		 * 'ID' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
		 * 'ATMOrder_ID' INTEGER NOT NULL, 
		 * 'Date' DATETIME NOT NULL, 
		 * 'Code' TEXT NOT NULL)
		 */
		$this->createTable('ATMOrderTech', [
			'ID' => $this->primaryKey(),
			'ATMOrder_ID' => $this->integer()->notNull(),
			'Date' => $this->dateTime()->notNull(),
			'Code' => $this->text()->notNull(),
			'FOREIGN KEY(ATMOrder_ID) REFERENCES ATMOrder(ID) ON UPDATE CASCADE ON DELETE CASCADE',
		]);
		$this->createIndex('IDX_DATE_ATMTECH', 'ATMOrderTech', ['[[ATMOrder_ID]]', '[[Date]] DESC'], true);

		$this->execute('DROP VIEW IF EXISTS vATMOrdeStatus;');
		$this->execute("CREATE VIEW 'vATMOredStatus' AS SELECT m.* FROM 'ATMOrderStatus' m INNER JOIN (SELECT ATMOrder_ID, max(Date) Date FROM 'ATMOrderStatus' GROUP BY ATMOrder_ID) s ON m.ATMOrder_ID = s.ATMOrder_ID AND m.Date = s.Date");
		$this->execute('DROP VIEW IF EXISTS vATMOrdeTech;');
		$this->execute("CREATE VIEW 'vATMOredTech' AS SELECT m.* FROM 'ATMOrderTech' m INNER JOIN (SELECT ATMOrder_ID, max(Date) Date FROM 'ATMOrderTech' GROUP BY ATMOrder_ID) s ON m.ATMOrder_ID = s.ATMOrder_ID AND m.Date = s.Date");


		/*
		 * Справочники
		 */

		/*
		  CREATE TABLE 'sprATM' (
		 * 'ID' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
		 * 'Model' TEXT NOT NULL, 
		 * 'Serial' TEXT NOT NULL, 
		 * 'TerminalID' TEXT, 
		 * 'Addres' TEXT NOT NULL, 
		 * 'Type' TEXT NOT NULL DEFAULT 'Банкомат', 
		 * 'InvNum' TEXT)
		 */
		$this->createTable('sprATM', [
			'ID' => $this->primaryKey(),
			'Model' => $this->text()->notNull(),
			'Serial' => $this->text()->notNull(),
			'TerminalID' => $this->text(),
			'Addres' => $this->text()->notNull(),
			'Type' => $this->text()->notNull()->defaultValue('Банкомат'),
			'InvNum' => $this->text(),
		]);
		$this->createIndex('IDX_ATM_TERMINALID', 'sprATM', '[[TerminalID]]', true);
		$this->createIndex('IDX_SERIAL_ATM', 'sprATM', '[[Serial]]', true);

		/*
		  CREATE TABLE 'sprATMOrderStatus' (
		 * 'ID' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
		 * 'StatusID' TEXT NOT NULL, 
		 * 'StatusName' TEXT NOT NULL)
		 */
		$this->createTable('sprATMOrderStatus', [
			'ID' => $this->primaryKey(),
			'StatusID' => $this->text()->notNull(),
			'StatusName' => $this->text()->notNull(),
		]);
		$this->createIndex('IDX_STATUS_ORDERSTATUS', 'sprATMOrderStatus', '[[StatusID]]', true);

		/*
		  CREATE TABLE 'sprATMOrderTech' (
		 * 'ID' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
		 * 'Code' TEXT NOT NULL, 
		 * 'Name' TEXT NOT NULL, 
		 * 'NameRus' TEXT, 
		 * 'Phone' TEXT)
		 */
		$this->createTable('sprATMOrderTech', [
			'ID' => $this->primaryKey(),
			'Code' => $this->text()->notNull(),
			'Name' => $this->text()->notNull(),
			'NameRus' => $this->text(),
			'Phone' => $this->text(),
		]);
		$this->createIndex('IDX_CODE_TECH', 'sprATMOrderTech', '[[Code]]', true);

		#$this->addForeignKey('statusid_order_fk', '{{ATMOrderStatus}}', '[[ATMOrder_ID]]', '{{ATMOrder}}', '[[ID]]', 'CASCADE', 'CASCADE');
		#$this->addForeignKey('techid_order_fk', '{{ATMOrderTech}}', '[[ATMOrder_ID]]', '{{ATMOrder}}', '[[ID]]', 'CASCADE', 'CASCADE');
	}

	/**
	 * @inheritdoc
	 */
	public function down() {
		$this->execute('DROP VIEW IF EXISTS vATMOrdeStatus;');
		$this->execute('DROP VIEW IF EXISTS vATMOrdeTech;');
		$this->dropTable('ATMOrderRemark');
		$this->dropTable('ATMOrderStatus');
		$this->dropTable('ATMOrderTech');
		$this->dropTable('ATMOrder');
		$this->dropTable('sprATM');
		$this->dropTable('sprATMOrderStatus');
		$this->dropTable('sprATMOrderTech');
		#return false;
	}

}
