<?php

namespace app\models\request;

use Yii;
use app\common\Convert;

/**
 * This is the model class for table "ReqText".
 *
 * @property integer $ID
 * @property integer $RequestID
 * @property string $Date
 * @property string $Text
 */
class arReqText extends \yii\db\ActiveRecord {
	#public $fullDesc;

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

	public function getFullDesc() {
		return Yii::$app->formatter->asDatetime($this->Date, 'php:d/m/Y H:i') . ' ' . $this->Text;
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['RequestID', 'Date', 'Text'], 'required'],
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
			'Date' => 'Дата',
			'Text' => 'Описание',
			'FullDesc' => 'Описание',
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

	public function addComment() {
		$this->Date = null;
		$this->save();
	}

	public function closeRequest() {
		$req = arRequest::find()->getRequestID($this->RequestID);

		$req->DateClose = Convert::Date2SQLiteDate($this->Date, Convert::DateOnlyFormat);
		$this->Date = Convert::SQLiteDateNow();
		#var_dump($this);
		$trans = arRequest::getDb()->beginTransaction();
		try {
			if ($req->save() === false) {
				if (($rq = arRequest::find()->getRequest($fields['Number'])) === null) {
					throw new Exception('Request: Ошибка записи и поиска имеющейся записи.');
				}
			}

			$this->save();
			$trans->commit();
		} catch (\Exception $e) {
			$trans->rollback();
			#Yii::warning("Ошибка записи в базу. " . Convert::Exception2Str($e), \app\models\api\MailAction::LOG_CATEGORY);
			#Yii::error("Ошибка записи в базу. " . Convert::Exception2Str($e), \app\models\api\MailAction::LOG_CATEGORY);
			#Yii::error(['arRequest', $rq->attributes, 'arReqText', $rt->attributes], \app\models\api\MailAction::LOG_CATEGORY);
			throw new ServerErrorHttpException("Request: Ошибка записи в базу. " . Convert::Exception2Str($e));
		}
	}

}
