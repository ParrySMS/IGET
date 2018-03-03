<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2018/1/31
 * Time: 15:23
 */

namespace  igetApp\tpl;

require_once "../tpl/Personal.php";

class StudentPn extends Personal
{
    private $myclass;
    private $myschool;
    private $mylv;
    private $myexp;
    private $mygp;


    /**
     * StudentPn constructor.
     * @param $name
     * @param $num
     * @param $avator
     * @param $myclass
     * @param $myschool
     * @param $mylv
     * @param $myexp
     * @param $mygp
     */
    public function __construct($name, $num, $avator, $myclass, $myschool, $mylv, $myexp, $mygp)
    {
        parent::__construct($name, $num, $avator);
        $this->myclass = $myclass;
        $this->myschool = $myschool;
        $this->mylv = $mylv;
        $this->myexp = $myexp;
        $this->mygp = $mygp;

    }
}