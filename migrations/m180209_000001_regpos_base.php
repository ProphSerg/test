<?php

use yii\db\Migration;

/**
 * Handles the creation for table `key_table`.
 */
class m180209_000001_regpos_base extends Migration {

    public function init() {
        $this->db = 'dbPos';
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function safeUp() {

        $this->renameTable('RegPos', 'RegPos_old');

        $this->createTable('RegPos', [
            'ID' => $this->primaryKey(),
            'ClientN' => $this->text()->notNull(),
            'Name' => $this->text()->notNull(),
            'ContractN' => $this->text()->notNull(),
            'TerminalID' => $this->text()->notNull(),
            'City' => $this->text(),
            'Address' => $this->text()->notNull(),
            'MerchantID' => $this->text()->notNull(),
            'KeyNum' => $this->text()->notNull(),
            'KEY_CHECK' => $this->text()->notNull(),
            'TPK_KEY' => $this->text(),
            'TPK_CHECK' => $this->text(),
            'TAK_KEY' => $this->text(),
            'TAK_CHECK' => $this->text(),
            'TDK_KEY' => $this->text(),
            'TDK_CHECK' => $this->text(),
            'DateReg' => $this->dateTime()
        ]);
        $this->batchInsert('RegPos', 
                ['ClientN', 'Name', 'ContractN', 'TerminalID', 'City', 'Address', 'MerchantID', 'KeyNum', 'KEY_CHECK', 'TPK_KEY', 'TPK_CHECK', 'TAK_KEY', 'TAK_CHECK', 'TDK_KEY', 'TDK_CHECK', 'DateReg'], 
                $this->db->createCommand(
                        'SELECT ClientN, Name, ContractN, TerminalID, City, Address, MerchantID, KeyNum, TMK_CHECK as KEY_CHECK, TPK_KEY, TPK_CHECK, TAK_KEY, TAK_CHECK, TDK_KEY, TDK_CHECK, DateReg FROM RegPos_old'
                )->queryAll());

        $this->dropTable('RegPos_old');

        $this->createIndex('IDX_REG_TERMINALID', 'RegPos', 'TerminalID', false);
        $this->createIndex('IDX_REG_KEYNUM', 'RegPos', ['TerminalID', 'KeyNum'], true);
        $this->createIndex('IDX_REG_TMK', 'RegPos', 'KEY_CHECK', false);
        $this->createIndex('IDX_REG_ADDRESS', 'RegPos', 'Address', false);
        $this->createIndex('IDX_REG_NAME', 'RegPos', 'Name', false);
        $this->createIndex('IDX_REG_MERCH', 'RegPos', 'MerchantID', false);
        ##$this->createIndex('IDX_REG_DATEREG', 'RegPos', ['TerminalID', 'DateReg'], true);
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        #$this->dropTable('RegPos');
        #return false;
    }

}
