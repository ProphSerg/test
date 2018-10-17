<?php

use yii\db\Migration;

/**
 * Handles the creation for table `key_table`.
 */
class m180525_000001_api_base extends Migration {

    public function init() {
        $this->db = 'dbApi';
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function safeUp() {

        $this->addColumn("BodyPatt", "Replace", $this->text());

        foreach ($this->db->createCommand('SELECT * FROM BodyPatt WHERE Name LIKE "%.replace"')->query() as $bp) {
            if (preg_match('/^(.+?)\|(.+)$/i', $bp["Pattern"], $rmach) > 0) {
                $this->update("BodyPatt", [
                    "Pattern" => "/$rmach[1]/",
                    "Replace" => $rmach[2],
                        ], [
                    "ID" => $bp["ID"]
                        ]
                );
            }
        }
        $this->insert("BodyPatt", [
            "Name" => "RegPosAll.replace",
            "Priority" => 1,
            "Pattern" => '/([^\n])(Client #|Contract #|KLK_CHECK|MailOrder\/TelephoneOrder\(Moto\)|MerchantID|TAK_CHECK|TAK_KEY|TDK_CHECK|TDK_KEY|TMK_CHECK|TPK_CHECK|TPK_KEY|Terminal_ID|Адрес установки|Бесконтактные карты|Версия ПО пин-пада|Версия ПО терминала|Город|Модель пин-пада|Модель терминала|Название ТСП|ПС Amex|Серийный номер ключа|Схема подключения|Схема подключения резерв|Тип терминала|Требуется SSL сертификат)/u',
            "Replace" => '$1\n$2',
                ]
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        #$this->dropTable('RegPos');
        #return false;
    }

}
