<?php
/**
 * Created by PhpStorm.
 * User: haier
 * Date: 2017-11-21
 * Time: 19:30
 */

namespace  igetApp\tpl;


class ClassObj
{
    public $id;
    public $class;
    public $grade;
    public $school;

    /**
     * ClassObj constructor.
     * @param $id
     * @param $class
     * @param $grade
     * @param $school
     */
    public function __construct($id, $class, $grade, $school)
    {
        $this->id = $id;
        $this->class = $class;
        $this->grade = $grade;
        $this->school = $school;
    }

}