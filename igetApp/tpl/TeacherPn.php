<?php
/**
 * Created by PhpStorm.
 * User: haier
 * Date: 2017-11-18
 * Time: 12:39
 */

namespace igetApp\tpl;

require_once "../tpl/Personal.php";

class TeacherPn extends Personal
{
    public $myclass;
    public $mysubject;
    public $myschool;//增加了学校,我觉得这些变量应该设置为私有的，其他页面要得到或者修改他们的值应该通过函数？

    /**
     * TeacherPn constructor.
     * @param $name
     * @param $num
     * @param $avator
     * @param $myclass
     * @param $mysubject
     * @param $myschool
     */
    public function __construct($name, $num, $avator,$myclass, $mysubject, $myschool)//增加了学校参数,参数id修改为num
    {
        parent::__construct($name, $num, $avator);
        $this->myclass = $myclass;
        $this->mysubject = $mysubject;
        $this->myschool = $myschool;
    }

}