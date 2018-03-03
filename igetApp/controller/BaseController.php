<?php
/**
 * Created by PhpStorm.
 * User: haier
 * Date: 2018-2-26
 * Time: 19:53
 */

namespace  igetApp\controller;


class BaseController
{ /**
 * @var int $status 用于路由调用的状态码 默认200
 */
    protected $status = 200;

    /** getter方法
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

}