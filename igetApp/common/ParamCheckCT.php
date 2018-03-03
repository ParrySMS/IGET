<?php

namespace  igetApp\common;


use \Exception;

class ParamCheckCT
{
    private $account;
    private $pw;

    /**
     * @return int|null
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @return bool|mixed|string
     */
    public function getPw()
    {
        return $this->pw;
    }


    public function __construct($account, $pw,$type)
    {

        $safe = new  \igetApp\common\Safe();
        //空验证
        if (empty($pw)) {
            throw new Exception("PARAM_ERROR: password null", 400);
        }

        if (empty($account)) {
            throw new Exception("PARAM_ERROR: account null", 400);
        }

        if (empty($type)) {
            throw new Exception("PARAM_ERROR: type null", 400);
        }

        //过滤 与 格式验证
        $account = $safe->strtrim_check($account);
//        $account = $safe->phone_check($account);

        $pw = $safe->strtrim_check($pw);
        $pw = $safe->password_check($pw);

        $typeRegion = eval(LOGIN_TYPE_REGION);
        if(!in_array($type,$typeRegion)){
            throw new Exception("PARAM_ERROR: type $type not in region", 400);
        }

        $this->account = $account;
        $this->pw = $pw;

    }



}