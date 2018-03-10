<?php
/**
 * Created by PhpStorm.
 * User: haier
 * Date: 2017-11-21
 * Time: 16:09
 */

namespace iget\dao;

use iget\service\Teacher;
use iget\tpl\ClassObj;
use iget\tpl\StudentPn;
use iget\tpl\TeacherPn;
use iget\tpl\GroupObj;
use Medoo\Medoo;
use Exception;

require_once "../service/Teacher.php";
require_once "../tpl/ClassObj.php";
require_once "../tpl/TeacherPn.php";
require_once "../tpl/StudentPn.php";
require_once "../tpl/GroupObj.php";

class TeacherImpl implements Teacher
{
    private $database;
    private $status = 200;

    /**
     * TeacherImpl constructor.
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

    /** 获取我教的班级
     * @param $emp_num
     * @param $sch_id
     * @param Medoo $database
     * @param string $table
     * @return array $classList 返回一个班级对象数组 班级对象需要至少要有班级id和班级名称
     * @throws Exception
     */
    public function getClasses($emp_num, $sch_id, Medoo $database = null, $table = "ig_class")//增加sch_id参数：防止不同学校老师的工号相同
    {
        $database = is_null($database) ? $this->database : $database;
        //查medoo文档 连表 基于emp_num和sch_id查我的班级id 连到我的班级表查班级信息
        $data = $database->select($table, [
            "[>]ig_teacher" => ["id" => "class_id"],
        ], [
            "$table.id",
            "$table.class",
            "$table.year",
            "$table.school"
        ], [
            "AND" => [
                "ig_teacher.emp_num" => $emp_num,
                "ig_teacher.sch_id" => $sch_id,
                "ig_teacher.visible" => 1,
                "$table.visible" => 1
            ]
        ]);
        if ($data === false || !is_array($data)) {//填写报错条件
            throw new Exception("getClasses error", 500);//填写错误信息与错误码
        }

        //如果还有其他报错情况 则同上 L46-L48 继续填写

        //中途如果需要调试 可以将变量直接使用 var_dump()显示出来 通过同目录下的test.php进行测试
        unset($classList);//数组初始化
        $classList = array();
        //此处进行 数据的封装 把$data的数据 通过构造函数塞到对象里，放进$classList对象数组
        foreach ($data as $d) {
            $id = $d['id'];
            $class = $d['class'];
            $grade = date("Y") - $d['year'];
            $school = $d['school'];
            $classObj = new ClassObj($id, $class, $grade, $school);
            $classList[] = $classObj;
        }
        return $classList;
    }

    public function getPersonal($emp_num, $sch_id, Medoo $database = null)//$database参数加了默认值
    {
        // Implement getPersonal() method.
        $database = is_null($database) ? $this->database : $database;
        //基于emp_num和sch_id查我的个人信息 连到班级表和科目表查班级和科目信息
        $data = $database->select("ig_teacher", [
            "[>]ig_class" => ["class_id" => "id"],
            "[>]ig_subject" => ["subject_id" => "id"],
        ], [
            "ig_teacher.avatar",
            "ig_teacher.name",
            "ig_class.class",
            "ig_class.year",
            "ig_class.school",
            "ig_subject.subject"
        ], [
            "AND" => [
                "ig_teacher.emp_num" => $emp_num,
                "ig_teacher.sch_id" => $sch_id,
                "ig_teacher.visible" => 1,
                "ig_class.visible" => 1,
                "ig_subject.visible" => 1
            ]

        ]);
        if ($data === false || !is_array($data)) {
            throw new Exception("getPersonal error", 500);
        }
        if (empty($data)) {
            return false;//todo：该老师不存在，不知道返回值怎么写
        }
        //把$data的数据 通过构造函数塞到对象里
        $avatar = $data[0]['avatar'];
        $name = $data[0]['name'];
        $school = $data[0]['school'];
        $subject = $data[0]['subject'];

        $myclass = [];
        foreach ($data as $d) {
            $grade = date("Y") - $d['year'];
            $myclass[] = $grade . "年级" . $d['class'] . "班";
        }
        $teacherpnObj = new TeacherPn($name, $emp_num, $avatar, $myclass, $subject, $school);
        return $teacherpnObj;
    }

    public function getBadges($emp_num, $sch_id, Medoo $database = null)
    {
        // Implement getBadges() method.
        $database = is_null($database) ? $this->database : $database;
        //基于emp_num和sch_id查我的徽章仓库编号
        $teaData = $database->select("ig_teacher", ["bs_num"], ["AND" => ["emp_num" => $emp_num, "sch_id" => $sch_id, "visible" => 1]]);
        if (empty($teaData)) {
            return false;//todo：该老师不存在，不知道返回值怎么写
        }
        $bs_num = $teaData[0]['bs_num'];

        //基于我的徽章仓库id查徽章id 连到校徽章库表查我仓库所有徽章的信息
        $data = $database->select("ig_sch_badge", [
            "[>]ig_badge_storage" => ["id" => "schbadge_id"],
        ], [
            "ig_sch_badge.name",
            "ig_sch_badge.type",
            "ig_sch_badge.intro",
            "ig_sch_badge.pic",
            "ig_sch_badge.exp",
            "ig_sch_badge.gp"
        ], [
            "AND" => [
                "ig_badge_storage.bs_num" => $bs_num,
                "ig_badge_storage.visible" => 1,
                "ig_sch_badge.visible" => 1
            ]
        ]);

        if ($data === false || !is_array($data)) {
            throw new Exception("getBadges error", 500);
        }
        return $data;
    }

