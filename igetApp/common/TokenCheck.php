<?php

namespace igetApp\common;

use \Exception;
use  igetApp\dao\User;


class TokenCheck
{
    private $token;
    private $user_id;

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }


    /**
     * TokenCheck constructor.
     * @param $token
     */
    public function __construct($token)
    {
        $safe = new \zzxApp\common\Safe();
        $token = $safe->strtrim_check($token);

        $tokenInfo = $this->getTokenInfo($token);
        $this->CheckTokenInfo($tokenInfo);
        $this->token = $token;
    }

    /** 解密 获取token信息包
     * @param $token
     * @return array|null
     */
    private function getTokenInfo($token){
        $thinkCrypt = new ThinkCrypt();
        $tokenAr = $thinkCrypt->tokenDecrypt($token);
        return $tokenAr;
    }

    /** 根据token信息包 检查各个参数值 确认token的有效性 并存入user_id
     * @param $tokenInfo
     * @throws Exception
     */
    private function CheckTokenInfo($tokenInfo){
        if(in_array('',$tokenInfo)||in_array(null,$tokenInfo)){
            throw new Exception("TOKEN_ERROR: invalid token3",403);
        }
        //拆解
        extract($tokenInfo,EXTR_OVERWRITE);
        /* 对应封装说明 详见 service/CreateToken L60
        *   $tokenAr =compact('user_id','md5Account','ip','date','nonstr');
        */
        if(empty($date)||empty($user_id)||empty($md5Account)){
            throw new Exception("COMMON_ERROR: extract tokenInfo",500);
        }
        //过期检查
        $this->CheckTokenTime($date);
        //用户有效性检查
        $this->CheckUser($user_id,$md5Account);

        $this->user_id = $user_id;

    }

    /** 根据token里的时间字符串 检查时间戳是否过期
     * @throws Exception
     */
    private function CheckTokenTime($date)
    {
        $tokenTime = strtotime($date);
        if (time() - $tokenTime > (EXPIRES - time())) {
            throw new Exception("TOKEN_ERROR: invalid token4", 403);
        }
    }


    /** 根据uid找到该用户，再对手机号校验 检验用户有效性
     * @param $user_id
     * @param $md5Account
     * @param $database
     * @throws Exception
     */
    private function CheckUser($user_id,$md5Account){
        $user = new User();
        $account = $user->getAccount($user_id);
        //账号不存在 或不符合
        if(empty($account)|| md5($account)!=$md5Account){
            throw new Exception("TOKEN_ERROR: invalid token6", 403);
        }
    }


}