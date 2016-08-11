<?php

use yii\db\Migration;

/**
 * Handles the creation for table `key_table`.
 */
class m160810_000002_api_posreg extends Migration {

	public function init() {
		$this->db = 'dbApi';
		parent::init();
	}

	/**
	 * @inheritdoc
	 */
	public function safeUp() {
		$this->batchInsert('MailPatt', ['Priority', 'Pattern', 'BodyPattern', 'Model'], [
			[20, 'Subject|/Регистрационные данные на терминал/ui|Subject|/Запрос на сертификат/ui|', 'RegPosAll', 'RegPos'],
		]);
/*
 Client #:   002600001C
Название ТСП:  ЦО ФИЛИАЛА ОАО УРАЛСИБ В Г.ОМСК, OO OMSKIY FIDK 1
Contract #:   0026-000749C
Terminal_ID:   00261011
Город:    OMSK
Адрес установки:  УЛ. БОГДАНА ХМЕЛЬНИЦКОГО, Д. 283
MerchantID:   000010338182385
Серийный номер ключа: O03S2_150602_0091
TMK_CHECK:   CAEF23
TPK_KEY:   0EF86A60C2F79C548353C12BDBFFDD50
TPK_CHECK:   CACD3F
TAK_KEY:   4EC478FA7531570F229BF76A92CDA7F3
TAK_CHECK:   E00E3F
TDK_KEY:   1EB0CB29257CA14ED0553CCDD3C2B67B
TDK_CHECK:   B6086F

			'ClientN' => $this->text()->notNull(),
			'Name' => $this->text()->notNull(),
			'ContractN' => $this->text()->notNull(),
			'TerminalID' => $this->text()->notNull(),
			'City' => $this->text()->notNull(),
			'Address' => $this->text()->notNull(),
			'MerchantID' => $this->text()->notNull(),
			'KeyNum' => $this->text()->notNull(),
			'TMK_CHECK' => $this->text()->notNull(),
			'TPK_KEY' => $this->text()->notNull(),
			'TPK_CHECK' => $this->text(),
			'TAK_KEY' => $this->text()->notNull(),
			'TAK_CHECK' => $this->text(),
			'TDK_KEY' => $this->text()->notNull(),
			'TDK_CHECK' => $this->text(),

  */
		$this->batchInsert('BodyPatt', ['Name', 'Priority', 'Pattern'], [
			['RegPosAll', 1, "/(?'RepitRegPos'.+)/usi"],
			['RegPos', 1, "/\-+\\n(?'BlockRegPosData'.+?TMK_CHECK.+?)\-+/usi"],
			['RegPosData', 1, "/Client #[:\\s]+(?'ClientN'.+)/iu"],
			['RegPosData', 1, "/Название ТСП[:\\s]+(?'Name'.+)/iu"],
			['RegPosData', 1, "/Contract #[:\\s]+(?'ContractN'.+)/iu"],
			['RegPosData', 1, "/Terminal.ID[:\\s]+(?'TerminalID'.+)/iu"],
			['RegPosData', 1, "/Город[:\\s]+(?'City'.+)/iu"],
			['RegPosData', 1, "/Адрес установки[:\\s]+(?'Address'.+)/iu"],
			['RegPosData', 1, "/MerchantID[:\\s]+(?'MerchantID'.+)/iu"],
			['RegPosData', 1, "/Серийный номер ключа[:\\s]+(?'KeyNum'.+)/iu"],
			['RegPosData', 1, "/TMK_CHECK[:\\s]+(?'TMK_CHECK'.+)/iu"],
			['RegPosData', 1, "/TPK_KEY[:\\s]+(?'TPK_KEY'.+)/iu"],
			['RegPosData', 1, "/TPK_CHECK[:\\s]+(?'TPK_CHECK'.+)/iu"],
			['RegPosData', 1, "/TAK_KEY[:\\s]+(?'TAK_KEY'.+)/iu"],
			['RegPosData', 1, "/TAK_CHECK[:\\s]+(?'TAK_CHECK'.+)/iu"],
			['RegPosData', 1, "/TDK_KEY[:\\s]+(?'TDK_KEY'.+)/iu"],
			['RegPosData', 1, "/TDK_CHECK[:\\s]+(?'TDK_CHECK'.+)/iu"],
		]);
	}

	/**
	 * @inheritdoc
	 */
	public function safeDown() {
		$this->delete('MailPatt', ['Model' => 'RegPos']);
		$this->delete('BodyPatt', ['like', 'Name', 'RegPos']);
		#return false;
	}

}
