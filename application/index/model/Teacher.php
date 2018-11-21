<?php
/**
 * Created by PhpStorm.
 * User: junweihu
 * Date: 2018/11/1
 * Time: 11:08 PM
 */

namespace app\index\model;

use think\Model;

class Teacher extends Model
{
    //教师添加单选题
    public function teacherAddSingleChoice($topic, $A, $B, $C, $D, $soleve_thinking, $teacher, $teacher_num, $difficulty, $class_num, $class_name, $answer)
    {
        $info = db('single_choice')->insert(['topic' => $topic, 'A' => $A, 'B' => $B, 'C' => $C, 'D' => $D, 'soleve_thinking' => $soleve_thinking, 'teacher' => $teacher, 'teacher_num' => $teacher_num, 'difficulty' => $difficulty, 'class_num' => $class_num, 'class_name' => $class_name, 'answer' => $answer]);
        return $info;
    }

    //教师添加判断题
    public function teacherAddTrueOrFalse($topic, $soleve_thinking, $teacher, $teacher_num, $difficulty, $class_num, $class_name, $answer)
    {
        $info = db('true_or_false')->insert(['topic' => $topic, 'soleve_thinking' => $soleve_thinking, 'teacher' => $teacher, 'teacher_num' => $teacher_num, 'difficulty' => $difficulty, 'class_num' => $class_num, 'class_name' => $class_name, 'answer' => $answer]);
        return $info;
    }

    //教师查询选择题
    public function teacherSingleChoiceManage($teacher_num)
    {
        $info = db('single_choice')->where('teacher_num', $teacher_num)->select();
        return $info;
    }

    //教师查询判断题
    public function teacherTrueOrFalse($teacher_num)
    {
        $info = db('true_or_false')->where('teacher_num', $teacher_num)->select();
        return $info;
    }

    //教师删除单选题题目
    public function teacherDeleteSingleChoice($single_choice_id)
    {
        $info = db('single_choice')->where('single_choice_id', $single_choice_id)->delete();
        return $info;
    }

    //教师编辑单选题主页
    public function teacherCompileSingleChoiceIndex($single_choice_id)
    {
        $info = db('single_choice')->where('single_choice_id', $single_choice_id)->find();
        return $info;
    }

    //教师编辑单选题
    public function teacherCompileSingleChoice($topic, $A, $B, $C, $D, $soleve_thinking, $single_choice_id, $difficulty, $class_num, $class_name, $answer)
    {
        $info = db('single_choice')->where('single_choice_id', $single_choice_id)->update(['topic' => $topic, 'A' => $A, 'B' => $B, 'C' => $C, 'D' => $D, 'soleve_thinking' => $soleve_thinking, 'difficulty' => $difficulty, 'class_num' => $class_num, 'class_name' => $class_name, 'answer' => $answer]);
        return $info;
    }

    //教师删除判断题题目
    public function teacherDeleteTrueOrFalse($true_or_false_id)
    {
        $info = db('true_or_false')->where('true_or_false_id', $true_or_false_id)->delete();
        return $info;
    }

    //教师编辑判断题主页
    public function teacherCompileTrueOrFalseIndex($true_or_false_id)
    {
        $info = db('true_or_false')->where('true_or_false_id', $true_or_false_id)->find();
        return $info;
    }

    //教师编辑判断题
    public function teacherCompileTrueOrFalse($topic, $soleve_thinking,  $true_or_false_id, $difficulty, $class_num, $class_name, $answer)
    {
        $info = db('true_or_false')->where('true_or_false_id', $true_or_false_id)->update(['topic' => $topic, 'soleve_thinking' => $soleve_thinking,  'difficulty' => $difficulty, 'class_num' => $class_num, 'class_name' => $class_name, 'answer' => $answer]);
        return $info;
    }

    //教师查找自己的课堂
    public function teacherFindSelfClass($teacher_num)
    {
        $info = db('class')->where('teacher_num', $teacher_num)->select();
        return $info;
    }

}