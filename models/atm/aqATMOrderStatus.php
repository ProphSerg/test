<?php

namespace app\models\atm;

/**
 * This is the ActiveQuery class for [[ATMOrderStatus]].
 *
 * @see ATMOrderStatus
 */
class aqATMOrderStatus extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ATMOrderStatus[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ATMOrderStatus|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
