<?php
/**
 * Created by PhpStorm.
 * User: junweihu
 * Date: 2018/10/31
 * Time: 1:15 PM
 */

namespace app\index\controller;

use think\Controller;

class Teacher extends Controller
{
    public function index()
    {
        if(session('identity') == 1) {      //判断是否为合法登录
            return $this->fetch('');
        } else {
            return $this->error('身份认证错误，请重新登陆！');
        }
    }

    public function teacherAddSingleChoiceIndex()       //教师添加单选题主页
    {
        $teacher_model = model('Teacher');
        $class_info = $teacher_model->teacherFindSelfClass(session('num'));
        $this->assign('class_info', $class_info);
        return $this->fetch('');
    }

    public function teacherAddSingleChoice()       //教师添加单选题
    {
        $data = [
            'topic' => input('topic'),
            'A' => input('A'),
            'B' => input('B'),
            'C' => input('C'),
            'D' => input('D'),
            'soleve_thinking' => input('soleve_thinking'),
            'difficulty' => input('difficulty'),
            'class_num' => input('class_num'),
            'answer' => input('answer')
        ];

        $check = validate('SingleChoice');
        if(!$check->check($data)) {
            $this->error($check->getError());
        }

        $tool = new Tool();
        $teacher = $tool->numFindUser(session('num'));
        $class_name = $tool->classNumFindClass($data['class_num'])['class_name'];
        $teacher_model = model('Teacher');
        if($teacher_model->teacherAddSingleChoice($data['topic'], $data['A'], $data['B'], $data['C'], $data['D'], $data['soleve_thinking'], $teacher, session('num'), $data['difficulty'], $data['class_num'], $class_name, $data['answer'])) {
            return $this->success('添加试题成功！');
        } else {
            return $this->error('添加试题失败！');
        }
    }

    public function teacherAddTrueOrFalseIndex()     //教师添加判断题
    {
        $teacher_model = model('Teacher');
        $class_info = $teacher_model->teacherFindSelfClass(session('num'));
        $this->assign('class_info', $class_info);
        return $this->fetch('');
    }

    public function teacherAddTrueOrFalse()     //教师添加判断题
    {
        $data = [
            'topic' => input('topic'),
            'soleve_thinking' => input('soleve_thinking'),
            'difficulty' => input('difficulty'),
            'class_num' => input('class_num'),
            'answer' => input('answer')
        ];

        $check = validate('Trueorfalse');
        if(!$check->check($data)) {
            $this->error($check->getError());
        }

        $tool = new Tool();
        $teacher = $tool->numFindUser(session('num'));
        $class_name = $tool->classNumFindClass($data['class_num'])['class_name'];
        $teacher_model = model('Teacher');
        if($teacher_model->teacherAddTrueOrFalse($data['topic'], $data['soleve_thinking'], $teacher, session('num'), $data['difficulty'], $data['class_num'], $class_name, $data['answer'])) {
            return $this->success('添加试题成功！');
        } else {
            return $this->error('添加试题失败！');
        }
    }

    public function teacherTestQuestionsManage()        //教师管理题
    {
        $teacher_model = model('Teacher');
        $single_choice = $teacher_model->teacherSingleChoiceManage(session('num'));
        $this->assign('single_choice', $single_choice);     //当前教师单选题题目
        $true_or_false = $teacher_model->teacherTrueOrFalse(session('num'));
        $this->assign('true_or_false', $true_or_false);
        return $this->fetch('');
    }

    public function teacherDeleteSingleChoice()        //教师删除单选题题目
    {
        $single_choice_id = input('id');
        $teacher_model = model('Teacher');
        if($teacher_model->teacherDeleteSingleChoice($single_choice_id)) {
            return $this->success('删除试题成功！');
        } else {
            return $this->error('删除试题失败！');
        }
    }

    public function teacherCompileSingleChoiceIndex()        //教师编辑单选题主页
    {
        $single_choice_id = input('id');
        $teacher_model = model('Teacher');
        $class_info = $teacher_model->teacherFindSelfClass(session('num'));
        $this->assign('class_info', $class_info);

        $single_choice_info = $teacher_model->teacherCompileSingleChoiceIndex($single_choice_id);
        $this->assign('single_choice_info', $single_choice_info);
        return $this->fetch('');
    }

