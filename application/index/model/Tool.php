<?php
/**
 * Created by PhpStorm.
 * User: junweihu
 * Date: 2018/10/29
 * Time: 10:37 PM
 */

namespace app\index\model;

use think\Model;

class Tool extends Model
{
    //查找账号是否存在
    public function findNumExist($num)
    {
        $info = db('userlist')->where('num', $num)->find();
        return $info;
    }

    //查找重复用户名
    public function findUserName($username)
    {
        $info = db('userlist')->where('username', $username)->find();
        return $info;
    }

    //查找重复邮箱
    public function findEmail($email)
    {
        $info = db('userlist')->where('email', $email)->find();
        return $info;
    }

    //查找重复学号
    public function findNum($num)
    {
        $info = db('userlist')->where('num', $num)->find();
        return $info;
    }

    //查找重复课程号
    public function findRepetitionClassNum($class_num)
    {
        $info = db('class')->where('class_num', $class_num)->find();
        return $info;
    }

    //根据学号查找用户名
    public function numFindUser($num)
    {
        $info = db('userlist')->where('num', $num)->value('username');
        return $info;
    }

    //根据学号查找身份
    public function numFindIdentity($num)
    {
        $info = db('userlist')->where('num', $num)->value('identity');
        return $info;
    }

    //根据学号查找Ban状态
    public function numFindBan($num)
    {
        $info = db('userlist')->where('num', $num)->value('ban');
        return $info;
    }

    //查找全部老师
    public function findAllTeacher()
    {
        $info = db('userlist')->where('identity', 1)->select();
        return $info;
    }

    //查找全部学生
    public function findAllStudent()
    {
        $info = db('userlist')->where('identity', 0)->select();
        return $info;
    }

    //根据课程号查找课程信息
    public function classNumFindClass($class_num)
    {
        $info = db('class')->where('class_num', $class_num)->find();
        return $info;
    }

    //按课程号查找在此课堂的学生
    public function findAllStudentInClass($class_num)
    {
        $info = db('class_student')->where('class_num', $class_num)->select();
        return $info;
    }

    //根据课程号查找单选题
    public function classNumFindSingleChoice($class_num)
    {
        $info = db('single_choice')->where('class_num', $class_num)->select();
        return $info;
    }

    //根据课程号查找判断题
    public function classNumFindTrueOrFalse($class_num)
    {
        $info = db('true_or_false')->where('class_num', $class_num)->select();
        return $info;
    }
}