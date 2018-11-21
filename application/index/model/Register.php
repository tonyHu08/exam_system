<?php
/**
 * Created by PhpStorm.
 * User: junweihu
 * Date: 2018/10/29
 * Time: 9:23 PM
 */

namespace app\index\model;

use think\Model;

class Register extends Model
{
    //插入注册信息
    public function insertRegisterInfo($username, $password, $num, $email, $headimg, $identity)
    {
        $info = db('userlist')->insert(['username' => $username, 'password' => $password, 'num' => $num, 'email' => $email, 'regtime' => time(), 'active' => 0, 'ban' => 0, 'headimg' => $headimg, 'identity' => $identity]);
        return $info;
    }
}