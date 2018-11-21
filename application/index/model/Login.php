<?php
/**
 * Created by PhpStorm.
 * User: junweihu
 * Date: 2018/10/29
 * Time: 9:44 PM
 */

namespace app\index\model;

use think\Model;

class Login extends Model
{
    //查询登陆信息（账号密码是否正确）
    public function login($num, $password)
    {
        $info = db('userlist')->where('num', $num)->where('password', $password)->find();
        return $info;
    }
}