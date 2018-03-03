<?php
/**
 * Created by PhpStorm.
 * User: haier
 * Date: 2017-11-21
 * Time: 15:56
 */


//---------------- 加密参数 ---------------//
//token 加密密钥
define('DATA_AUTH_KEY','NG#snl*&28&%^gf&8grugt574^vf98');
//密钥 混淆字符串
define('NONSTR','IGET');

//---------------- 名称 -----------------//



//老师token名
define("TCH_TOKEN_NAME",'tchToken');
//学生token名
define("STU_TOKEN_NAME",'stuToken');
//家长token名
define("PAR_TOKEN_NAME",'parToken');
//token过期时间
define("EXPIRES",time()+3600*24);
//coolie生效路径
define("PATH",'/');

//---------------- 限制范围 -----------------//
//非管理员的登录类型限制
define('LOGIN_TYPE_REGION', 'return array(
            "teacher",
            "student",
            "parent"
            );');

//密码位数限制
define("PW_MIN",6);
define("PW_MAX",16);




define("RECALLTIME",10*60);//原本是3*60，修改为10*60，原因是3分钟有点短


$maxexp = [0 => 0, 1 => 5, 2 => 12, 3 => 21, 4 => 32, 5 => 45];
$maxexp = json_encode($maxexp);
define("MAXEXP",$maxexp);//todo:定义数组：每个等级的最大经验