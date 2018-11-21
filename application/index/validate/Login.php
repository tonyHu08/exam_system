<?php
/**
 * Created by PhpStorm.
 * User: junweihu
 * Date: 2018/5/24
 * Time: 下午9:52
 */

namespace app\index\validate;

use think\Validate;

class Login extends Validate
{
    protected $rule = [
        'num' => 'require|max:25',
        'password' => 'require',
    ];

    protected $message = [
        'num.require' => '请输入学号',
        'password.require' => '请输入密码',
    ];
}