    public function getAllBadges($emp_num, $sch_id, Medoo $database = null)
    {
        // Implement getAllBadges() method.
        $database = is_null($database) ? $this->database : $database;

        //基于我的学校id 查校徽章库的所有徽章信息
        $badgeData = $database->select("ig_sch_badge", ["name", "type", "intro", "pic", "exp", "gp"], ["AND" => ["sch_id" => $sch_id, "visible" => 1]]);
        if ($badgeData === false || !is_array($badgeData)) {
            throw new Exception("getAllBadges error", 500);
        }
        return $badgeData;
    }

    /**
     * @param $emp_num
     * @param $stu_id
     * @param $badge_id
     * @param $message
     * @param $sch_id
     * @param Medoo $database
     * @param string $maxexp
     * @return bool
     * @throws Exception
     */
    public function awardOneBadge($emp_num, $stu_id, $badge_id, $message = null, $sch_id, Medoo $database = null,$maxexp = MAXEXP)//增加参数$badge_id,$message,$maxexp：颁发徽章的id,消息,升级所需的最大经验数组
    {
        // Implement awardOneBadge() method.
        $database = is_null($database) ? $this->database : $database;

        //基于emp_num和sch_id查我的信息
        $myData = $database->select("ig_teacher",
            ["[>]ig_subject" => ["subject_id" => "id"]],
            ["ig_teacher.name", "ig_teacher.subject_id", "ig_subject.subject"],
            ["AND" => ["ig_teacher.emp_num" => $emp_num, "ig_teacher.sch_id" => $sch_id, "ig_teacher.visible" => 1]]
        );
        if ($myData === false || !is_array($myData)) {
            throw new Exception("awardOneBadge error", 500);
        }
        if (empty($myData)) {
            return false;//todo：该老师不存在，不知道返回值怎么写
        }
        $awarder_name = $myData[0]['name'];
        $subject_id = $myData[0]['subject_id'];
        $subject = $myData[0]['subject'];

        //基于stu_id查学生的信息 连到班级表查学生的班级信息
        $stuData = $database->select("ig_student", [
            "[>]ig_class" => ["class_id" => "id"]
        ], [
            "ig_student.name(stu_name)", "ig_class.class", "ig_class.year", "ig_class.id(class_id)"
        ], [
            "AND" => ["ig_student.id" => $stu_id, "ig_student.sch_id" => $sch_id, "ig_student.visible" => 1]
        ]);
        if ($stuData === false || !is_array($stuData)) {
            throw new Exception("awardOneBadge error", 500);
        }
        if (empty($stuData)) {
            return false;//todo：该学生不存在，不知道返回值怎么写
        }
        $stu_name = $class = $year = $class_id = null;
        extract($stuData[0]);//从数组中将变量导入到当前的符号表
        $grade = date("Y") - $year;

        //基于stu_id和subject_id查ig_single_character表是否有该学生该科目的记录
        $singleData = $database->select("ig_single_character", [
            "id(single_character_id)", "lv(stu_lv)", "exp(stu_exp)", "gp(stu_gp)"
        ], [
            "AND" => ["stu_id" => $stu_id, "subject_id" => $subject_id, "visible" => 1]
        ]);

        $single_character_id = $stu_lv = $stu_exp = $stu_gp = 0;
        if (empty($singleData)) {
            try {
                //往ig_single_character表插入一条该学生该科目的记录
                $query = $database->insert("ig_single_character", ["stu_id" => $stu_id, "class_id" => $class_id, "subject_id" => $subject_id, "lv" => 0, "exp" => 0, "gp" => 0]);
            } catch (Exception $e) {
                throw($e);
            }
            if ($query->rowCount() != 1) {
                return false;//todo:往ig_single_character表插入记录失败，不知道返回值怎么写
            }
            $single_character_id = $database->id();//返回最后插入的行ID
        } else {
            //ig_single_character表存在该学生该科目的记录
            extract($singleData[0]);//得到$single_character_id,$stu_lv,$stu_exp,$stu_gp
        }

        //基于badge_id查徽章的经验和金币点数
        $badgeData = $database->select("ig_sch_badge", ["exp", "gp"], ["AND" => ["id" => $badge_id, "visible" => 1]]);
        if ($badgeData === false || !is_array($badgeData)) {
            throw new Exception("awardOneBadge error", 500);
        }
        if (empty($badgeData)) {
            return false;//todo：该徽章不存在，不知道返回值怎么写
        }
        $badge_exp = $badgeData[0]['exp'];
        $badge_gp = $badgeData[0]['gp'];

        //增加学生的经验和金币点数，计算等级
        $stu_exp += $badge_exp;
        $stu_gp += $badge_gp;
        foreach ($maxexp as $k => $v) {
            if ($stu_exp <= $v) {
                $stu_lv = $k;
                break;
            }
        }

        try {
            date_default_timezone_set("Asia/Shanghai");
            $time = date("Y-m-d H:i:s");
            //往ig_log_single_badge表插入一条给学生颁发徽章的记录
            $query1 = $database->insert("ig_log_single_badge", [
                "time" => $time,
                "awarder_num" => $emp_num,
                "awarder_name" => $awarder_name,
                "stu_id" => $stu_id,
                "stu_name" => $stu_name,
                "subject" => $subject,
                "schbadge_id" => $badge_id,
                "message" => $message,
                "class" => $class,
                "grade" => $grade,
                "class_id" => $class_id,
                "sch_id" => $sch_id
            ]);
            if ($query1->rowCount() != 1) {
                return false;//todo:往ig_log_single_badge表插入记录失败，不知道返回值怎么写
            }
            $log_single_badge_id = $database->id();//返回最后插入的行ID

            //基于single_character_id修改ig_single_character表该学生该科目的等级，经验，金币点数
            $query2 = $database->update("ig_single_character", ["lv" => $stu_lv, "exp" => $stu_exp, "gp" => $stu_gp], ["id" => $single_character_id]);

            if ($query2->rowCount() != 1) {
                //撤销刚刚往ig_log_single_badge表插入的记录
                $database->update("ig_log_single_badge", ["visible" => 0], ["id" => $log_single_badge_id]);
                return false;//todo:修改ig_single_character表记录失败，不知道返回值怎么写
            }

        } catch (Exception $e) {
            throw $e;
        }
        return true;//todo:颁发成功，不知道返回值怎么写
    }

