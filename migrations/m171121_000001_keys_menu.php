<?php

use yii\db\Migration;
use yii\rbac;

/**
 * Handles the creation for table `key_table`.
 */
class m171121_000001_keys_menu extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {

        $pos = $this->db->createCommand('SELECT id FROM menu WHERE name = "pos" AND parent IS NULL AND route IS NULL')->queryOne();

        $this->batchInsert('menu', ['parent', 'name', 'route', 'order'], [
            [$pos['id'], 'Работа с ключами', '/pos/keys', 100],
        ]);

        /*
         * добавляем права доступа
         */
        $route = new rbac\Item();
        $route->type = rbac\Item::TYPE_PERMISSION;
        $route->name = '/pos/keys';

        $auth = new rbac\DbManager();
        $perm = $auth->getPermission('Pos');

        $auth->add($route);
        $auth->addChild($perm, $route);
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        $auth = new rbac\DbManager();
        $pos = $auth->getPermission('Pos');
        $hkcv = $auth->getPermission('/pos/keys');

        $auth->removeChild($pos, $hkcv);
        $auth->remove($hkcv);

        $pos = $this->db->createCommand('SELECT id FROM menu WHERE name = "pos" AND parent IS NULL AND route IS NULL')->queryOne();
        $this->delete('menu', [
            'route' => '/pos/keys',
            'parent' => $pos['id']
        ]);
        #return false;
    }

}
