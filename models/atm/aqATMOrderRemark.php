<?php

namespace app\models\atm;

/**
 * This is the ActiveQuery class for [[ATMOrderRemark]].
 *
 * @see ATMOrderRemark
 */
class aqATMOrderRemark extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ATMOrderRemark[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ATMOrderRemark|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