    public function awardGroupBadge($emp_num, $group_num, $badge_id, $message = null, $sch_id, Medoo $database = null,$maxexp = MAXEXP)//增加参数$badge_id,$message：颁发徽章的id,消息,升级所需的最大经验数组
    {
        // Implement awardGroupBadge() method.
        $database = is_null($database) ? $this->database : $database;

        //基于emp_id查我的信息 连到科目表查我的科目
        $myData = $database->select("ig_teacher", [
            "[>]ig_subject" => ["subject_id" => "id"]
        ], [
            "ig_teacher.name",
            "ig_teacher.subject_id",
            "ig_subject.subject"
        ], [
            "AND" => ["ig_teacher.emp_num" => $emp_num, "ig_teacher.sch_id" => $sch_id, "ig_teacher.visible" => 1]
        ]);
        if ($myData === false || !is_array($myData)) {
            throw new Exception("awardGroupBadge error", 500);
        }
        if (empty($myData)) {
            return false;//todo:该老师不存在，不知道返回值怎么写
        }
        $awarder_name = $myData[0]['name'];
        $subject_id = $myData[0]['subject_id'];
        $subject = $myData[0]['subject'];

        //基于group_num查小组信息 连到班级表查班级信息
        $groupData = $database->select("ig_group", [
            "[>]ig_class" => ["class_id" => "id"]
        ], [
            "ig_group.name(group_name)",
            "ig_class.class",
            "ig_class.year",
            "ig_class.id(class_id)"
        ], [
            "AND" => ["ig_group.group_num" => $group_num, "ig_group.visible" => 1]
        ]);
        if ($groupData === false || !is_array($groupData)) {
            throw new Exception("awardGroupBadge error", 500);
        }
        if (empty($groupData)) {
            return false;//todo:该小组不存在，不知道返回值怎么写
        }
        $group_name = $class = $year = $class_id = null;
        extract($groupData[0]);//从数组中将变量导入到当前的符号表
        $grade = date("Y") - $year;

        //基于group_num查ig_group_character表是否有该小组的分数记录
        $groupData = $database->select("ig_group_character", [
            "id(group_character_id)", "lv(group_lv)", "exp(group_exp)", "gp(group_gp)"
        ], [
            "AND" => ["group_num" => $group_num, "visible" => 1]
        ]);

        $group_character_id = $group_lv = $group_exp = $group_gp = 0;
        if (empty($groupData)) {
            try {
                //往ig_group_character表插入一条该小组的记录
                $query = $database->insert("ig_group_character", ["group_num" => $group_num, "class_id" => $class_id, "subject_id" => $subject_id, "lv" => 0, "exp" => 0, "gp" => 0]);
            } catch (Exception $e) {
                throw($e);
            }
            if ($query->rowCount() != 1) {
                return false;//todo:往ig_group_character表插入记录失败，不知道返回值怎么写
            }
            $group_character_id = $database->id();//返回最后插入的行ID
        } else {
            //ig_group_character表存在该小组的分数记录
            extract($groupData[0]);//得到$group_character_id,$group_lv,$group_exp,$group_gp
        }

        //基于badge_id查徽章的经验和金币点数
        $badgeData = $database->select("ig_sch_badge", ["exp", "gp"], ["AND" => ["id" => $badge_id, "visible" => 1]]);
        if ($badgeData === false || !is_array($badgeData)) {
            throw new Exception("awardGroupBadge error", 500);
        }
        if (empty($badgeData)) {
            return false;//todo:该徽章不存在，不知道返回值怎么写
        }
        $badge_exp = $badgeData[0]['exp'];
        $badge_gp = $badgeData[0]['gp'];

        //增加小组的经验和金币点数，计算等级
        $group_exp += $badge_exp;
        $group_gp += $badge_gp;
        $maxexp=json_decode($maxexp);
        foreach ($maxexp as $k => $m) {
            if ($group_exp <= $m) {
                $group_lv = $k;
                break;
            }
        }

        try {
            date_default_timezone_set("Asia/Shanghai");
            $time = date("Y-m-d H:i:s");
            //往ig_log_group_badge表插入一条给小组颁发徽章的记录
            $query1 = $database->insert("ig_log_group_badge", [
                "time" => $time,
                "awarder_num" => $emp_num,
                "awarder_name" => $awarder_name,
                "group_num" => $group_num,
                "group_name" => $group_name,
                "subject" => $subject,
                "schbadge_id" => $badge_id,
                "message" => $message,
                "class" => $class,
                "grade" => $grade,
                "class_id" => $class_id,
                "sch_id" => $sch_id
            ]);
            if ($query1->rowCount() != 1) {
                return false;//todo:往ig_group_character表插入记录失败，不知道返回值怎么写
            }
            $log_group_badge_id = $database->id();//返回最后插入的行ID

            //基于group_character_id修改ig_group_character表小组的等级，经验和金币点数
            $query2 = $database->update("ig_group_character", ["lv" => $group_lv, "exp" => $group_exp, "gp" => $group_gp], ["id" => $group_character_id]);

            if ($query2->rowCount() != 1) {
                //撤销刚刚往ig_log_single_badge表插入的记录
                $database->update("ig_log_group_badge", ["visible" => 0], ["id" => $log_group_badge_id]);
                return false;//todo:修改ig_group_character表记录失败，不知道返回值怎么写
            }

        } catch (Exception $e) {
            throw $e;
        }
        return true;//todo:颁发成功，不知道返回值怎么写
    }

