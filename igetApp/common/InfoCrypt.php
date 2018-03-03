<?php

namespace  igetApp\common;


use \Exception;
use  igetApp\tpl\Json;

//$i = new InfoCrypt();
//echo $i->pwEncrypt(123456);

class InfoCrypt
{




    /** 密码的不可逆加密
     * @param $pw
     * @return string
     */
    public function pwEncrypt($pw)
    {
        return md5(sha1(md5($pw)));
    }




    /** 学号加密
     * @param $stuNum
     * @return string
     */
    public function stuNumEncrypt($stuNum)
    {
        $stuNum = $stuNum + STU_NUM_ENCRYPT;
        return base64_encode($stuNum);
    }


    /** 学号解密
     * @param $stuNum
     * @return bool|string
     */
    public
    function stuNumDecrypt($stuNum)
    {
        $stuNum = base64_decode($stuNum);
        $stuNum = $stuNum - STU_NUM_ENCRYPT;
        return $stuNum;
    }

    /** 注册用户sign加密
     * @param $uid
     * @param $code_id
     * @return string
     */
    public function signEncrypt($uid, $code_id)
    {
        if (empty($uid) || empty($code_id)) {
            throw new Exception("COMMON_ERROR: InfoCrypt signEncrypt null", 500);
        }
        $str = $uid . '+' . $code_id . '+' . NONSTR_CH . '+' . rand(0, 100);
        return urlencode(base64_encode($str));
    }

    /** sign解密
     * @param $sign
     * @return array
     */
    public
    function signDecrypt($sign)
    {
        if (empty($sign)) {
            throw new Exception("COMMON_ERROR: InfoCrypt signDecrypt null", 500);
        }
        $str = base64_decode(urldecode($sign));
        $uid = strtok($str, "+");
        $code_id = strtok("+");
        return array(
            'uid' => $uid,
            'code_id' => $code_id
        );
    }

    /**
     * 验证码储存的不可逆加密
     */
    public function codeEncrypt($code)
    {
        return md5(sha1(md5($code)));
    }

    /** 时效性ticket加密
     * @param $code_id
     * @return string
     */
    public function ticketEncrypt($code_id)
    {
        $time = time();
        $timeStr = date('Y-m-d H:i:s',$time);
        $pre = md5(sha1($code_id));
        $last = sha1(md5($timeStr));
        $str = $pre . '+' . $last . '+' . $time . '+' . rand(0, 100);
        return urlencode(base64_encode($str));
    }

    /** 校验检查是否为有效的ticket
     * @param $code_id
     * @param $ticket
     * @throws Exception
     */
    public function isVaildTicket($code_id, $ticket){
        $str = base64_decode(urldecode($ticket));
        $pre = strtok($str, "+");
        $last = strtok("+");
        $time = strtok("+");
        $timeStr = date('Y-m-d H:i:s',$time);

        if(!$timeStr||  $last != sha1(md5($timeStr))){
            throw new Exception("COMMON_ERROR: invaild ticket 01",500);
        }
        //过期
        if(time()-$time>TICKET_TIME){
            $jsonEn = json_encode(new Json(null,20040311,MSG_EXPIRED_TICKET));
            throw new Exception($jsonEn,200);
        }
        //code校验
        if( $pre != md5(sha1($code_id))){
            throw new Exception("COMMON_ERROR: invaild ticket 02",500);
        }
    }

    /**
     * @param $account
     * @return string
     */
    public function adminAccountEncrypt($account)
    {
        $account = NONSTR.$account .'+'.NONSTR_CH;
        return base64_encode($account);
    }

    public function adminAccountDecrypt($accEn)
    {
        $str = base64_decode($accEn);
        $pre = strtok($str, "+");
        $len = mb_strlen(NONSTR);
        $account = mb_substr($pre,$len);
        return $account;
    }


}
