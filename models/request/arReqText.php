<?php

namespace app\models\request;

use Yii;

/**
 * This is the model class for table "ReqText".
 *
 * @property integer $ID
 * @property integer $RequestID
 * @property string $Date
 * @property string $Text
 */
class arReqText extends \yii\db\ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'ReqText';
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
			[['RequestID', 'Text'], 'required'],
			[['RequestID'], 'integer'],
			[['Date'], 'safe'],
			[['Text'], 'string'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'ID' => 'ID',
			'RequestID' => 'Request ID',
			'Date' => 'Date',
			'Text' => 'Text',
		];
	}

	/**
	 * @inheritdoc
	 * @return aqReqText the active query used by this AR class.
	 */
	public static function find() {
		return new aqReqText(get_called_class());
	}

	public function getRequest() {
		return $this->hasOne(arRequest::className(), ['ID' => 'RequestID']);
	}

}
