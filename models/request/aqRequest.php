<?php

namespace app\models\request;

/**
 * This is the ActiveQuery class for [[arRequest]].
 *
 * @see arRequest
 */
class aqRequest extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return arRequest[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return arRequest|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
