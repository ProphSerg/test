<?php

namespace app\models\request;

use Yii;

/**
 * This is the model class for table "Request".
 *
 * @property integer $ID
 * @property integer $Type
 * @property integer $Number
 * @property string $Date
 * @property string $Desc
 * @property string $Append
 * @property string $Contact
 * @property string $Name
 * @property string $Addr
 */
class arRequest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Request';
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
            [['Type', 'Number'], 'required'],
            [['Type', 'Number'], 'integer'],
            [['Date'], 'safe'],
            [['Desc', 'Append', 'Contact', 'Name', 'Addr'], 'string'],
            [['Type', 'Number'], 'unique', 'targetAttribute' => ['Type', 'Number'], 'message' => 'The combination of Type and Number has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'Type' => 'Type',
            'Number' => 'Number',
            'Date' => 'Date',
            'Desc' => 'Desc',
            'Append' => 'Append',
            'Contact' => 'Contact',
            'Name' => 'Name',
            'Addr' => 'Addr',
        ];
    }

    /**
     * @inheritdoc
     * @return aqRequest the active query used by this AR class.
     */
    public static function find()
    {
        return new aqRequest(get_called_class());
    }
}
