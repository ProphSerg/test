<?php

use yii\db\Migration;

/**
 * Handles the creation for table `key_table`.
 */
class m160725_000004_api_base extends Migration {

	public function init() {
		$this->db = 'dbApi';
		parent::init();
	}

	/**
	 * @inheritdoc
	 */
	public function safeUp() {
		/*
		  CREATE TABLE 'MailPatt' (
		 * 'ID' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
		 * 'Priority' INTEGER NOT NULL DEFAULT 9999, 
		 * 'Pattern' TEXT NOT NULL, 
		 * 'BodyPattern' TEXT NOT NULL, 
		 * 'Model' TEXT NOT NULL )
		 * 
		 */
		$this->createTable('MailPatt', [
			'ID' => $this->primaryKey(),
			'Priority' => $this->integer()->notNull()->defaultValue(9999),
			'Pattern' => $this->text()->notNull(),
			'BodyPattern' => $this->text()->notNull(),
			'Model' => $this->text()->notNull(),
		]);
		$this->createIndex('IDX_MAIL_PRIORITY', 'MailPatt', 'Priority', false);
		$this->batchInsert('MailPatt', ['Priority', 'Pattern', 'BodyPattern', 'Model'], [
			[1, 'Subject|/Вопрос по вашей заявке номер/ui|', 'Request', 'Request'],
			[3, 'Subject|/w\d+[\s-]+110728[\s-]+ru/iu|', 'NCRorder', 'ATMOrder'],
			[5, 'Subject|/просроченн.. заявк./ui|', 'RequestOver', 'RequestOver'],
			[7, 'Subject|/1recal.+?\d+/ui|', 'RequestRecall', 'RequestRecall'],
			[10, 'Subject|/Ваша Заявка принята с номером/ui|', 'IGNORE', 'IGNORE'],
			[9999, 'Subject|/.*/ui|', 'IGNORE', 'IGNORE'],
		]);

		/*
		  CREATE TABLE 'BodyPatt' (
		 * 'ID' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
		 * 'Name' TEXT NOT NULL, 
		 * 'Priority' INTEGER NOT NULL DEFAULT 9999, 
		 * 'Pattern' TEXT NOT NULL )
		 */
		$this->createTable('BodyPatt', [
			'ID' => $this->primaryKey(),
			'Name' => $this->text()->notNull(),
			'Priority' => $this->integer()->notNull()->defaultValue(9999),
			'Pattern' => $this->text()->notNull(),
		]);
		$this->createIndex('IDX_BODY_NAME', 'BodyPatt', ['Name', 'Priority'], false);
		$patt = <<< EPAT
/.*?их вопрос[:\s]+

\s*(?'Text'.+?)

.*?Вопрос относится к вашей заявке.*?
Номер заявки[:\s]+(?'Number'\d+).*?созданной[:\s]+(?'Date'[\d\/]+ [\d\:]+)
Описание[:\s]+(?'Desc'[^\n]*)
Доп.*?инф.*?[:\s]+(?'Append'[^\n]*)
Конт.*?тел.*?[:\s]+(?'Contact'[^\n]*)
Название ТСП[:\s]+(?'Name'[^\n]*)/uis'
EPAT;
		$this->batchInsert('BodyPatt', ['Name', 'Priority', 'Pattern'], [
			['Request', 1, $patt],
			['Request', 2, "/Город[:\\s]+(?'Addr'[^\\n]*)/uis"],
			['NCRorder', 1, "/.+?O R D E R[\\s-]+(?'Number'w\\d+).+?Entered[:\\s]+(?'EnterDate'\\d{2}\\/\\d{2}\\/\\d{4} \\d{2}:\\d{2}).+?By[:\\s]+(?'EnterBy'\\w+).+?Serial No[:\\s]+(?'Serial'[\\d\\-]+).+?Status[:\\s]+(?'Status'\\w{2}).+?Technician name:\\s*((?'TNameCode'\\w+)\\s+(?'TName'[^\\n]*)){0,1}.+?Remarks:[\\n]*(?'RepitNCRRemarks'.+Repair Description)[\\s]*/ius"],
			['NCRRemarks', 1, "/(?'Date'(?>\\d{2}\\/\\d{2}\\/\\d{2,4} \\d{2}:\\d{2}))[\\s]+(?'Autor'[\\w]+)[\\s:]+(?'Text'.+?)(?=\\d{2}\\/\\d{2}\\/\\d{2,4} \\d{2})/usi"],
			['NCRRemarks.replace', 1, "Repair Description|99/99/99 99:99"],
			['RequestOver', 1, "/промежуточный ответ.+?\\n*(?'RepitReqOverNum'.+?)\\n*Из Регламента/uis"],
			['ReqOverNum', 1, "/(?'ReqOverNum'\\d{4,}+)/iu"],
			['RequestRecall', 1, "/(?'Text'.+)/ius"],
		]);
	}

	/**
	 * @inheritdoc
	 */
	public function safeDown() {
		$this->dropTable('MailPatt');
		$this->dropTable('BodyPatt');
		#return false;
	}

}
