<?php
/**
 * Created by PhpStorm.
 * User: junweihu
 * Date: 2018/10/29
 * Time: 8:46 PM
 */

namespace app\index\controller;

use think\Controller;

class Register extends Controller
{
    public function studentRegister()     //显示注册页面
    {
        session('captcha', null);
        return $this->fetch('');
    }

    public function teacherRegister()       //显示教师注册页面
    {
        session('captcha', null);
        return $this->fetch('');
    }

    public function register()         //注册验证
    {
        $ul = validate('Register');
        $data = [
            'username' => input('username'),
            'num' => input('num'),
            'email' => input('email'),
            'password' => input('password'),
            'repassword' => input('repassword'),
            'captcha' => input('captcha')
        ];
        $password = input('password');
        $repassword = input('repassword');
        if(!$ul->check($data)) {
            $this->error($ul->getError());
        }
        if(!session('captcha')) {
            $captcha = new \think\captcha\Captcha();
            $result = $captcha->check($data['captcha']);
            if(!$result) {
                $this->error('验证码错误');
            }
        } else {
            if(session('captcha') != $data['captcha']) {
                session('captcha', null);
                $this->error('验证码错误');
            }
        }
        $register = model('Register');          //创建Yammydata对象register
        $tool = model('Tool');
        if($tool->findEmail($data['email'])) {
            $this->error('邮箱已被注册，请重新输入邮箱地址');
        }
        if($tool->findNum($data['num'])) {
            $this->error('学号已被注册，请重新输入学号');
        }
        $headimg = request()->file('file');
        $headimgPath = '';
        if($headimg) {
            $info = $headimg->validate(['size' => 3000000, 'ext' => 'jpg,png,gif'])->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'static/headimg', '');
            if($info) {
                $headimgPath = '/static/headimg/' . $info->getFilename();
                //裁剪头像
                $image = \think\Image::open('./static/headimg/' . $info->getSaveName());
                $image->thumb(150, 150, \think\Image::THUMB_CENTER)->save('./static/headimg/' . $info->getSaveName());
            } else {
                // 上传失败获取错误信息
                return $this->error($headimg->getError());
            }
        } else {
            $headimgPath = '/static/headimg/moren.png';
        }
        if($password != $repassword) {
            $this->error('两次密码不一致，请重新输入');
        }
        $identity = input('identity');      //身份代号，学生为0，老师为1
        session('identity', $identity);
        $info = $register->insertRegisterInfo($data['username'], $data['password'], $data['num'], $data['email'], $headimgPath, $identity);    //用register中reg方法将数据插入数据库
        if($info) {
            session('username', null);        //在Mall中再存username，以此判断注册操作还是二次发送操作
            if($headimgPath == '') {
                session('headimg', '/static/headimg/moren.png');
            } else {
                session('headimg', $headimgPath);        //将登陆的用户名及头像信息存入session
            }
            $this->redirect('Mail/index', ['email' => $data['email'], 'username' => $data['username']]);
        } else {
            $this->error('注册失败');
        }
    }
}