    public function awardHistory($emp_num, $class_id = null, $who = "all", $sch_id, Medoo $database = null)//增加参数$who:查看个人、小组或所有记录
    {
        // Implement awardHistory() method.
        $database = is_null($database) ? $this->database : $database;

        //获取我给个人或小组颁发徽章的记录
        function getBadgeRecord($emp_num, $class_id, $who, $sch_id, Medoo $database)
        {
            $table = null;
            $fieldname = null;
            if ($who == "single") {
                $table = "ig_log_single_badge";//表名
                $fieldname = [
                    "$table.time",
                    "$table.awarder_num",
                    "$table.awarder_name",
                    "$table.stu_num",
                    "$table.stu_name",
                    "$table.subject",
                    "$table.message",
                    "$table.class",
                    "$table.grade",
                    "ig_sch_badge.name(badge_name)",
                    "ig_sch_badge.type(badge_type)",
                    "ig_sch_badge.pic(badge_pic)",
                    "ig_sch_badge.exp(badge_exp)",
                    "ig_sch_badge.gp(badge_gp)"
                ];//字段名
            } elseif ($who == "group") {
                $table = "ig_log_group_badge";
                $fieldname = [
                    "$table.time",
                    "$table.awarder_num",
                    "$table.awarder_name",
                    "$table.group_num",
                    "$table.group_name",
                    "$table.subject",
                    "$table.message",
                    "$table.class",
                    "$table.grade",
                    "ig_sch_badge.name(badge_name)",
                    "ig_sch_badge.type(badge_type)",
                    "ig_sch_badge.pic(badge_pic)",
                    "ig_sch_badge.exp(badge_exp)",
                    "ig_sch_badge.gp(badge_gp)"
                ];
            }

            //基于emp_id和sch_id查我颁发徽章的记录
            if (empty($class_id)) {
                $data = $database->select($table, [
                    "[>]ig_sch_badge" => ["schbadge_id" => "id"]
                ], $fieldname, [
                    "AND" => [
                        "$table.awarder_num" => $emp_num,
                        "$table.sch_id" => $sch_id,
                        "$table.visible" => 1
                    ],
                    "ORDER" => ["$table.time" => "DESC"]
                ]);
            } else {
                $data = $database->select($table, [
                    "[>]ig_sch_badge" => ["schbadge_id" => "id"]
                ], $fieldname, [
                    "AND" => [
                        "$table.awarder_num" => $emp_num,
                        "$table.sch_id" => $sch_id,
                        "$table.class_id" => $class_id,//返回指定班级的颁发历史
                        "$table.visible" => 1
                    ],
                    "ORDER" => ["$table.time" => "DESC"]
                ]);
            }
            if ($data === false || !is_array($data)) {
                throw new Exception("awardHistory error", 500);
            }
            return $data;
        }

        unset($record);
        $record = array();
        if ($who == "all") {
            $singlerecord = getBadgeRecord($emp_num, $class_id, "single", 1, $database);
            $grouprecord = getBadgeRecord($emp_num, $class_id, "group", 1, $database);
            $record = array_merge($singlerecord, $grouprecord);//array_merge把两个数组合并为一个数组

            $time = array_column($record, 'time');//返回数组中的time列
            array_multisort($time, SORT_DESC, $record);//record二维数组按照time降序排列
        } elseif ($who == "single" or $who == "group") {
            $record = getBadgeRecord($emp_num, $class_id, $who, 1, $database);
        }
        return $record;
    }

