<?php

namespace app\models\api;

use Yii;

/**
 * This is the model class for table "MailPatt".
 *
 * @property integer $ID
 * @property string $Pattern
 * @property string $Model
 */
class arMailPatt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'MailPatt';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('dbApi');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Pattern', 'Model'], 'required'],
            [['Pattern', 'Model'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'Pattern' => 'Шаблон',
            'Model' => 'Модель',
        ];
    }

    /**
     * @inheritdoc
     * @return aqMailPatt the active query used by this AR class.
     */
    public static function find()
    {
        return new aqMailPatt(get_called_class());
    }
}