    public function teacherCompileSingleChoice()        //教师编辑单选题
    {
        $data = [
            'topic' => input('topic'),
            'A' => input('A'),
            'B' => input('B'),
            'C' => input('C'),
            'D' => input('D'),
            'soleve_thinking' => input('soleve_thinking'),
            'single_choice_id' => input('id'),
            'difficulty' => input('difficulty'),
            'class_num' => input('class_num'),
            'answer' => input('answer')
        ];

        $check = validate('SingleChoice');
        if(!$check->check($data)) {
            $this->error($check->getError());
        }

        $tool = new Tool();
        $teacher_model = model('Teacher');
        $class_name = $tool->classNumFindClass($data['class_num'])['class_name'];
        if($teacher_model->teacherCompileSingleChoice($data['topic'], $data['A'], $data['B'], $data['C'], $data['D'], $data['soleve_thinking'], $data['single_choice_id'], $data['difficulty'], $data['class_num'], $class_name, $data['answer'])) {
            return $this->success('修改试题成功！','teacherTestQuestionsManage');
        } else {
            return $this->error('修改试题失败！');
        }
    }

    public function teacherDeleteTrueOrFalse()        //教师删除判断题题目
    {
        $true_or_false_id = input('id');
        $teacher_model = model('Teacher');
        if($teacher_model->teacherDeleteTrueOrFalse($true_or_false_id)) {
            return $this->success('删除试题成功！');
        } else {
            return $this->error('删除试题失败！');
        }
    }

    public function teacherCompileTrueOrFalseIndex()        //教师编辑单选题主页
    {
        $true_or_false_id = input('id');
        $teacher_model = model('Teacher');
        $class_info = $teacher_model->teacherFindSelfClass(session('num'));
        $this->assign('class_info', $class_info);

        $true_or_false_info = $teacher_model->teacherCompileTrueOrFalseIndex($true_or_false_id);
        $this->assign('true_or_false_info', $true_or_false_info);
        return $this->fetch('');
    }

    public function teacherCompileTrueOrFalse()         //教师编辑判断题
    {
        $data = [
            'topic' => input('topic'),
            'soleve_thinking' => input('soleve_thinking'),
            'difficulty' => input('difficulty'),
            'class_num' => input('class_num'),
            'answer' => input('answer'),
            'true_or_false_id' => input('true_or_false_id')
        ];
        $check = validate('Trueorfalse');
        if(!$check->check($data)) {
            $this->error($check->getError());
        }

        $tool = new Tool();
        $class_name = $tool->classNumFindClass($data['class_num'])['class_name'];
        $teacher_model = model('Teacher');
        //$topic, $soleve_thinking,  $true_or_false_id, $difficulty, $class_num, $class_name, $answer
        if($teacher_model->teacherCompileTrueOrFalse($data['topic'], $data['soleve_thinking'], $data['true_or_false_id'], $data['difficulty'], $data['class_num'], $class_name, $data['answer'])) {
            return $this->success('修改试题成功！','teacherTestQuestionsManage');
        } else {
            return $this->error('修改试题失败！');
        }
    }

    public function teacherFindSelfClass()      //教师查找自己的课堂
    {
        $teacher_model = model('Teacher');
        if($teacher_model->teacherFindSelfClass(session('num'))) {
            $class_info = $teacher_model->teacherFindSelfClass(session('num'));
            $this->assign('class_info', $class_info);
            return $this->fetch('');
        } else {
            return $this->error('没有课堂！');
        }
    }

    public function teacherFindTestQuestionsIndex()     //教师查询试题主页
    {
        $this->teacherFindSelfClass();
        return $this->fetch('');
    }

    public function teacherFindTestQuestions()      //教师查询试题
    {
        $class_num = input('class_num');
        $tool = new Tool();
        $single_choice = $tool->classNumFindAllTestQuestions($class_num)['single_choice'];
        $true_or_false = $tool->classNumFindAllTestQuestions($class_num)['true_or_false'];
        $class_name = $tool->classNumFindClass($class_num)['class_name'];
        $this->assign('class_name', $class_name);
        $this->assign('single_choice', $single_choice);
        $this->assign('true_or_false', $true_or_false);
        return $this->fetch('');
    }
}