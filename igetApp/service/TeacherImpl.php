<?php
/**
 * Created by PhpStorm.
 * User: haier
 * Date: 2017-11-13
 * Time: 23:40
 */

namespace iget\service;

use Medoo\Medoo;

interface teacher extends Member
{

    /** 获取我教的班级
     * @param $emp_num
     * @param $sch_id
     * @param Medoo $database
     * @return  $classList 返回一个班级对象数组 班级对象需要至少要有班级id和班级名称
     */
    public function getClasses($emp_num, $sch_id, Medoo $database);

    /** 获取我的个人信息
     * @param $emp_num
     * @param $sch_id
     * @param Medoo $database
     * @return  $personalObj 返回一个个人信息对象 需要有头像、名字、班级列表、学校
     */
    public function getPersonal($emp_num, $sch_id, Medoo $database);


    /** 获取我的徽章库
     * @param $emp_num
     * @param $sch_id
     * @param Medoo $database
     * @return  $badges 返回一个徽章的对象数组
     */
    public function getBadges($emp_num, $sch_id, Medoo $database);

    /** 获取该校徽章库的所有徽章，原本是徽章库，修改为该校徽章库
     * @param $emp_num
     * @param $sch_id
     * @param Medoo $database
     * @return  $badges 返回一个徽章的对象数组
     */
    public function getAllBadges($emp_num, $sch_id, Medoo $database);

    /** 颁发一个徽章给某同学
     * @param $emp_num
     * @param $stu_id
     * @param $badge_id
     * @param $message
     * @param $sch_id
     * @param Medoo $database
     * @param string $maxexp
     * 无返回 使用try catch
     * @return
     */
    public function awardOneBadge($emp_num, $stu_id, $badge_id, $message, $sch_id, Medoo $database,$maxexp = MAXEXP);//增加参数$badge_id,$message,$maxexp：颁发徽章的id,消息,升级所需的最大经验数组


    /**颁发徽章给某个小组
     * @param $emp_num
     * @param $group_num
     * @param $badge_id
     * @param $message
     * @param $sch_id
     * @param Medoo $database
     * 无返回 使用try catch
     * @param string $maxexp
     * @return
     */
    public function awardGroupBadge($emp_num, $group_num, $badge_id, $message, $sch_id, Medoo $database,$maxexp = MAXEXP);//增加参数$badge_id,$message,$maxexp：颁发徽章的id,消息,升级所需的最大经验数组


}