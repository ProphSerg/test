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
		$Tables = [
			/* CREATE TABLE 'Request' (
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
			'Request' => [
				'migrate' => false,
				'columns' => [
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
				],
				'indexs' => [
					'IDX_DATEOPEN_REQUEST' => [
						'columns' => ['Date'],
						'unique' => false
					],
					'IDX_DATECLOSE_REQUEST' => [
						'columns' => ['DateClose'],
						'unique' => false
					],
					'IDX_TYPE_NUMDER' => [
						'columns' => ['Type', 'Number'],
						'unique' => true
					],
				],
			],
			/*
			  CREATE TABLE 'ReqText' (
			  'ID' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
			  'RequestID' INTEGER NOT NULL,
			  'Date' DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  'Text' TEXT NOT NULL
			  );

			  CREATE INDEX 'IDX_RID_DATE' ON "ReqText" ("RequestID" ASC, "Date" ASC);

			 */
			'ReqText' => [
				'migrate' => false,
				'columns' => [
					'ID' => $this->primaryKey(),
					'RequestID' => $this->integer()->notNull(),
					'Date' => $this->dateTime()->notNull(),
					'Text' => $this->text()->notNull(),
					'FOREIGN KEY(RequestID) REFERENCES Request(ID) ON UPDATE CASCADE ON DELETE CASCADE',
				],
				'indexs' => [
					'IDX_RID_DATE' => [
						'columns' => ['RequestID', 'Date'],
						'unique' => false
					],
				],
			],
		];
		$Views = [];

		foreach ($this->db->schema->tableNames as $bTbl) {
			foreach (array_keys($Tables) as $mTbl) {
				if (strcasecmp($bTbl, $mTbl) == 0) {
					$Tables[$mTbl]['migrate'] = true;
				}
			}
		}

		foreach ($Tables as $mTbl => $mVal) {
			if ($mVal['migrate'] == true) {
				$this->renameTable($mTbl, $mTbl . '_old');
			}
			$this->createTable($mTbl, $mVal['columns']);
		}

		if ($Tables['Request']['migrate'] == true) {
			echo "Migrate Request data .... ";
			$col = [];
			foreach ($this->db->createCommand('SELECT * FROM Request_old')->query() as $req) {
				$reqID = $req['ID'];
				unset($req['ID']);
				if (($Preq = $this->db->schema->insert('Request', $req)) == false) {
					return false;
				}
				if ($Tables['ReqText']['migrate'] == true) {
					$col = [];
					foreach (array_keys($Tables['ReqText']['columns']) as $c) {
						if (!is_int($c) && strcasecmp($c, 'ID') != 0) {
							$col[0][] = $c;
							if (strcasecmp($c, 'RequestID') == 0) {
								$col[1][] = $Preq['ID'] . ' as ' . $c;
							} else {
								$col[1][] = $c;
							}
						}
					}
					$this->db->createCommand()->batchInsert('ReqText', $col[0], $this->db->createCommand('SELECT ' . implode(', ', $col[1]) . ' FROM ReqText_old WHERE RequestID = ' . $reqID)
							->queryAll())
						->execute();
				}
			}
			echo "done.\n";
		}

		foreach ($Tables as $mTbl => $mVal) {
			if ($mVal['migrate'] == true) {
				$this->dropTable($mTbl . '_old');
			}
			foreach ($mVal['indexs'] as $Idx => $idxVal) {
				$this->createIndex($Idx, $mTbl, $idxVal['columns'], $idxVal['unique']);
			}
		}

		foreach ($Views as $name => $sel) {
			$this->execute("DROP VIEW IF EXISTS {$name}");
			$this->execute("CREATE VIEW {$name} AS {$sel}");
		}
		#$this->execute("VACUUM");
		#return false;
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
