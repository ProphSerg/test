<?php

namespace app\models\request;

use Yii;

/**
 * This is the model class for table "sprType".
 *
 * @property integer $ID
 * @property string $Name
 */
class arSprType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sprType';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('dbRequest');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'Name'], 'required'],
            [['ID'], 'integer'],
            [['Name'], 'string'],
            [['ID'], 'unique'],
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
        ];
    }

    /**
     * @inheritdoc
     * @return aqSprType the active query used by this AR class.
     */
    public static function find()
    {
        return new aqSprType(get_called_class());
    }
}
