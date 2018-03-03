<?php
/**
 * Created by PhpStorm.
 * User: haier
 * Date: 2018-2-26
 * Time: 20:39
 */

namespace  igetApp\dao;
use Exception;

class User extends BaseDao
{
    private $table = DB_PRE.'_user';

    /** 用账号密码获取用户id
     * 查找是否存在该用户 如果用户存在返回uid 不存在则返回-1
     * @param $account
     * @param $pwEn
     * @param $type
     * @param null $table
     * @param null $database
     * @return int
     * @throws Exception
     */
    public function getUidByAccount($account, $pwEn,$type,$table = null,$database = null)
    {
        if($table === null){
            $table = $this->table;
        }

        if($database === null){
            $database = $this->database;
        }

        //检查账号密码
        $has = $database->has($table, [
            "AND" => [
                "account" => $account,
                "pw_encrypt" => $pwEn,
                "type"=>$type,
                "visible" => 1
            ]
        ]);
        if (!is_bool($has)) {
            throw new Exception("DB_ERROR:User getUidByAccount bool has", 500);
        }

        if (!$has) {
            //登录失败 账号或密码不正确
            $user_id = -1;
            return $user_id;
        } else {
            //登录成功
            //获取uid
            $data = $database->select($table, [
                "id",
            ], [
                "AND" => [
                    "account" => $account,
                    "pw_encrypt" => $pwEn,
                    "type"=>$type,
                    "visible" => 1
                ]
            ]);
            if (!is_array($data) || sizeof($data) != 1) {
                throw new Exception("DB_ERROR:User getUidByAccount", 500);
            }
            $uid = $data[0]['id'];
            return $uid;
        }
    }

    /** 根据uid获取账号 获取不到则返回空
     * @param $user_id
     * @param $type
     * @param null $table
     * @param null $database
     * @return null
     */
    public function getAccount($user_id,$table = null,$database = null)
    {
        if($table === null){
            $table = $this->table;
        }

        if($database === null){
            $database = $this->database;
        }

        //获取账号
        $data = $database->select($table, [
            "account",
        ], [
            "AND" => [
                "id" => $user_id,
                "visible" => 1
            ]
        ]);
        //异常返回空
        if (!is_array($data) || sizeof($data) != 1) {
            return null;
//            throw new Exception("DB_ERROR:User getAccount", 500);
        }
        //正常则获取数据
        $account = $data[0]['account'];
        return $account;


    }

}