<?php

namespace app\models\atm;

/**
 * This is the ActiveQuery class for [[ATMOrderRemark]].
 *
 * @see ATMOrderRemark
 */
class aqATMOrderRemark extends \yii\db\ActiveQuery
{
	/*
    public function order($id)
    {
        return $this->andWhere([]);
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
