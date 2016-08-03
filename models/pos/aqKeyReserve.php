<?php

namespace app\models\pos;

/**
 * This is the ActiveQuery class for [[KeyReserve]].
 *
 * @see KeyReserve
 */
class aqKeyReserveQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return KeyReserve[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return KeyReserve|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
