<?php
/**
 * Created by PhpStorm.
 * User: haier
 * Date: 2018-2-26
 * Time: 20:17
 */

namespace  igetApp\service;
use \Exception;


class BaseService
{
    /**
     * @var \zzxApp\model\Json $json 功能实现后的封装好的json
     */
    protected $json;


    /** getter方法 实现某一个功能，返回数据封装到retdata对象里，返回json
     * @return \zzxApp\model\Json
     */
    public function getJson(){
        return $this->json;
    }

}