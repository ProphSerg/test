<?php

use Yii;
use yii\db\Migration;
use yii\rbac;
/**
 * Handles the creation for table `key_table`.
 */
class m170417_000001_pos_kcv extends Migration {

    public function init() {
        $this->db = 'dbPos';
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $this->createTable('HypercomKCV', [
            'ID' => $this->primaryKey(),
            'Serial' => $this->text()->notNull(),
            'DateEnter' => $this->dateTime()->notNull(),
            'KeyNum' => $this->integer()->notNull(),
            'KCV' => $this->text()->notNull(),
        ]);
        $this->createIndex('IDX_KCV_MAIN', 'HypercomKCV', ['Serial', 'DateEnter', 'KeyNum', 'KCV'], true);
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        $this->dropTable('HypercomKCV');
        #return false;
    }

}
