<?php

/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2018/2/11
 * Time: 20:45
 */

namespace iget\dao;

use Exception;
use iget\service\Student;
use iget\tpl\StudentPn;
use Medoo\Medoo;

require_once "../service/Student.php";

class StudentImpl implements Student
{
    private $database;
    private $status = 200;

    /**
     * StudentImpl constructor.
     * @param $database
     */
    public function __construct($database)
    {
        $this->database = $database;
    }

    /** 用于返回被调用后确认的状态码
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    public function getPersonal($stu_id, Medoo $database = null,$maxexp = MAXEXP)
    {
        // Implement getPersonal() method.
        $database = is_null($database) ? $this->database : $database;
        //基于stu_id查我的个人信息 连到班级表和分数表查班级和分数信息
        $data = $database->select("ig_student", [
            "[>]ig_single_character" => ["id" => "stu_id"],
            "[>]ig_group" => ["id" => "stu_id"],
            "[>]ig_group_character" => ["ig_group.group_num" => "group_num"],
            "[>]ig_class" => ["class_id" => "id"]
        ], [
            "ig_student.stu_num",
            "ig_student.name",
            "ig_student.icon",
            "ig_single_character.lv(single_lv)",
            "ig_single_character.exp(single_exp)",
            "ig_single_character.gp(single_gp)",
            "ig_group_character.exp(group_exp)",
            "ig_group_character.gp(group_gp)",
            "ig_class.class",
            "ig_class.year",
            "ig_class.school"
        ], [
            "AND" => [
                "ig_student.id" => $stu_id,
                "ig_student.visible" => 1,
                "ig_group.visible" => 1
            ]
        ]);
        if ($data === false || !is_array($data)) {
            throw new Exception("getPersonal error", 500);
        }
        if (empty($data)) {
            return false;//todo：该学生不存在，不知道返回值怎么写
        }

        $stu_num = $name = $icon = $single_lv = $single_exp = $single_gp = $group_exp = $group_gp = $class = $year = $school = null;
        extract($data[0]);//从数组中将变量导入到当前的符号表

        $grade = date("Y") - $year;
        $myclass = $grade . "年级" . $class . "班";

        //学生的分数=个人分数+小组分数
        $total_exp = $single_exp + $group_exp;
        $total_gp = $single_gp + $group_gp;
        $total_lv = 0;

        //计算等级
        $maxexp=json_decode($maxexp);
        foreach ($maxexp as $k => $m) {
            if ($total_exp <= $m) {
                $total_lv = $k;
                break;
            }
        }

        $studentpnObj = new StudentPn($name, $stu_num, $icon, $myclass, $school, $total_lv, $total_exp, $total_gp);
        return $studentpnObj;
    }

    public function getSubjectScores($stu_id, Medoo $database = null,$maxexp = MAXEXP)
    {
        // Implement getSubjectScores() method.
        $database = is_null($database) ? $this->database : $database;
        //基于stu_id查我个人的分数 连到科目表查科目
        $singleData = $database->select("ig_single_character", [
            "[>]ig_subject" => ["subject_id" => "id"]
        ], [
            "ig_single_character.subject_id",
            "ig_single_character.exp",
            "ig_single_character.gp",
            "ig_subject.subject"
        ], [
            "AND" => [
                "ig_single_character.stu_id" => $stu_id,
                "ig_single_character.visible" => 1,
                "ig_subject.visible" => 1
            ]
        ]);
        if ($singleData === false || !is_array($singleData)) {
            throw new Exception("getSubjectScores error", 500);
        }

        //基于stu_id查我小组的分数 连到科目表查科目
        $groupData = $database->select("ig_group", [
            "[>]ig_group_character" => ["group_num"],
            "[>]ig_subject" => ["subject_id" => "id"]
        ], [
            "ig_group.subject_id",
            "ig_group_character.exp",
            "ig_group_character.gp",
            "ig_subject.subject"
        ], [
            "AND" => [
                "ig_group.stu_id" => $stu_id,
                "ig_group.visible" => 1,
                "ig_group_character.visible" => 1,
                "ig_subject.visible" => 1
            ]
        ]);
        if ($groupData === false || !is_array($groupData)) {
            throw new Exception("getSubjectScores error", 500);
        }

        $scoreArray=array_merge($singleData, $groupData);//array_merge把两个数组合并为一个数组

        //合并二维数组内指定的相同键(subject_id)并计算另一键(exp,gp)的和后组成新的二维数组
        $tmp = [];
        $maxexp=json_decode($maxexp);
        foreach ($scoreArray as $v) {
            if(!isset($tmp[$v['subject_id']])){
                $tmp[$v['subject_id']]['exp'] = $v['exp'];
                $tmp[$v['subject_id']]['gp'] = $v['gp'];
            }else{
                $tmp[$v['subject_id']]['exp'] += $v['exp'];
                $tmp[$v['subject_id']]['gp'] += $v['gp'];
            }

            //计算等级
            foreach ($maxexp as $k => $m) {
                if ($tmp[$v['subject_id']]['exp'] <= $m) {
                    $tmp[$v['subject_id']]['lv'] = $k;
                    break;
                }
            }

            $tmp[$v['subject_id']]['subject_id'] = $v['subject_id'];
            $tmp[$v['subject_id']]['subject'] = $v['subject'];
        }
        $scoreArray = array_values($tmp);//array_values() 函数返回一个包含给定数组中所有键值的数组，但不保留键名
        return $scoreArray;
    }
}