    public function recallBadge($emp_num, $log_id, $who = "single", Medoo $database = null, $recall_time = RECALLTIME,$maxexp = MAXEXP)//增加参数$who,$maxexp:撤销个人或小组的徽章记录,升级所需的最大经验数组
    {
        // Implement recallBadge() method.
        $database = is_null($database) ? $this->database : $database;
        $log_table = $character_table = $fieldname = null;
        if ($who == "single") {
            $log_table = "ig_log_single_badge";
            $character_table = "ig_single_character";
            $fieldname = "stu_id";
        } elseif ($who == "group") {
            $log_table = "ig_log_group_badge";
            $character_table = "ig_group_character";
            $fieldname = "group_num";
        }

        //基于log_id查我颁发徽章的时间,学号或组号,徽章id
        //连到ig_single_character表或ig_group_character表查等级,经验和金币点数
        //连到ig_sch_badge表查徽章的经验和金币点数
        $data = $database->select($log_table, [
            "[>]$character_table" => $fieldname,
            "[>]ig_sch_badge" => ["schbadge_id" => "id"],
        ], [
            "$log_table.time(awardtime)",
            "$log_table.$fieldname(character_id)",
            "$log_table.schbadge_id(badge_id)",
            "$character_table.lv(character_lv)",
            "$character_table.exp(character_exp)",
            "$character_table.gp(character_gp)",
            "ig_sch_badge.exp(badge_exp)",
            "ig_sch_badge.gp(badge_gp)"
        ], [
            "AND" => ["$log_table.id" => $log_id, "$log_table.visible" => 1]
        ]);
        if ($data === false || !is_array($data)) {
            throw new Exception("recallBadge error", 500);
        }
        if (empty($data)) {
            return false;//todo：不存在该徽章记录，不知道返回值怎么写
        }

        $awardtime = $character_id = $badge_id = $character_lv = $character_exp = $character_gp = $badge_exp =
        $badge_gp = null;
        extract($data[0]);//从数组中将变量导入到当前的符号表

        date_default_timezone_set("Asia/Shanghai");
        $currenttime = date("Y-m-d H:i:s");//获取当前时间
        //计算当前时间和颁发时间的时间差
        $timelag = strtotime($currenttime) - strtotime($awardtime);
        if ($timelag > $recall_time) {
            return false;//todo：超过了指定时间，不允许撤销，不知道返回值怎么写
        }

        //减少个人或小组的经验和金币点数，计算等级
        $character_exp -= $badge_exp;
        $character_gp -= $badge_gp;
        $maxexp=json_decode($maxexp);
        foreach ($maxexp as $k => $m) {
            if ($character_exp <= $m) {
                $character_lv = $k;
                break;
            }
        }

        try {
            //基于log_id修改ig_log_single_badge表或ig_log_group_badge表的记录是否可见
            $query1 = $database->update($log_table, ["visible" => 0], ["id" => $log_id]);
            if ($query1->rowCount() != 1) {
                return false;//todo:修改ig_log_single_badge表或ig_log_group_badge表的记录失败，不知道返回值怎么写
            }

            //基于学号或组号修改ig_single_character表或ig_group_character表的等级，经验和金币点数
            $query2 = $database->update($character_table, [
                "lv" => $character_lv, "exp" => $character_exp, "gp" => $character_gp
            ], [
                $fieldname => $character_id
            ]);
            if ($query2->rowCount() != 1) {
                //撤销刚刚修改表的记录
                $database->update($log_table, ["visible" => 1], ["id" => $log_id]);
                return false;//todo:修改ig_single_character表或ig_group_character表的记录失败，不知道返回值怎么写
            }
        } catch (Exception $e) {
            throw $e;
        }
        return true;//撤销成功，不知道返回值怎么写
    }

    public function getStudents($emp_num, $class_id = null, $sch_id, Medoo $database = null,$maxexp = MAXEXP)
    {
        // Implement getStudents() method.
        $database = is_null($database) ? $this->database : $database;
        if (empty($class_id)) {
            //基于emp_num和sch_id查班级id 多表联合查学生信息
            $data = $database->select("ig_student", [
                "[>]ig_teacher" => "class_id",
                "[>]ig_single_character" => ["ig_teacher.subject_id" => "subject_id", "id" => "stu_id"],
                "[>]ig_group" => ["id" => "stu_id"],
                "[>]ig_group_character" => ["ig_teacher.subject_id" => "subject_id", "ig_group.group_num" => "group_num"],
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
                "ig_class.year"
            ], [
                "AND" => [
                    "ig_teacher.emp_num" => $emp_num,
                    "ig_teacher.sch_id" => $sch_id,
                    "ig_teacher.visible" => 1,
                    "ig_student.visible" => 1,
                    "ig_group.visible" => 1
                ]
            ]);

        } else {
            //基于class_id查学生基本信息 多表联合查学生的分数和班级信息
            $data = $database->select("ig_student", [
                "[>]ig_teacher" => "class_id",
                "[>]ig_single_character" => ["ig_teacher.subject_id" => "subject_id", "id" => "stu_id"],
                "[>]ig_group" => ["id" => "stu_id"],
                "[>]ig_group_character" => ["ig_teacher.subject_id" => "subject_id", "ig_group.group_num" => "group_num"],
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
                "ig_class.year"
            ], [
                "AND" => [
                    "ig_student.class_id" => $class_id,
                    "ig_student.visible" => 1,
                    "ig_teacher.emp_num" => $emp_num,
                    "ig_teacher.sch_id" => $sch_id,
                    "ig_teacher.visible" => 1,
                    "ig_group.visible" => 1
                ]
            ]);
        }
        if ($data === false || !is_array($data)) {
            throw new Exception("getStudents error", 500);
        }

        unset($studentList);
        $studentList = array();
        //把$data的数据 通过构造函数塞到对象里，放进$studentList对象数组
        foreach ($data as $d) {
            $stu_num = $name = $icon = $single_lv = $single_exp = $single_gp = $group_exp = $group_gp = $class = $year = null;
            extract($d);//从数组中将变量导入到当前的符号表

            //学生该科目的分数=该科目的个人分数+小组分数
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

            $grade = date("Y") - $year;
            $myclass = $grade . "年级" . $class . "班";
            $studentpnObj = new StudentPn($name, $stu_num, $icon, $myclass, $sch_id, $total_lv, $total_exp, $total_gp);
            $studentList[] = $studentpnObj;
        }
        return $studentList;
    }

