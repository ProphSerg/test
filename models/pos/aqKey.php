<?php

namespace app\models\pos;

/**
 * This is the ActiveQuery class for [[arKey]].
 *
 * @see arKey
 */
class aqKey extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return arKey[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return arKey|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
