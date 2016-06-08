<?php

namespace app\models\api;

/**
 * This is the ActiveQuery class for [[arBodyPatt]].
 *
 * @see arBodyPatt
 */
class aqBodyPatt extends \yii\db\ActiveQuery
{
    public function BP($name)
    {
        return $this
			->andWhere(['name' => $name])
			->orderBy('Priority')
			->all();
    }

    public function BPreplace($name)
    {
        return $this
			->andWhere(['name' => $name . '.replace'])
			->orderBy('Priority')
			->all();
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
