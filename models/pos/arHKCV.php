<?php

namespace app\models\pos;

use Yii;

/**
 * This is the model class for table "HypercomKCV".
 *
 * @property integer $ID
 * @property string $Serial
 * @property string $DateEnter
 * @property integer $KeyNum
 * @property string $KCV
 */
class arHKCV extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'HypercomKCV';
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
            [['Serial', 'DateEnter', 'KeyNum', 'KCV'], 'required'],
            [['Serial', 'KCV'], 'string'],
            [['DateEnter'], 'safe'],
            [['KeyNum'], 'integer'],
            [['Serial', 'DateEnter', 'KeyNum', 'KCV'], 'unique', 'targetAttribute' => ['Serial', 'DateEnter', 'KeyNum', 'KCV'], 'message' => 'The combination of Serial, Date Enter, Key Num and Kcv has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'ID' => 'ID',
            'Serial' => 'Сер. №',
            'DateEnter' => 'Дата',
            'KeyNum' => 'Ячейка №',
            'KCV' => 'KCV',
        ];
    }

    /**
     * @inheritdoc
     * @return aqHKCV the active query used by this AR class.
     */
    public static function find() {
        return new aqHKCV(get_called_class());
    }

    public function getReg() {
        return $this->hasMany(arRegPos::className(), ['KEY_CHECK' => 'KCV'])
                ->orderBy('DateReg DESC');
    }

}
