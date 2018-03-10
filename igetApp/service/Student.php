<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2018/2/11
 * Time: 20:41
 */

namespace iget\service;

use Medoo\Medoo;

interface Student{
    /** 获取我的个人信息
     * @param $stu_id
     * @param Medoo $database
     * @param array|string $maxexp
     * @return $studentpnObj 返回一个学生对象 需要有头像、姓名、班级、学校
     */
    public function getPersonal($stu_id, Medoo $database,$maxexp = MAXEXP);

    /** 获取我各个科目的分数
     * @param $stu_id
     * @param Medoo $database
     * @param array|string $maxexp
     * @return $scoreArray 返回分数数组 包含科目、等级、经验、金币
     */
    public function getSubjectScores($stu_id, Medoo $database,$maxexp = MAXEXP);
}