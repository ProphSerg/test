<?php

namespace app\models\pos;

use Yii;

/**
 * This is the model class for table "RegPos".
 *
 * @property integer $ID
 * @property string $ClientN
 * @property string $Name
 * @property string $ContractN
 * @property string $TerminalID
 * @property string $City
 * @property string $Address
 * @property string $MerchantID
 * @property string $KeyNum
 * @property string $TMK_CHECK
 * @property string $TPK_KEY
 * @property string $TPK_CHECK
 * @property string $TAK_KEY
 * @property string $TAK_CHECK
 * @property string $TDK_KEY
 * @property string $TDK_CHECK
 * @property string $DateReg
 */
class arRegPos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'RegPos';
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
            [['ClientN', 'Name', 'ContractN', 'TerminalID', 'City', 'Address', 'MerchantID', 'KeyNum', 'TMK_CHECK', 'TPK_KEY', 'TPK_CHECK', 'TAK_KEY', 'TAK_CHECK', 'TDK_KEY', 'TDK_CHECK'], 'required'],
            [['ClientN', 'Name', 'ContractN', 'TerminalID', 'City', 'Address', 'MerchantID', 'KeyNum', 'TMK_CHECK', 'TPK_KEY', 'TPK_CHECK', 'TAK_KEY', 'TAK_CHECK', 'TDK_KEY', 'TDK_CHECK'], 'string'],
            [['DateReg'], 'safe'],
            [['TerminalID', 'DateReg'], 'unique', 'targetAttribute' => ['TerminalID', 'DateReg'], 'message' => 'The combination of Terminal ID and Date Reg has already been taken.'],
            [['TMK_CHECK'], 'unique'],
            [['TerminalID', 'KeyNum'], 'unique', 'targetAttribute' => ['TerminalID', 'KeyNum'], 'message' => 'The combination of Terminal ID and Key Num has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'ClientN' => 'Client N',
            'Name' => 'Name',
            'ContractN' => 'Contract N',
            'TerminalID' => 'Terminal ID',
            'City' => 'City',
            'Address' => 'Address',
            'MerchantID' => 'Merchant ID',
            'KeyNum' => 'Key Num',
            'TMK_CHECK' => 'Tmk  Check',
            'TPK_KEY' => 'Tpk  Key',
            'TPK_CHECK' => 'Tpk  Check',
            'TAK_KEY' => 'Tak  Key',
            'TAK_CHECK' => 'Tak  Check',
            'TDK_KEY' => 'Tdk  Key',
            'TDK_CHECK' => 'Tdk  Check',
            'DateReg' => 'Date Reg',
        ];
    }

    /**
     * @inheritdoc
     * @return RegPosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new aqRegPos(get_called_class());
    }
}
