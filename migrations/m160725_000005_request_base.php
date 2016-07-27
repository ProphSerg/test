<?php

use yii\db\Migration;

/**
 * Handles the creation for table `key_table`.
 */
class m160725_000005_request_base extends Migration {

	public function init() {
		$this->db = 'dbRequest';
		parent::init();
	}

	/**
	 * @inheritdoc
	 */
	public function safeUp() {
		/*
		  CREATE TABLE 'Request' (
		  'ID' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
		  'Type' INTEGER NOT NULL,
		  'Number' INTEGER NOT NULL,
		  'Date' DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  'DateClose' DATETIME,
		  'Desc' TEXT,
		  'Append' TEXT,
		  'Contact' TEXT,
		  'Name' TEXT,
		  'Addr' TEXT,
		  'Overdue' BOOLEAN NOT NULL DEFAULT 0);

		  CREATE INDEX 'IDX_DATEOPEN_REQUEST' ON "Request" ("Date" ASC);
		  CREATE INDEX 'IDX_DATECLOSE_REQUEST' ON "Request" ("DateClose" ASC);
		  CREATE UNIQUE INDEX 'IDX_TYPE_NUMDER' ON "Request" ("Type" ASC, "Number" ASC);

		 */
		$this->createTable('Request', [
			'ID' => $this->primaryKey(),
			'Type' => $this->integer()->notNull(),
			'Number' => $this->integer()->notNull(),
			'Date' => $this->dateTime()->notNull(),
			'DateClose' => $this->dateTime(),
			'Desc' => $this->text(),
			'Append' => $this->text(),
			'Contact' => $this->text(),
			'Name' => $this->text(),
			'Addr' => $this->text(),
			'Overdue' => $this->boolean()->notNull()->defaultValue(0),
		]);
		$this->createIndex('IDX_DATEOPEN_REQUEST', 'Request', ['Date'], false);
		$this->createIndex('IDX_DATECLOSE_REQUEST', 'Request', ['DateClose'], false);
		$this->createIndex('IDX_TYPE_NUMDER', 'Request', ['Type', 'Number'], true);

		/*
		  CREATE TABLE 'ReqText' (
		  'ID' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
		  'RequestID' INTEGER NOT NULL,
		  'Date' DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  'Text' TEXT NOT NULL
		  );

		  CREATE INDEX 'IDX_RID_DATE' ON "ReqText" ("RequestID" ASC, "Date" ASC);

		 */
		$this->createTable('ReqText', [
			'ID' => $this->primaryKey(),
			'RequestID' => $this->integer()->notNull(),
			'Date' => $this->dateTime()->notNull(),
			'Text' => $this->text()->notNull(),
			'FOREIGN KEY(RequestID) REFERENCES Request(ID) ON UPDATE CASCADE ON DELETE CASCADE',
		]);
		$this->createIndex('IDX_RID_DATE', 'ReqText', ['RequestID', 'Date'], false);
	}

	/**
	 * @inheritdoc
	 */
	public function safeDown() {
		$this->dropTable('ReqText');
		$this->dropTable('Request');
		#return false;
	}

}
