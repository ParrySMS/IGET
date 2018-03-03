<?php
/**
 * Created by PhpStorm.
 * User: haier
 * Date: 2017-11-21
 * Time: 19:43
 */
require './vendor/autoload.php';
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

//报错内容展示数据 上线前关掉
$config = [
    'settings' => [
        'displayErrorDetails' => true
    ],
];

$app = new \Slim\App($config);

//登录
$app->group('/login', function () {
    //老师登录
    $this->post('/teacher', function ($request, $response) {
        $account = isset($request->getParsedBody()["account"]) ? $request->getParsedBody()["account"] : null;
        $pw = isset($request->getParsedBody()["pw"]) ? $request->getParsedBody()["pw"] : null;
        $type = 'teacher';
        $cct = new  igetApp\controller\CreateToken($account, $pw,$type);
        setcookie(TCH_TOKEN_NAME, $cct->getToken(), EXPIRES, PATH);
        return $response->withStatus($cct->getStatus());
    });
    //学生登录
    $this->post('/student', function ($request, $response) {
        $account = isset($request->getParsedBody()["account"]) ? $request->getParsedBody()["account"] : null;
        $pw = isset($request->getParsedBody()["pw"]) ? $request->getParsedBody()["pw"] : null;
        $type = 'student';
        $cct = new  igetApp\controller\CreateToken($account, $pw,$type);
        setcookie(STU_TOKEN_NAME, $cct->getToken(), EXPIRES, PATH);
        return $response->withStatus($cct->getStatus());
    });
    //家长登录
    $this->post('/parent', function ($request, $response) {
        $account = isset($request->getParsedBody()["account"]) ? $request->getParsedBody()["account"] : null;
        $pw = isset($request->getParsedBody()["pw"]) ? $request->getParsedBody()["pw"] : null;
        $type = 'parent';
        $cct = new  igetApp\controller\CreateToken($account, $pw,$type);
        setcookie(PAR_TOKEN_NAME, $cct->getToken(), EXPIRES, PATH);
        return $response->withStatus($cct->getStatus());
    });
});


$app->run();