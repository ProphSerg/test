<?php

namespace app\models\atm;

/**
 * This is the ActiveQuery class for [[SprATMOrderTech]].
 *
 * @see SprATMOrderTech
 */
class aqSprATMOrderTech extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return SprATMOrderTech[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SprATMOrderTech|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
