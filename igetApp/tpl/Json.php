<?php
/**
 * Created by PhpStorm.
 * User: haier
 * Date: 2018-2-26
 * Time: 20:56
 */

namespace  igetApp\tpl;


class Json
{
    public $retcode;
    public $retmsg;
    public $retdata;

    /**
     * Json constructor.
     * @param $retcode
     * @param $retmsg
     * @param $retdata
     */
    public function __construct($retdata,  $retmsg = null,$retcode = 200200)
    {
        $this->retcode = $retcode;
        $this->retmsg = $retmsg;
        $this->retdata = $retdata;
    }

}