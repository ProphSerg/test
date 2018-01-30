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

        $posS = $this->db->createCommand('SELECT id FROM menu WHERE name = "pos" AND parent IS NULL AND route IS NULL')->queryOne();
        /*         * ************************************* */
        /* Удаляем старые записи */
        $auth = new rbac\DbManager();
        $pos = $auth->getPermission('Pos');

        if (($hkcv = $auth->getPermission('/pos/key-reserve')) != false) {
            $auth->removeChild($pos, $hkcv);
            $auth->remove($hkcv);
        }

        if (($hkcv = $auth->getPermission('/pos/enter-key-reserve')) != false) {
            $auth->removeChild($pos, $hkcv);
            $auth->remove($hkcv);
        }

        if (($posS) != false) {
            $this->delete('menu', [
                'route' => '/pos/key-reserve',
                'parent' => $posS['id']
            ]);
            $this->delete('menu', [
                'route' => '/pos/enter-key-reserve',
                'parent' => $posS['id']
            ]);
        }
        /*         * ********************************* */

        if (($posS) != false) {
            $this->batchInsert('menu', ['parent', 'name', 'route', 'order'], [
                [$posS['id'], 'Работа с ключами', '/pos/keys', 100],
                [$posS['id'], 'Зарезервировать транспортный ключ', '/pos/key-reserve/O03D2', 20],
                [$posS['id'], 'Зарезервировать рабочий ключ', '/pos/key-reserve/O03S2', 21],
            ]);
        }
        /*
         * добавляем права доступа
         */
        $route = new rbac\Item();
        $route->type = rbac\Item::TYPE_PERMISSION;

        $auth = new rbac\DbManager();
        $perm = $auth->getPermission('Pos');

        $route->name = '/pos/keys';
        $auth->add($route);
        $auth->addChild($perm, $route);

        $route->name = '/pos/key-reserve/O03D2';
        $auth->add($route);
        $auth->addChild($perm, $route);

        $route->name = '/pos/key-reserve/O03S2';
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

        if (($pos = $this->db->createCommand('SELECT id FROM menu WHERE name = "pos" AND parent IS NULL AND route IS NULL')->queryOne()) != false) {
            $this->delete('menu', [
                'route' => '/pos/keys',
                'parent' => $pos['id']
            ]);
        }
        #return false;
    }

}
