<?php

namespace  igetApp\service;

use \Exception;
use  igetApp\common\Client;
use  igetApp\common\InfoCrypt;
use  igetApp\common\ThinkCrypt;
use  igetApp\tpl\Json;

class CreateToken extends BaseService
{
    private $token;
    private $account;
    private $pw;

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }


    /**
     * CreateToken constructor.
     */
    public function __construct($account, $pw,$type)
    {
        $this->account = $account;
        $this->pw = $pw;
        $this->json =  $this->login($type);
    }


    /** 创建token 实现登录
     * @param $type
     * @return Json
     */
    private function login($type)
    {
        $user_id = $this->getUid($type);
        if ($user_id == -1) {
            //登录失败 可能是账号密码不对 也可能是不存在该用户
            //预留 建立秘密输入错误表 多次错误进行拦截和密码重置
            //预留 封号机制 能知道是输错还是被封
            return new Json(null, ERRORMSG_LOGIN_FAILED,20040101);

        } else {
            $client = new Client();
            $ip = $client->getIP();

            $str = $user_id . "+" . md5($this->account) . "+" . $ip . "+" . date("Y-M-d H:i:s");
            //  $str = $user_id . "+" . $ip . "+" . date("M-d H:i:s");

            $crypt = new ThinkCrypt();
            $token = $crypt->thinkEncrypt($str);
            $this->token = $token;

            //显示在body里的假token
            return new Json(base64_encode(date("M-d H:i:s")),MSG_LOGIN_SECCESS);

        }
    }

    public function getUid($type)
    {
        $user = new \igetApp\dao\User();
        $infoCrypt = new InfoCrypt();
        $pwEn = $infoCrypt->pwEncrypt($this->pw);
        $user_id = $user->getUidByAccount($this->account, $pwEn,$type);
        //校验账号密码是否匹配 获取uid
        return $user_id;

    }


}