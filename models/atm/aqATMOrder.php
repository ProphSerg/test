<?php

namespace app\models\atm;

/**
 * This is the ActiveQuery class for [[ATMOrder]].
 *
 * @see ATMOrder
 */
class aqATMOrder extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ATMOrder[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ATMOrder|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
