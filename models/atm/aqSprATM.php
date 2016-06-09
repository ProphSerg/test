<?php

namespace app\models\atm;

/**
 * This is the ActiveQuery class for [[SprATM]].
 *
 * @see SprATM
 */
class aqSprATM extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return SprATM[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SprATM|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
