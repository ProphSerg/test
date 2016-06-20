<?php

namespace app\models\api;

use Yii;

/**
 * This is the model class for table "BodyPatt".
 *
 * @property integer $ID
 * @property string $Name
 * @property string $Model
 * @property string $Pattern
 */
class arBodyPatt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'BodyPatt';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('dbSys');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Name', 'Pattern'], 'required'],
            [['Name', 'Pattern'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'Name' => 'Name',
            'Pattern' => 'Pattern',
        ];
    }

    /**
     * @inheritdoc
     * @return aqBodyPatt the active query used by this AR class.
     */
    public static function find()
    {
        return new aqBodyPatt(get_called_class());
    }
}
