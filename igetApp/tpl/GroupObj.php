<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2018/1/31
 * Time: 16:03
 */

namespace  igetApp\tpl;


class GroupObj
{
    private $num;
    private $name;
    private $class;
    private $subject;
    private $lv;
    private $exp;
    private $gp;

    public function __construct(array $option)
    {
        $this->num = $num;
        $this->name = $name;
        $this->class = $class;
        $this->subject = $subject;
        $this->lv = $lv;
        $this->exp = $exp;
        $this->gp = $gp;
    }
}