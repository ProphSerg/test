<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\pos;

use yii\base\Model;

/**
 * Description of KeyReserveModel
 *
 * @author proph
 */
class KeyReserveModel extends Model {

    public $KeyDate;
    public $KeyStart;
    public $KeyEnd;

    public function rules() {
        return [
            [['KeyDate', 'KeyStart', 'KeyEnd'], 'required'],
            [['KeyDate'], 'string'],
            [['KeyStart', 'KeyEnd'], 'integer', 'min' => 1, 'max' => 9999],
            [['KeyEnd'], 'compare', 'compareAttribute' => 'KeyStart', 'operator' => '>='],
            [['KeyDate'], 'match', 'pattern' => '/^\d{6}$/'],
        ];
    }

    public function attributeLabels() {
        return [
            'KeyDate' => arKey::NUMBER_PREFIX . '_',
            'KeyStart' => 'С',
            'KeyEnd' => 'ПО',
        ];
    }

    public function save() {
        var_dump($this);
        return arKeyReserve::EnterRange($this->KeyDate, $this->KeyStart, $this->KeyEnd);
    }

}
