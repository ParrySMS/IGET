<?php
/**
 * Created by PhpStorm.
 * User: haier
 * Date: 2017-11-13
 * Time: 23:40
 */
namespace iget\service;
use Medoo\Medoo;

interface Member{
    // 获取班级
    public function getClasses($emp_num,$sch_id, Medoo $database);

    // 获取个人信息
    public function getPersonal($emp_num,$sch_id,Medoo $database);

    //获取所有徽章
    public function getAllBadges($emp_num,$sch_id,Medoo $database);
}