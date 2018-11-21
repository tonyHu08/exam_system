<?php
/**
 * Created by PhpStorm.
 * User: junweihu
 * Date: 2018/10/29
 * Time: 9:42 PM
 */

namespace app\index\controller;

use think\Controller;

class Login extends Controller
{
    public function index()
    {
        return $this->fetch('');
    }

    public function login()        //登陆验证
    {
        $data = [
            'num' => input('num'),
            'password' => input('password')
        ];
        $ul = validate('Login');
        if(!$ul->check($data)) {
            return $this->error($ul->getError());
        }
        if($data['num'] == 'admin') {           //如果是管理员账号登录
            if($data['password'] == 'admin321') {
                session('identity', 'admin');
                return $this->redirect('Index/index');
            } else {
                return $this->error('帐号或密码错误，请重新输入！');
            }
        } else {
            $userlist = model('Login');
            $info = $userlist->login($data['num'], $data['password']);
            if($info) {
                $tool = new Tool();
                $username = $tool->numFindUser($data['num']);       //将账号的用户名查找出来
                session('num', $data['num']);
                session('username', $username);
                session('headimg', $info['headimg']);        //将登陆的用户名及头像信息存入session
                $identity = $tool->numFindIdentity($data['num']);
                if($identity == 0) {                                 //如果是学生身份登录
                    session('identity', '0');
                    return $this->redirect('Index/index');
                } elseif($identity == 1) {                                              //如果是教师身份登录
                    session('identity', 1);
                    return $this->redirect('Index/index');
                }
            } else {
                return $this->error('帐号或密码错误，请重新输入！');
            }
        }
    }
}