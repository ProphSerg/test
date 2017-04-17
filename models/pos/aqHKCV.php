<?php

namespace app\models\pos;

/**
 * This is the ActiveQuery class for [[arHKCV]].
 *
 * @see arHKCV
 */
class aqHKCV extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return arHKCV[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return arHKCV|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
