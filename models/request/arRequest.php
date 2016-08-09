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
 * @property string $DateClose
 * @property string $Desc
 * @property string $Append
 * @property string $Contact
 * @property string $Name
 * @property string $Addr
 * @property boolean $Overdue
 */
class arRequest extends \yii\db\ActiveRecord {

	const REQUEST_SD = 0;
	const REQUEST_TS = 1;
	const REQUEST_ATM = 2;

	public $countType;
	public $typeName;

	public function __construct($_Type = self::REQUEST_SD) {
		$this->Type = $_Type;
		parent::__construct();
	}

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'Request';
	}

	/**
	 * @return \yii\db\Connection the database connection used by this AR class.
	 */
	public static function getDb() {
		return Yii::$app->get('dbRequest');
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['Type', 'Number', 'Date'], 'required'],
			[['Type', 'Number'], 'integer'],
			[['Date', 'DateClose'], 'safe'],
			[['Desc', 'Append', 'Contact', 'Name', 'Addr'], 'string'],
			[['Overdue'], 'boolean'],
			[['Type', 'Number'], 'unique', 'targetAttribute' => ['Type', 'Number'], 'message' => 'The combination of Type and Number has already been taken.'],
			[['countType'], 'integer'],
			[['typeName'], 'string'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'ID' => 'ID',
			'Type' => 'Type',
			'Number' => 'Номер',
			'Date' => 'Дата заявки',
			'DateClose' => 'Дата закрытия',
			'Desc' => 'Описание',
			'Append' => 'Доп.информация',
			'Contact' => 'Контактный телефон',
			'Name' => 'Название',
			'Addr' => 'Адрес',
			'Overdue' => 'Просрочена?',
			'countType' => 'Количество заявок',
			'typeName' => 'Тип заявки',
		];
	}

	/**
	 * @inheritdoc
	 * @return aqRequest the active query used by this AR class.
	 */
	public static function find() {
		return new aqRequest(get_called_class());
	}

	public function getTexts() {
		return $this->hasMany(arReqText::className(), ['RequestID' => 'ID'])->inverseOf('request')
				->orderBy('Date');
		;
	}

	public function getTypeName() {
		return $this->hasOne(arSprType::className(), ['ID' => 'Type']);
	}

	public static function getNextNumber($Type) {
		$num = self::find()->where(['Type' => $Type])->max('Number');
		return ($num === null ? 1 : $num + 1);
	}

}
