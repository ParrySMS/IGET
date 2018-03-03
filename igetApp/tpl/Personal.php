<?php
namespace  igetApp\tpl;

/**
 * Created by PhpStorm.
 * User: haier
 * Date: 2017-11-18
 * Time: 12:36
 */
class Personal
{
    public $name;
    public $num;//原本是id，修改为num，理由是区别于主键id自增，这里是指工号或学号
    public $avator;

    /**
     * personal constructor.
     * @param $name
     * @param $id
     * @param $avator
     */
    public function __construct($name, $num, $avator)
    {
        $this->name = $name;
        $this->num = $num;
        $this->avator = $avator;
    }


}