    public function getGroups($emp_num, $class_id, $sch_id, Medoo $database = null)
    {
        // Implement getGroups() method.
        $database = is_null($database) ? $this->database : $database;
        //基于emp_num和sch_id查我的科目id 连到ig_group表和ig_group_character查小组的具体信息
        $data = $database->select("ig_group", [
            "[>]ig_teacher" => "subject_id",
            "[>]ig_group_character" => "group_num"
        ], [
            "ig_group.group_num",
            "ig_group.name",
            "ig_group.subject_id",
            "ig_group_character.lv",
            "ig_group_character.exp",
            "ig_group_character.gp"
        ], [
            "AND" => [
                "ig_teacher.emp_num" => $emp_num,
                "ig_teacher.sch_id" => $sch_id,
                "ig_teacher.visible" => 1,
                "ig_group.class_id" => $class_id,
                "ig_group.visible" => 1
            ],
            "GROUP" => "ig_group.group_num"
        ]);
        if ($data === false || !is_array($data)) {
            throw new Exception("getGroups error", 500);
        }

        unset($groupList);
        $groupList = array();
        //把$data的数据 通过构造函数塞到对象里，放进$groupList对象数组
        foreach ($data as $d) {
            $group_num = $name = $subject_id = $lv = $exp = $gp = null;
            extract($d);//从数组中将变量导入到当前的符号表
            if (empty($lv)) {//ig_group_character表没有该小组的记录
                $lv = $exp = $gp = 0;
            }
            $groupObj = new GroupObj($group_num, $name, $class_id, $subject_id, $lv, $exp, $gp);
            $groupList[] = $groupObj;
        }
        return $groupList;
    }

    public function getGroupMembers($emp_num, $group_num, $sch_id, Medoo $database = null,$maxexp = MAXEXP)
    {
        // Implement getGroupMembers() method.
        $database = is_null($database) ? $this->database : $database;
        //基于group_num查学生学号 多表联合查学生的具体信息
        $data = $database->select("ig_student", [
            "[>]ig_teacher" => "class_id",
            "[>]ig_single_character" => ["ig_teacher.subject_id" => "subject_id", "id" => "stu_id"],
            "[>]ig_group" => ["ig_teacher.subject_id" => "subject_id", "id" => "stu_id"],
            "[>]ig_group_character" => ["ig_group.group_num" => "group_num"]
        ], [
            "ig_student.stu_num",
            "ig_student.name",
            "ig_student.icon",
            "ig_student.class_id",
            "ig_single_character.lv(single_lv)",
            "ig_single_character.exp(single_exp)",
            "ig_single_character.gp(single_gp)",
            "ig_group_character.exp(group_exp)",
            "ig_group_character.gp(group_gp)"
        ], [
            "AND" => [
                "ig_group.group_num" => $group_num,
                "ig_group.visible" => 1,
                "ig_teacher.emp_num" => $emp_num,
                "ig_teacher.sch_id" => $sch_id,
                "ig_teacher.visible" => 1,
                "ig_student.visible" => 1
            ]
        ]);
        if ($data === false || !is_array($data)) {
            throw new Exception("getGroupMembers error", 500);
        }

        unset($studentList);
        $studentList = array();
        //把$data的数据 通过构造函数塞到对象里，放进$studentList对象数组
        foreach ($data as $d) {
            $stu_num = $name = $icon = $class_id = $single_lv = $single_exp = $single_gp = $group_exp = $group_gp = null;
            extract($d);//从数组中将变量导入到当前的符号表

            //学生该科目的分数=该科目的个人分数+小组分数
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

            $studentpnObj = new StudentPn($name, $stu_num, $icon, $class_id, $sch_id, $total_lv, $total_exp, $total_gp);
            $studentList[] = $studentpnObj;
        }
        return $studentList;
    }

