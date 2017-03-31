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
    private static $_empty_key = "\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0";

    public static function binKey($key = "") {
        return ($key == "" ? self::$_empty_key : pack('H*', $key . substr($key, 0, 16)));
    }

    public static function binFullKey($key1, $key2, $key3) {
        return self::binKey($key1) ^ self::binKey($key2) ^ self::binKey($key3);
    }

    public static function FullKey($key1, $key2, $key3) {
        return substr(strtoupper(bin2hex(self::binFullKey($key1, $key2, $key3))), 0, 32);
    }

    public static function KCV($key, $len = 6) {
        return substr(strtoupper(bin2hex(self::binKCV($key))), 0, $len);
    }

    public static function binKCV($key) {
        return \mcrypt_encrypt(MCRYPT_3DES, $key, self::$_data, MCRYPT_MODE_ECB);
    }

    public static function FullKeyKCV($key1, $key2, $key3, $len = 6) {
        return self::KCV(self::binFullKey($key1, $key2, $key3), $len);
    }

}
