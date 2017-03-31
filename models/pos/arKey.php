<?php

namespace app\models\pos;

use Yii;
use app\common\KeyCheck;

/**
 * This is the model class for table "key".
 *
 * @property string $Number
 * @property string $Comp1
 * @property string $Comp2
 * @property string $Comp3
 */
class arKey extends \yii\db\ActiveRecord {

    const NUMBER_PREFIX = 'O03S2';
    const NUMBER_PATTERN = '/^' . self::NUMBER_PREFIX . '_\d{6}_\d{4}$/';

    public $Check;

    //public $FullKey;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'key';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb() {
        return Yii::$app->get('dbKey');
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['Number', 'Comp1', 'Comp2', 'Comp3'], 'required'],
            [['Number', 'Comp1', 'Comp2', 'Comp3', 'Check'], 'string'],
            [['Number'], 'unique'],
            [['Number', 'Comp1', 'Comp2', 'Comp3', 'Check'], 'trim'],
            [['Number', 'Comp1', 'Comp2', 'Comp3', 'Check'], 'filter', 'filter' => 'strtoupper', 'skipOnArray' => true],
            [['Number'], 'match', 'pattern' => self::NUMBER_PATTERN],
            [['Comp1', 'Comp2', 'Comp3'], 'match', 'pattern' => '/^[0-9A-F]{32}$/'],
            [['Check'], 'validateCheckKCV'],
#			[['Check', 'Comp1', 'Comp2', 'Comp3'], 'validateCheckKCV'],
        ];
    }

    public function validateCheckKCV($attribute) {
        /*
          Yii::info(['validateCheckKCV('.$attribute.')!',
          'hasErrors()',
          $this->hasErrors(),
          'Check',
          $this->Check,
          'Comp1',
          $this->Comp1,
          'Comp2',
          $this->Comp2,
          'Comp3',
          $this->Comp3,
          ], 'parse');
         * 
         */
        if (!$this->hasErrors() && !empty($this->Check) &&
                !empty($this->Comp1) && !empty($this->Comp2) && !empty($this->Comp3) &&
                ($this->Check != KeyCheck::FullKeyKCV($this->Comp1, $this->Comp2, $this->Comp3))) {
            $this->addError($attribute, 'Контрольная сумма не совподает с введенными ключами');
        }
    }

    public function afterFind() {
        parent::afterFind();
        $this->Check = KeyCheck::FullKeyKCV($this->Comp1, $this->Comp2, $this->Comp3);
    }

    public function getComp1Check() {
        return KeyCheck::KCV(KeyCheck::binKey($this->Comp1));
    }

    public function getComp2Check() {
        return KeyCheck::KCV(KeyCheck::binKey($this->Comp2));
    }

    public function getComp3Check() {
        return KeyCheck::KCV(KeyCheck::binKey($this->Comp3));
    }

    public function getFullKey() {
        return KeyCheck::FullKey($this->Comp1, $this->Comp2, $this->Comp3);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'Number' => 'Номер ключа',
            'Comp1' => 'Компонента 1',
            'Comp2' => 'Компонента 2',
            'Comp3' => 'Компонента 3',
            'Check' => 'Контрольная сумма (KCV)',
            'FullKey'=>'Итоговый ключ'
        ];
    }

    /**
     * @inheritdoc
     * @return aqKey the active query used by this AR class.
     */
    public static function find() {
        return new aqKey(get_called_class());
    }

    public static function isExist() {
        try {
            self::getTableSchema();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function CanAccess() {
        return self::isExist() && \Yii::$app->user->can('РольKeys');
    }

}