    public function getOneStudent($emp_num, $class_id, $sch_id, Medoo $database = null,$maxexp = MAXEXP)
    {
        // Implement getOneStudent() method.
        $database = is_null($database) ? $this->database : $database;
        $rowCount = $database->count("ig_student");//获取ig_student表的行数

        //确保该班级存在，并且有学生，避免死循环
        if (!$database->has("ig_student", ["AND" => ["class_id" => $class_id, "visible" => 1]])) {
            return false;//todo：该班级没有学生，不知道返回值怎么写
        }

        //确保该老师存在并且教该班级，避免死循环
        if (!$database->has("ig_teacher", ["AND" => ["emp_num" => $emp_num, "class_id" => $class_id, "sch_id" => $sch_id, "visible" => 1]])) {
            return false;//todo：老师不存在或不教该班级，不知道返回值怎么写
        }

        while (empty($data)) {
            $randomId = rand(1, $rowCount);//产生随机id
            //基于id和class_id查学生的基本信息 多表联合查学生的分数信息
            $data = $database->select("ig_student", [
                "[>]ig_teacher" => "class_id",
                "[>]ig_single_character" => ["ig_teacher.subject_id" => "subject_id", "id" => "stu_id"],
                "[>]ig_group" => ["id" => "stu_id"],
                "[>]ig_group_character" => ["ig_teacher.subject_id" => "subject_id", "ig_group.group_num" => "group_num"]
            ], [
                "ig_student.stu_num",
                "ig_student.name",
                "ig_student.icon",
                "ig_student.class_id",
                "ig_single_character.lv(single_lv)",
                "ig_single_character.exp(single_exp)",
                "ig_single_character.gp(single_gp)",
                "ig_group_character.exp(group_exp)",
                "ig_group_character.gp(group_gp)"
            ], [
                "AND" => [
                    "ig_student.id" => $randomId,
                    "ig_student.class_id" => $class_id,
                    "ig_student.visible" => 1,
                    "ig_teacher.emp_num" => $emp_num,
                    "ig_teacher.sch_id" => $sch_id,
                    "ig_teacher.visible" => 1,
                    "ig_group.visible" => 1
                ]
            ]);
        }
        if ($data === false || !is_array($data)) {
            throw new Exception("getOneStudent error", 500);
        }

        $stu_num = $name = $icon = $class_id = $single_lv = $single_exp = $single_gp = $group_exp = $group_gp = null;
        extract($data[0]);//从数组中将变量导入到当前的符号表

        //学生该科目的分数=该科目的个人分数+小组分数
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

        $studentpnObj = new StudentPn($name, $stu_num, $icon, $class_id, $sch_id, $total_lv, $total_exp, $total_gp);
        return $studentpnObj;
    }

    public function createGroup($emp_num, $class_id, $group_name, $stu_ids, $sch_id, Medoo $database = null)
    {
        // Implement createGroup() method.
        $database = is_null($database) ? $this->database : $database;

        //查ig_group表group_num的最大值
        $max = $database->max("ig_group", "group_num");
        $group_num = $max + 1;//新创建组的group_num

        //基于emp_num和sch_id查ig_teacher表我的科目id
        $data = $database->select("ig_teacher", "subject_id", ["AND" => ["emp_num" => $emp_num, "sch_id" => $sch_id, "visible" => 1], "LIMIT" => 1]);
        if ($data === false || !is_array($data)) {
            throw new Exception("createGroup error", 500);
        }
        if (empty($data)) {
            return false;//todo:该老师不存在，不知道返回值怎么写
        }
        $subject_id = $data[0];

        unset($querys);
        $querys = array();
        unset($ids);
        $ids = array();
        try {
            //往ig_group表插入小组信息，有多少个成员就插多少条记录
            foreach ($stu_ids as $s) {
                $querys[] = $database->insert("ig_group", [
                    "group_num" => $group_num,
                    "name" => $group_name,
                    "stu_id" => $s,
                    "class_id" => $class_id,
                    "subject_id" => $subject_id
                ]);
                $ids[] = $database->id();
            }
        } catch (Exception $e) {
            throw $e;
        }

        foreach ($querys as $q) {
            if ($q->rowCount() != 1) {//如果影响的行数不等于1
                //撤销刚刚插入的所有记录
                foreach ($ids as $i) {
                    $database->update("ig_group", ["visible" => 0], ["id" => $i]);
                }
                return false;//todo:创建组失败，不知道返回值怎么写
            }
        }
        //创建小组成功,返回小组对象
        $GroupObj = new GroupObj($group_num, $group_name, $class_id, $subject_id, 0, 0, 0);
        return $GroupObj;
    }

