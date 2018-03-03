<?php
namespace  igetApp\dao;
/**
 * Created by PhpStorm.
 * User: haier
 * Date: 2018-2-26
 * Time: 20:40
 */
use Medoo\Medoo;

class BaseDao
{

    protected $database;
    /**
     * BaseDao constructor.
     */
    public function __construct()
    {
        $this->database = new Medoo([
            'database_type' => DATABASE_TYPE,
            'database_name' => DATABASE_NAME,
            'server' => SERVER,
            'username' => USERNAME,
            'password' => PASSWORD,
            'charset' => CHARSET,
            'port' => PORT,
            'check_interval' => CHECK_INTERVAL
        ]);
    }
}