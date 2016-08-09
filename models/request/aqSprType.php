<?php

namespace app\models\request;

/**
 * This is the ActiveQuery class for [[arSprType]].
 *
 * @see arSprType
 */
class aqSprType extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return arSprType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return arSprType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
