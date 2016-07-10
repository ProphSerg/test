<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\request;

/**
 * Description of RequestTS
 *
 * @author proph
 */
class RequestTS extends arRequest {

	public $Text;

	public function rules() {
		return [
			[['Name', 'Desc', 'Text'], 'required'],
			[['Desc', 'Append', 'Contact', 'Name', 'Addr', 'Text'], 'string'],
		];
	}

}
