<?php
/**
 * Created by PhpStorm.
 * User: haier
 * Date: 2017-11-6
 * Time: 11:44
 */



namespace igetApp\common;


/** 若安全性要求增加 可以更换更复杂的加密算法
 * Interface Crypt
 *
 */
interface Crypt
{
    function thinkEncrypt($data, $key, $expire);
    /*
     * 加密
     */
    function thinkDecrypt($token, $database);
    /*
     * 解密
     */
    function tokenDecrypt($token);
    /*
     * 对token解密 以获取信息
     */

}