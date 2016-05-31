<?php

namespace app\models\api;

/**
 * This is the ActiveQuery class for [[arBodyPatt]].
 *
 * @see arBodyPatt
 */
class aqBodyPatt extends \yii\db\ActiveQuery
{
    public function BP(arMailPatt $mp)
    {
        return $this
			->andWhere(['name' => $mp->BodyPattern])
			->orderBy('priority');
    }

    /**
     * @inheritdoc
     * @return arBodyPatt[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return arBodyPatt|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
