<?php
/**
 * Created by PhpStorm.
 * User: haier
 * Date: 2017-11-13
 * Time: 23:40
 */

namespace iget\service;

use Medoo\Medoo;

require_once "../service/Member.php";

interface Teacher extends Member
{

    /** 获取我教的班级
     * @param $emp_num
     * @param $sch_id
     * @param Medoo $database
     * @return $classList 返回一个班级对象数组 班级对象需要至少要有班级id和班级名称
     */
    public function getClasses($emp_num, $sch_id, Medoo $database);

    /** 获取我的个人信息
     * @param $emp_num
     * @param $sch_id
     * @param Medoo $database
     * @return $teacherpnObj 返回一个老师信息对象 需要有头像、名字、班级列表、学校//原本是$personalObj，修改为$teacherpnObj，理由是返回的是老师的信息
     */
    public function getPersonal($emp_num, $sch_id, Medoo $database);


    /** 获取我的徽章库
     * @param $emp_num
     * @param $sch_id
     * @param Medoo $database
     * @return $badges 返回一个徽章的对象数组
     */
    public function getBadges($emp_num, $sch_id, Medoo $database);

    /** 获取该校徽章库的所有徽章，原本是徽章库，修改为该校徽章库
     * @param $emp_num
     * @param $sch_id
     * @param Medoo $database
     * @return $badges 返回一个徽章的对象数组
     */
    public function getAllBadges($emp_num, $sch_id, Medoo $database);

    /** 颁发一个徽章给某同学
     * @param $emp_num
     * @param $stu_id
     * @param $sch_id
     * @param $badge_id
     * @param $message
     * @param Medoo $database
     * 报错使用 throw
     * @param string $maxexp
     * @return
     */
    public function awardOneBadge($emp_num, $stu_id, $sch_id, $badge_id, $message, Medoo $database,$maxexp = MAXEXP);//增加参数$badge_id,$message,$maxexp：颁发徽章的id,消息,升级所需的最大经验数组


    /**颁发徽章给某个小组
     * @param $emp_num
     * @param $group_num
     * @param $badge_id
     * @param $message
     * @param $sch_id
     * @param Medoo $database
     * 报错使用 throw
     * @param string $maxexp
     * @return
     */
    public function awardGroupBadge($emp_num, $group_num, $badge_id, $message, $sch_id, Medoo $database,$maxexp = MAXEXP);//增加参数$badge_id,$message,$maxexp：颁发徽章的id,消息,升级所需的最大经验数组

    /** 我的颁发历史
     * @param $emp_num
     * @param null $class_id
     * @param $who
     * @param $sch_id
     * @param Medoo $database
     * @return mixed 如果没有指定班级，以自己所有班级为单位返回我的颁发历史，如果指定了班级，则返回指定班级的颁发历史
     * 颁发历史的数据里有颁发记录的log_id
     */
    public function awardHistory($emp_num, $class_id = null, $who, $sch_id, Medoo $database);//增加参数$who:查看个人、小组或所有记录

    /**在指定时间内撤回某个徽章
     * @param $emp_num
     * @param $log_id //根据颁发记录id 在指定时间内进行撤回
     * @param $who
     * @param Medoo $database
     * @param int $recall_time 预定义常量 指定的有效时间 单位秒
     * @param string $maxexp
     * @return //报错使用 throw
     * 报错使用 throw
     */
    public function recallBadge($emp_num, $log_id, $who, Medoo $database, $recall_time = RECALLTIME,$maxexp = MAXEXP);

    /**获取我教的学生
     * @param $emp_num
     * @param null $class_id
     * @param $sch_id
     * @param Medoo $database
     * @param string $maxexp
     * @return $studentList 返回一个学生对象数组 学生对象至少要有学号，姓名，班级
     * 如果没有指定班级，以自己所有班级为单位返回所有学生，如果指定了班级，则返回指定班级的学生
     */
    public function getStudents($emp_num, $class_id = null, $sch_id, Medoo $database,$maxexp = MAXEXP);

    /**获取我教的班级的小组
     * @param $emp_num
     * @param $class_id
     * @param $sch_id
     * @param Medoo $database
     * @return $groupList 返回一个小组对象数组 小组对象至少要有组号，组名，班级
     */
    public function getGroups($emp_num, $class_id, $sch_id, Medoo $database);


    /**获取小组成员
     * @param $emp_num
     * @param $group_id
     * @param $sch_id
     * @param Medoo $database
     * @param string $maxexp
     * @return $studentList 返回一个学生对象数组 学生对象至少要有学号，姓名
     */
    public function getGroupMembers($emp_num, $group_id, $sch_id, Medoo $database,$maxexp = MAXEXP);

    /**随机获取一名学生
     * @param $emp_num
     * @param $class_id
     * @param $sch_id
     * @param Medoo $database
     * @param string $maxexp
     * @return $studentpnObj 返回一个学生对象 学生对象至少要有学号，姓名，班级
     */
    public function getOneStudent($emp_num, $class_id, $sch_id, Medoo $database,$maxexp = MAXEXP);

    /**创建组
     * @param $emp_num
     * @param $class_id
     * @param $group_name
     * @param $stu_ids //学生id数组
     * @param $sch_id
     * @param Medoo $database
     * @return $GroupObj 返回一个小组对象 小组对象至少要有组号，组名，班级，科目
     */
    public function createGroup($emp_num, $class_id, $group_name, $stu_ids, $sch_id, Medoo $database);

    /**增加或删除小组成员
     * @param $emp_num
     * @param $group_num
     * @param $new_stu_ids
     * @param Medoo $database
     * @return
     */
    public function editGroupMembers($emp_num, $group_num, $new_stu_ids, Medoo $database);

    /**删除组
     * @param $emp_num
     * @param $group_num
     * @param Medoo $database
     * @return
     */
    public function deleteGroup($emp_num, $group_num, Medoo $database);

    /**得到未加入小组的学生
     * @param $emp_num
     * @param $class_id
     * @param $sch_id
     * @param Medoo $database
     * @param string $maxexp
     * @return $studentList 返回一个学生对象数组 学生对象至少要有学号，姓名
     */
    public function getStuOfNoGroup($emp_num, $class_id, $sch_id, Medoo $database,$maxexp = MAXEXP);
}