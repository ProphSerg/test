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
 * @property string $KEY_CHECK
 * @property string $TPK_KEY
 * @property string $TPK_CHECK
 * @property string $TAK_KEY
 * @property string $TAK_CHECK
 * @property string $TDK_KEY
 * @property string $TDK_CHECK
 * @property string $DateReg
 */
class arRegPos extends \yii\db\ActiveRecord {

    public $MinDate, $MaxDate, $KeyType;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'RegPos';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb() {
        return Yii::$app->get('dbPos');
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['ClientN', 'Name', 'ContractN', 'TerminalID', 'Address', 'MerchantID', 'KeyNum', 'KEY_CHECK'], 'required'],
            [['TPK_KEY', 'TAK_KEY', 'TDK_KEY'], 'required', 'when' => function($model) {
                    return substr($model->KeyNum, 0, 5) == 'O03S2';
                }],
            [['ClientN', 'Name', 'ContractN', 'TerminalID', 'City', 'Address', 'MerchantID', 'KeyNum', 'KEY_CHECK', 'TPK_KEY', 'TPK_CHECK', 'TAK_KEY', 'TAK_CHECK', 'TDK_KEY', 'TDK_CHECK'], 'string'],
            [['DateReg'], 'safe'],
            #[['TerminalID', 'DateReg'], 'unique', 'targetAttribute' => ['TerminalID', 'DateReg'], 'message' => 'The combination of Terminal ID and Date Reg has already been taken.'],
            [['ClientN', 'Name', 'ContractN', 'TerminalID', 'City', 'Address', 'MerchantID', 'KeyNum', 'KEY_CHECK', 'TPK_KEY', 'TPK_CHECK', 'TAK_KEY', 'TAK_CHECK', 'TDK_KEY', 'TDK_CHECK'], 'trim'],
            [['KeyNum', 'KEY_CHECK', 'TPK_KEY', 'TPK_CHECK', 'TAK_KEY', 'TAK_CHECK', 'TDK_KEY', 'TDK_CHECK'], 'filter', 'filter' => 'strtoupper', 'skipOnArray' => true],
            [['KeyNum'], 'match', 'pattern' => arKey::NUMBER_PATTERN],
            [['TPK_KEY', 'TAK_KEY', 'TDK_KEY'], 'match', 'pattern' => '/^[0-9A-F]{32}/'],
            [['KEY_CHECK', 'TPK_CHECK', 'TAK_CHECK', 'TDK_CHECK'], 'match', 'pattern' => '/^[0-9A-F]{6}/'],
            [['TerminalID', 'KeyNum'], 'unique', 'targetAttribute' => ['TerminalID', 'KeyNum'], 'message' => 'The combination of TerminalID and KeyNum has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'ID' => 'ID',
            'ClientN' => 'Client #',
            'Name' => 'Название ТСП',
            'ContractN' => 'Contract #',
            'TerminalID' => 'Terminal ID',
            'City' => 'Город',
            'Address' => 'Адрес установки',
            'MerchantID' => 'MerchantID',
            'KeyNum' => 'Серийный номер ключа',
            'KEY_CHECK' => 'KEY_CHECK',
            'TPK_KEY' => 'TPK_KEY',
            'TPK_CHECK' => 'TPK_CHECK',
            'TAK_KEY' => 'TAK_KEY',
            'TAK_CHECK' => 'TAK_CHECK',
            'TDK_KEY' => 'TDK_KEY',
            'TDK_CHECK' => 'TDK_CHECK',
            'DateReg' => 'Дата регистрации',
        ];
    }

    /**
     * @inheritdoc
     * @return RegPosQuery the active query used by this AR class.
     */
    public static function find() {
        return new aqRegPos(get_called_class());
    }

    public function afterFind() {
        parent::afterFind();
        $this->KeyType = (substr($this->KeyNum, 0, 5) == 'O03S2' ? 'TMK' : 'KLK');
    }

    public static function findDateByBlock($block) {
        return self::find()->select([
                            'MinDate' => 'min(DateReg)',
                            'MaxDate' => 'max(DateReg)',
                        ])->
                        where(['like', 'KeyNum', $block])->
                        one();
    }

    public function getKeys() {
        if (arKey::CanAccess()) {
            return $this->hasOne(arKey::className(), ['Number' => 'KeyNum']);
        }

        #return $this->hasOne(arKey::className(), ['Number' => 'KeyNum']);
        return null;
    }

    public function save($runValidation = true, $attributeNames = null) {
        $ret = parent::save($runValidation, $attributeNames);
        if ($ret) {
            $k = arKeyReserve::findReserve($this->KeyNum);
            if ($k == null) {
                $k = new arKeyReserve();
            }
            $k->Number = $this->KeyNum;
            $k->Comment = $this->Name;
            $k->validate() && $k->save();
        }

        return $ret;
    }

    public function getFullDesc() {
        return implode(' ', [
            Yii::$app->formatter->asDatetime($this->DateReg, 'php:d/m/Y H:i'),
            $this->TerminalID,
            $this->Name,
            $this->Address,
        ]);
    }

}