    public function editGroupMembers($emp_num, $group_num, $new_stu_ids, Medoo $database = null)
    {
        // Implement editGroup() method.
        $database = is_null($database) ? $this->database : $database;
        //基于group_num查ig_group表查该小组的信息
        $data = $database->select("ig_group", [
            "[>]ig_group_character" => "group_num"
        ], [
            "ig_group.name",
            "ig_group.stu_id",
            "ig_group.class_id",
            "ig_group.subject_id"
        ], [
            "AND" => ["ig_group.group_num" => $group_num, "ig_group.visible" => 1]
        ]);
        if ($data === false || !is_array($data)) {
            throw new Exception("editGroupMembers", 500);
        }
        if (empty($data)) {
            return false;//todo:该小组不存在，不知道返回值怎么写
        }
        $group_name = $data[0]['name'];
        $class_id = $data[0]['class_id'];
        $subject_id = $data[0]['subject_id'];
        $old_stu_ids = array_column($data, "stu_id");

        try {
            //返回在旧成员数组中，不在新成员数组中的stu_id数组
            $delete_stu_ids = array_diff($old_stu_ids, $new_stu_ids);
            //待删除的小组成员，设置不可见
            $query1 = $database->update("ig_group", ["visible" => 0], ["AND" => ["group_num" => $group_num, "stu_id" => $delete_stu_ids]]);
            if ($query1->rowCount() < 0) {
                return false;//todo:删除小组成员失败，不知道返回值怎么写
            }

            //返回在新成员数组中，不在旧成员数组中的stu_id数组
            $add_stu_ids = array_diff($new_stu_ids, $old_stu_ids);
            //待增加的小组成员，插入记录
            unset($querys);
            $querys = array();
            unset($ids);
            $ids = array();
            foreach ($add_stu_ids as $a) {
                //插入新的记录
                $querys[] = $database->insert("ig_group", [
                    "group_num" => $group_num,
                    "name" => $group_name,
                    "stu_id" => $a,
                    "class_id" => $class_id,
                    "subject_id" => $subject_id
                ]);
                $ids[] = $database->id();
            }
            foreach ($querys as $q) {
                if ($q->rowCount() != 1) {//如果影响的行数不等于1
                    //撤销刚刚插入的所有记录
                    foreach ($ids as $i) {
                        $database->update("ig_group", ["visible" => 0], ["id" => $i]);
                    }

                    //撤销刚刚删除的小组成员
                    $database->update("ig_group", ["visible" => 1], ["AND" => ["group_num" => $group_num, "stu_id" => $delete_stu_ids]]);

                    return false;//todo:增加小组成员失败，不知道返回值怎么写
                }
            }

        } catch (Exception $e) {
            throw $e;
        }
        return true;//todo:编辑小组成员成功，不知道返回值怎么写
    }

    public function deleteGroup($emp_num, $group_num, Medoo $database = null)
    {
        // Implement deleteGroup() method.
        $database = is_null($database) ? $this->database : $database;
        try {
            $query = $database->update("ig_group", ["visible" => 0], ["group_num" => $group_num]);
        } catch (Exception $e) {
            throw $e;
        }
        if ($query->rowCount() < 0) {
            return false;//todo:删除小组失败，不知道返回值怎么写
        }
        return true;//todo:删除小组成功，不知道返回值怎么写
    }

    public function getStuOfNoGroup($emp_num, $class_id, $sch_id, Medoo $database = null,$maxexp = MAXEXP)
    {
        // Implement deleteGroup() method.
        $database = is_null($database) ? $this->database : $database;

        //基于emp_num和sch_id查科目id 连到ig_group表查已加入该科目小组的学生id
        $groupStuIds = $database->select("ig_group", [
            "[>]ig_teacher" => ["class_id", "subject_id"]
        ], [
            "ig_group.stu_id"
        ], [
            "AND" => [
                "ig_teacher.emp_num" => $emp_num,
                "ig_teacher.sch_id" => $sch_id,
                "ig_teacher.visible" => 1,
                "ig_group.class_id" => $class_id,
                "ig_group.visible" => 1
            ]
        ]);
        if ($groupStuIds === false || !is_array($groupStuIds)) {
            throw new Exception("getStuOfNoGroup error", 500);
        }
        if (empty($groupStuIds)) {
            //返回全班所有学生的信息
            return $this->getStudents($emp_num, $class_id, $sch_id);
        }
        $groupStuIds = array_column($groupStuIds, "stu_id");//转成一维数组

        //基于class_id查该班的所有学生id
        $allStuIds = $database->select("ig_student", ["id"], ["AND" => ["class_id" => $class_id, "visible" => 1]]);
        if ($allStuIds === false || !is_array($allStuIds)) {
            throw new Exception("getStuOfNoGroup error", 500);
        }
        if (empty($allStuIds)) {
            return false;//todo:该班没有学生，不知道返回值怎么写
        }
        $allStuIds = array_column($allStuIds, "id");//转成一维数组

        //得到未加入小组的学生id
        $noGroupStuId = array_diff($allStuIds, $groupStuIds);
        //基于id查学生的信息
        $stuData = $database->select("ig_student", [
            "[>]ig_teacher" => "class_id",
            "[>]ig_single_character" => ["ig_teacher.subject_id" => "subject_id", "id"=>"stu_id"]
        ], [
            "ig_student.stu_num",
            "ig_student.name",
            "ig_student.icon",
            "ig_single_character.lv",
            "ig_single_character.exp",
            "ig_single_character.gp"
        ], [
            "ig_student.id" => $noGroupStuId,
            "ig_teacher.emp_num" => $emp_num,
            "ig_teacher.sch_id" => $sch_id,
            "ig_teacher.visible" => 1
        ]);
        if ($stuData === false || !is_array($stuData)) {
            throw new Exception("getStuOfNoGroup error", 500);
        }

        unset($studentList);
        $studentList = array();
        //把$stuData的数据 通过构造函数塞到对象里，放进$studentList对象数组
        foreach ($stuData as $s) {
            $stu_num = $name = $icon = $lv = $exp = $gp = null;
            extract($s);//从数组中将变量导入到当前的符号表
            if (empty($lv)) {//ig_single_character表没有该学生该科目的分数记录
                $lv = $exp = $gp = 0;
            }

            //计算等级
            $maxexp=json_decode($maxexp);
            foreach ($maxexp as $k => $m) {
                if ($exp <= $m) {
                    $lv = $k;
                    break;
                }
            }

            $studentpnObj = new StudentPn($name, $stu_num, $icon, $class_id, $sch_id, $lv, $exp, $gp);
            $studentList[] = $studentpnObj;
        }
        return $studentList;
    }
}