<?php
/**
 * Created by PhpStorm.
 * User: haier
 * Date: 2017-11-21
 * Time: 21:35
 */
require "../config/database_info.php";
require "../config/parms.php";
require "./Medoo.php";
//此次引用需要测试的模块 然后进行程序调用执行 检查情况
require "./TeacherImpl.php";
require "./StudentImpl.php";

use Medoo\Medoo;

//进行测试 显示一下执行结果
$database = new Medoo([
    // required
    'database_type' => DATABASE_TYPE,
    'database_name' => DATABASE_NAME,
    'server' => SERVER,
    'username' => USERNAME,
    'password' => PASSWORD,

    // [optional]
    'charset' => CHARSET,
    'port' => PORT
]);
$teacherDao = new \iget\dao\TeacherImpl($database);

//测试getClasses函数
/*$classList = $teacherDao->getClasses(123001,11);
var_dump($classList);*/

//测试getPersonal函数
/*$teacherpnObj=$teacherDao->getPersonal(123001,1);
var_dump($teacherpnObj);*/

//测试getBadges函数
/*$badges=$teacherDao->getBadges(123001,1);
var_dump($badges);*/

//测试getAllBadges函数
/*$allbadges=$teacherDao->getAllBadges(123001,1);
var_dump($allbadges);*/

//测试awardOneBadge函数
/*$result=$teacherDao->awardOneBadge(123003,3,1,null,1);
var_dump($result);*/

//测试awardGroupBadge函数
/*$result=$teacherDao->awardGroupBadge(123001,2,3,null,1);
var_dump($result);*/

//测试awardHistory函数
/*$badgeRecord=$teacherDao->awardHistory(123001,null,"all",1);
var_dump($badgeRecord);*/

//测试recallBadge函数
/*$result=$teacherDao->recallBadge(123001,4,"single");
var_dump($result);*/

//测试getStudents函数
/*$studentList=$teacherDao->getStudents(123002,1,1);
var_dump($studentList);*/

//测试getGroups函数
/*$groupList=$teacherDao->getGroups(123001,1,1);
var_dump($groupList);*/

//测试getGroupMembers函数
/*$studentList=$teacherDao->getGroupMembers(123001,1,1);
var_dump($studentList);*/

//测试getOneStudent函数
/*$studentpnObj=$teacherDao->getOneStudent(123002,1,1);
var_dump($studentpnObj);*/

//测试createGroup函数
/*$GroupObj=$teacherDao->createGroup(123001,1,"快乐小组",[5,6],1);
var_dump($GroupObj);*/

//测试editGroup函数
/*$result=$teacherDao->editGroupMembers(123001,3, [6,7]);
var_dump($result);*/

//测试deleteGroup函数
/*$result = $teacherDao->deleteGroup(123001, 3);
var_dump($result);*/

//测试getStuOfNoGroup函数
/*$result = $teacherDao->getStuOfNoGroup(123001, 1,1);
var_dump($result);*/

$studentDao = new \iget\dao\StudentImpl($database);
//测试getPersonal函数
/*$studentpnObj=$studentDao->getPersonal(3);
var_dump($studentpnObj);*/

//测试getSubjectScores函数
/*$scoreArray=$studentDao->getSubjectScores(3);
var_dump($scoreArray);*/

