<?php

namespace app\models\api;

use Yii;
use yii\base\Model;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;
use app\models\request\arRequest;
use app\models\request\arReqText;
use app\common\Convert;

/**
 * Description of PostMail
 *
 * @author proph
 */
class ConvertAction extends \yii\base\Action {

	const LOG_CATEGORY = 'api';

	public $checkAccess;

	private function parse(\SimpleXMLElement $item) {
		return mb_convert_encoding(base64_decode(trim((string) $item)), 'UTF-8', 'UTF-16LE');
	}

	public function run() {
		if ($this->checkAccess) {
			call_user_func($this->checkAccess, $this->id);
		}

		#echo Yii::$app->getRequest()->getRawBody();
		libxml_use_internal_errors(true);
		$XML = new \SimpleXMLElement(Yii::$app->getRequest()->getRawBody());
		if (!$XML) {
			throw new ServerErrorHttpException('Failed to parse data. ' . implode('. ', libxml_get_errors()));
		}
		#var_dump($XML->asXML());

		switch (strtolower($XML->getName())) {
			case 'requests':
				$this->requests($XML);
				break;
		}
	}

	const CommentPatt = '/^\d{2}\.\d{2}\.\d{4} \d{2}:\d{2}/ui';

	private function requests($XML) {
		foreach ($XML->Request as $req) {
			echo "{$req['ID']}: {$req->ReqNumType} {$req->ReqNum}\n";

			$ReqDesc = preg_replace('/[\n\r](\d{2}\.)/usi', '|$1', $req->ReqDesc);
			if ($req->ReqNumType == 'SD') {
				$rq = arRequest::find()->getRequest($req->ReqNum);
				if ($rq !== null) {
					foreach (explode('|', $ReqDesc) as $desc) {
						$rt = new arReqText();
						if (preg_match(self::CommentPatt, $desc) > 0) {
							$rt->Text = substr($desc, 17);
							$rt->Date = Convert::Date2SQLiteDate(substr($desc, 0, 16));
							#echo "\t{$desc} => {$rt->Date}\n";

							$rt->link('request', $rq);
						}
					}
				} else {
					$rq = new arRequest();
					$rq->Addr = trim($req->ReqAddr);
					$rq->Append = ($req->ReqAppend == '-' ? null : trim($req->ReqAppend));
					$rq->Contact = ($req->ReqPhone == '-' ? null : trim($req->ReqPhone));
					$rq->Date = Convert::DateTime2UTC(new \DateTime($req->ReqDate));
					$rq->DateClose = ($req->ReqClose === null ? null : Convert::DateTime2UTC(new \DateTime($req->ReqClose)));
					$rq->Desc = trim($req->ReqDesc);
					$rq->Name = trim($req->ReqName);
					$rq->Number = trim($req->ReqNum);
					$rq->Overdue = ($req->Priority > 0);
					$rq->Type = ($req->ReqNumType == 'TS' ? arRequest::REQUEST_TS : arRequest::REQUEST_ATM);


					$trans = arRequest::getDb()->beginTransaction();
					try {
						if ($rq->save() === false) {
							throw new Exception('Request (convert): Ошибка записи.');
						}

						foreach (explode('|', $ReqDesc) as $desc) {
							$rt = new arReqText();
							if (preg_match(self::CommentPatt, $desc) > 0) {
								$rt->Text = substr($desc, 17);
								$rt->Date = Convert::Date2SQLiteDate(substr($desc, 0, 16));
								#echo "\t{$desc} => {$rt->Date}\n";
							} else {
								$rt->Text = $desc;
								$rt->Date = $rq->Date;
							}
							$rt->link('request', $rq);
						}
						$trans->commit();
					} catch (\Exception $e) {
						$trans->rollback();
						Yii::warning("Ошибка записи в базу. " . Convert::Exception2Str($e), self::LOG_CATEGORY);
						Yii::error("Ошибка записи в базу. " . Convert::Exception2Str($e), self::LOG_CATEGORY);
						Yii::error(['arRequest', $rq->attributes, 'arReqText', $rt->attributes], self::LOG_CATEGORY);
						throw new ServerErrorHttpException("Request: Ошибка записи в базу. " . Convert::Exception2Str($e));
					}
				}
			}
		}
	}

}
