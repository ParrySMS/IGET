<?php
/**
 * Created by PhpStorm.
 * User: haier
 * Date: 2018-2-26
 * Time: 19:53
 */

namespace  igetApp\controller;
use \Exception;
use igetApp\common\ParamCheckCT;

class CreateToken extends BaseController
{
    private $token;

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
    public function __construct($account,$pw, $type)
    {
        try {
            //对输入内容做安全检查 前端参数解密
            $pmCheck = new  ParamCheckCT($account,$pw,$type);
            $account = $pmCheck->getAccount();
            $pw = $pmCheck->getPw();
            //todo 暂时不做 登录权限检查 是否连续登录超过限制？（防暴力破解密码）
            $scCT = new \igetApp\service\CreateToken($account, $pw,$type);
            $this->token = $scCT->getToken();
            $json = $scCT->getJson();
            if (!is_null($json)) {
                print_r(json_encode($json));
            }

        }catch(Exception $e){
            $this->status = $e->getCode();
//            $this->status =200;
//            var_dump($e);
            echo $e->getMessage();
        }
    }


}