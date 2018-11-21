<?php
/**
 * Created by PhpStorm.
 * User: junweihu
 * Date: 2018/10/29
 * Time: 9:30 PM
 */

namespace app\index\controller;

use think\Controller;

class Tool extends Controller
{

    /*--------------------------------------账号查找--------------------------------------*/

    public function findNumExist($num)      //查找账号是否存在
    {
        $tool = model('Tool');
        return $tool->findNumExist($num);
    }

    public function regName()       //动态验证注册用户名是否可用
    {
        $username = input('name');
        $userlist = model('Tool');
        if($userlist->findUsername($username)) {
            return 0;
        } else {
            return 1;
        }
    }

    public function numFindUser($num)       //根据学号查找用户名
    {
        $tool = model('Tool');
        return $tool->numFindUser($num);
    }

    public function numFindIdentity($num)       //根据学号查找身份
    {
        $tool = model('Tool');
        return $tool->numFindIdentity($num);
    }

    public function numFindBan($num)        //根据学号查找Ban状态
    {
        $tool = model('Tool');
        return $tool->numFindBan($num);
    }

    public function findAllTeacher()        //查找全部老师
    {
        $tool = model('Tool');
        return $tool->findAllTeacher();
    }

    public function findAllStudent()        //查找全部学生
    {
        $tool = model('Tool');
        return $tool->findAllStudent();
    }

    public function findAllStudentInClass($class_num)         //按课程号查找在此课堂的学生
    {
        $tool = model('Tool');
        return $tool->findAllStudentInClass($class_num);
    }


    public function classNumFindClass($class_num)     //根据课程号查找课程信息
    {
        $tool = model('Tool');
        return $tool->classNumFindClass($class_num);
    }

    public function classNumFindSingleChoice($class_num)      //根据课程号查找单选题
    {
        $tool = model('Tool');
        if($tool->classNumFindSingleChoice($class_num)) {
            return $tool->classNumFindSingleChoice($class_num);
        }else{
            return null;
        }
    }

    public function classNumFindTrueOrFalse($class_num)      //根据课程号查找判断题
    {
        $tool = model('Tool');
        if($tool->classNumFindTrueOrFalse($class_num)) {
            return $tool->classNumFindTrueOrFalse($class_num);
        }else{
            return null;
        }
    }

    public function classNumFindAllTestQuestions($class_num)        //根据课程号查找所有题
    {
        $tool['single_choice'] = $this->classNumFindSingleChoice($class_num);
        $tool['true_or_false'] = $this->classNumFindTrueOrFalse($class_num);
        return $tool;
    }

    public function sendMail()         //发送邮件
    {
        return $this->redirect('Mail/index', ['email' => input('email'), 'username' => session('username')]);
    }

    public function exitLogin()         //退出登录
    {
        session('username', null);
        session('headimg', null);
        session('identity', null);
        session('num', null);
        return $this->redirect('Index/index');
    }
}