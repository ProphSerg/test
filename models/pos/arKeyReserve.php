<?php

namespace app\models\pos;

use Yii;

/**
 * This is the model class for table "KeyReserve".
 *
 * @property string $Number
 * @property string $Comment
 */
class arKeyReserve extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'KeyReserve';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('dbPos');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Number', 'Comment'], 'required'],
            [['Number', 'Comment'], 'string'],
            [['Number'], 'unique'],
            [['Number'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Number' => 'Number',
            'Comment' => 'Comment',
        ];
    }

    /**
     * @inheritdoc
     * @return KeyReserveQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new aqKeyReserve(get_called_class());
    }
}
