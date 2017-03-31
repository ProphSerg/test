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
		$Tables = [
			/* CREATE TABLE 'ATMOrder' (
			 * 'ID' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
			 * 'Number' TEXT NOT NULL, 
			 * 'EnterDate' DATETIME NOT NULL, 
			 * 'EnterBy' TEXT NOT NULL, 
			 * 'Serial' TEXT NOT NULL)		 
			 */
			'xAttrSpr' => [
				'migrate' => false,
				'columns' => [
					'ID' => $this->primaryKey(),
					'Label' => $this->text()->notNull(),
					'Table' => $this->text()->notNull(),
					'Type' => $this->text()->notNull(),
					'Value' => $this->text(),
				],
				'indexs' => [
					'IDX_NUMBER_ATMORDER' => [
						'columns' => '[[Number]]',
						'unique' => true
					],
				],
			],
			/* CREATE TABLE 'sprATMOrderStatus' (
			 * 'ID' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
			 * 'StatusID' TEXT NOT NULL, 
			 * 'StatusName' TEXT NOT NULL)
			 */
			'ATMOrderRemark' => [
				'migrate' => false,
				'columns' => [
					'ID' => $this->primaryKey(),
					'ATMOrderID' => $this->integer()->notNull(),
					'Date' => $this->dateTime()->notNull(),
					'Autor' => $this->text()->notNull(),
					'Text' => $this->text()->notNull(),
					'FOREIGN KEY(ATMOrderID) REFERENCES ATMOrder(ID) ON UPDATE CASCADE ON DELETE CASCADE',
				],
				'indexs' => [
					'IDX_DATE_ATMREMARK' => [
						'columns' => ['[[ATMOrderID]]', '[[Date]]'],
						'unique' => true
					],
				],
			],
			/* CREATE TABLE 'sprATMOrderStatus' (
			 * 'ID' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
			 * 'StatusID' TEXT NOT NULL, 
			 * 'StatusName' TEXT NOT NULL)
			 */
			'ATMOrderStatus' => [
				'migrate' => false,
				'columns' => [
					'ID' => $this->primaryKey(),
					'ATMOrderID' => $this->integer()->notNull(),
					'Date' => $this->dateTime()->notNull(),
					'Status' => $this->text()->notNull(),
					'FOREIGN KEY(ATMOrderID) REFERENCES ATMOrder(ID) ON UPDATE CASCADE ON DELETE CASCADE',
				],
				'indexs' => [
					'IDX_DATE_ATMSTATUS' => [
						'columns' => ['[[ATMOrderID]]', '[[Date]] DESC'],
						'unique' => true
					],
				],
			],
			/* CREATE TABLE 'ATMOrderTech' (
			 * 'ID' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
			 * 'ATMOrderID' INTEGER NOT NULL, 
			 * 'Date' DATETIME NOT NULL, 
			 * 'Code' TEXT NOT NULL)
			 */
			'ATMOrderTech' => [
				'migrate' => false,
				'columns' => [
					'ID' => $this->primaryKey(),
					'ATMOrderID' => $this->integer()->notNull(),
					'Date' => $this->dateTime()->notNull(),
					'Code' => $this->text()->notNull(),
					'FOREIGN KEY(ATMOrderID) REFERENCES ATMOrder(ID) ON UPDATE CASCADE ON DELETE CASCADE',
				],
				'indexs' => [
					'IDX_DATE_ATMTECH' => [
						'columns' => ['[[ATMOrderID]]', '[[Date]] DESC'],
						'unique' => true
					],
				],
			],
			/* Справочники */
			/* CREATE TABLE 'sprATM' (
			 * 'ID' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
			 * 'Model' TEXT NOT NULL, 
			 * 'Serial' TEXT NOT NULL, 
			 * 'TerminalID' TEXT, 
			 * 'Addres' TEXT NOT NULL, 
			 * 'Type' TEXT NOT NULL DEFAULT 'Банкомат', 
			 * 'InvNum' TEXT)
			 */
			'sprATM' => [
				'migrate' => false,
				'columns' => [
					'ID' => $this->primaryKey(),
					'Model' => $this->text()->notNull(),
					'Serial' => $this->text()->notNull(),
					'TerminalID' => $this->text(),
					'Addres' => $this->text()->notNull(),
					'Type' => $this->text()->notNull()->defaultValue('Банкомат'),
					'InvNum' => $this->text(),
				],
				'indexs' => [
					'IDX_ATM_TERMINALID' => [
						'columns' => '[[TerminalID]]',
						'unique' => false,
					],
					'IDX_SERIAL_ATM' => [
						'columns' => '[[Serial]]',
						'unique' => true,
					],
				],
			],
			/* CREATE TABLE 'sprATMOrderStatus' (
			 * 'ID' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
			 * 'StatusID' TEXT NOT NULL, 
			 * 'StatusName' TEXT NOT NULL)
			 */
			'sprATMOrderStatus' => [
				'migrate' => false,
				'columns' => [
					'ID' => $this->primaryKey(),
					'StatusID' => $this->text()->notNull(),
					'StatusName' => $this->text()->notNull(),
				],
				'indexs' => [
					'IDX_STATUS_ORDERSTATUS' => [
						'columns' => '[[StatusID]]',
						'unique' => true
					],
				],
			],
			/* CREATE TABLE 'sprATMOrderTech' (
			 * 'ID' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
			 * 'Code' TEXT NOT NULL, 
			 * 'Name' TEXT NOT NULL, 
			 * 'NameRus' TEXT, 
			 * 'Phone' TEXT)
			 */
			'sprATMOrderTech' => [
				'migrate' => false,
				'columns' => [
					'ID' => $this->primaryKey(),
					'Code' => $this->text()->notNull(),
					'Name' => $this->text()->notNull(),
					'NameRus' => $this->text(),
					'Phone' => $this->text(),
				],
				'indexs' => [
					'IDX_CODE_TECH' => [
						'columns' => '[[Code]]',
						'unique' => true
					],
				],
			],
		];

		$Views = [
			'vATMOrderStatus' => "SELECT m.* FROM 'ATMOrderStatus' m INNER JOIN (SELECT ATMOrderID, max(Date) Date FROM 'ATMOrderStatus' GROUP BY ATMOrderID) s ON m.ATMOrderID = s.ATMOrderID AND m.Date = s.Date",
			'vATMOrderTech' => "SELECT m.* FROM 'ATMOrderTech' m INNER JOIN (SELECT ATMOrderID, max(Date) Date FROM 'ATMOrderTech' GROUP BY ATMOrderID) s ON m.ATMOrderID = s.ATMOrderID AND m.Date = s.Date",
		];

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

		if ($Tables['ATMOrder']['migrate'] == true) {
			echo "Migrate ATMOrder data .... ";
			$col = [];
			foreach ($this->db->createCommand('SELECT * FROM ATMOrder_old')->query() as $atmo) {
				$atmoID = $atmo['ID'];
				unset($atmo['ID']);
				if (($Patmo = $this->db->schema->insert('ATMOrder', $atmo)) == false) {
					return false;
				}
				foreach (['ATMOrderStatus', 'ATMOrderRemark', 'ATMOrderTech'] as $cTbl) {
					if ($Tables[$cTbl]['migrate'] == true) {
						$col = [];
						foreach (array_keys($Tables[$cTbl]['columns']) as $c) {
							if (!is_int($c) && strcasecmp($c, 'ID') != 0) {
								$col[0][] = $c;
								if (strcasecmp($c, 'ATMOrderID') == 0) {
									$col[1][] = $Patmo['ID'] . ' as ' . $c;
								} else {
									$col[1][] = $c;
								}
							}
						}
						$this->db->createCommand()->batchInsert($cTbl, $col[0], $this->db->createCommand('SELECT ' . implode(', ', $col[1]) . ' FROM ' . $cTbl . '_old WHERE ATMOrder_ID = ' . $atmoID)
								->queryAll())
							->execute();
					}
				}
			}
			echo "done.\n";
		}
		foreach (['sprATM', 'sprATMOrderStatus', 'sprATMOrderTech'] as $cTbl) {
			if ($Tables[$cTbl]['migrate'] == true) {
				echo "Migrate {$cTbl} data .... ";
				$col = [];
				foreach (array_keys($Tables[$cTbl]['columns']) as $c) {
					if (!is_int($c) && strcasecmp($c, 'ID') != 0) {
						$col[] = $c;
					}
				}
				$this->db->createCommand()->batchInsert($cTbl, $col, $this->db->createCommand('SELECT ' . implode(', ', $col) . ' FROM ' . $cTbl . '_old')
						->queryAll())
					->execute();
				echo "done.\n";
			}
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
