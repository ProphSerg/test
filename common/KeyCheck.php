<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common;

/**
 * Description of KeyCheck
 *
 * @author proph
 */
class KeyCheck {

	private static $_data = "\0\0\0\0\0\0\0\0";

	public static function CreateKey($key) {
		return pack('H*', $key . substr($key, 0, 16));
	}

	public static function CreateFullKey($key1, $key2, $key3) {
		return self::CreateKey($key1) ^ self::CreateKey($key2) ^ self::CreateKey($key3);
	}

	public static function KCV($key, $len = 6) {
		return self::KCVbin(self::CreateKey($key), $len);
	}

	public static function KCVbin($key, $len = 6) {
		return substr(strtoupper(bin2hex(\mcrypt_encrypt(MCRYPT_3DES, $key, self::$_data, MCRYPT_MODE_ECB))), 0, $len);
	}

	public static function FullKeyKCV($key1, $key2, $key3, $len = 6) {
		return self::KCVbin(self::CreateFullKey($key1, $key2, $key3), $len);
	}

}
