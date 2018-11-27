<?php
/**
 * Created by PhpStorm.
 * User: junweihu
 * Date: 2018/11/25
 * Time: 2:09 PM
 */

namespace app\index\controller;

use think\Controller;

class Student extends Controller
{
    public function index()
    {
        $this->assign('title', 'exam_主页');
        return $this->fetch('');
    }

    //学生考试选题主页
    public function studentExamIndex()
    {
        $student_model = model('Student');
        $class = $student_model->studentNumFindClass(session('num'));
        $paper = [];
        $tool = new Tool();
        foreach($class as $num => $i) {
            if($tool->classNumFindPaper($i['class_num'])) {
                $paper[$i['class_name']] = $tool->classNumFindPaper($i['class_num']);
            } else {
                $paper[$i['class_name']][0] = null;
                $paper[$i['class_name']]['class_name'] = $i['class_name'];
            }
        }
        $this->assign('paper', $paper);
        $this->assign('title', 'Exam|选择考试');
        return $this->fetch('');
    }

    //学生考试主页
    public function studentTestIndex()
    {
        $paper_num = input('paper_num');
        $tool = new Tool();
        $paper = $tool->paperNumFindPaper($paper_num);
        $single_choice = $tool->singleChoiceStrToArr($paper['single_choice']);
        $true_or_false = $tool->trueOrFalseStrToArr($paper['true_or_false']);
        $this->assign('paper', $paper);
        $this->assign('single_choice', $single_choice);
        $this->assign('true_or_false', $true_or_false);
        $this->assign('title', '考试');
        return $this->fetch('');
    }

    //学生考试
    public function studentTestResult()
    {
        $paper_num = input('paper_num');
        if(isset(input()['single_choice'])){
            $single_choice_answer = input()['single_choice'];
        }else{
            return $this->error('漏选了选择题！');
        }
        if(isset(input()['true_or_false'])){
            $true_or_false_answer = input()['true_or_false'];
        }else {
            return $this->error('漏选了判断题！');
        }
        $student_model = model('Student');
        $tool = new Tool();
        $paper = $tool->paperNumFindPaper($paper_num);
        $single_choice = $tool->singleChoiceStrToArr($paper['single_choice']);
        $true_or_false = $tool->trueOrFalseStrToArr($paper['true_or_false']);
        $sum_score = 0;
        $score = 0;
        foreach($single_choice as $num => $i) {
            if(!isset($single_choice_answer[$i['single_choice_id']])){
                return $this->error('漏选了选择题');
            }
            $sum_score += $paper['single_choice_score'];
            if($single_choice_answer[$i['single_choice_id']] == $i['answer']) {
                $score += $paper['single_choice_score'];
                $single_choice[$num]['judge'] = 'true';
                $single_choice[$num]['student_answer'] = $single_choice_answer[$i['single_choice_id']];
            } else {
                $single_choice[$num]['judge'] = 'false';
                $single_choice[$num]['student_answer'] = $single_choice_answer[$i['single_choice_id']];
            }
        }
        foreach($true_or_false as $num => $i) {
            if(!isset($true_or_false_answer[$i['true_or_false_id']])){
                return $this->error('漏选了判断题');
            }
            $sum_score += $paper['true_or_false_score'];
            if($true_or_false_answer[$i['true_or_false_id']] == $i['answer']) {
                $score += $paper['true_or_false_score'];
                $true_or_false[$num]['judge'] = 'true';
                $true_or_false[$num]['student_answer'] = $true_or_false_answer[$i['true_or_false_id']];
            } else {
                $true_or_false[$num]['judge'] = 'false';
                $true_or_false[$num]['student_answer'] = $true_or_false_answer[$i['true_or_false_id']];
            }
        }
        $single_choice_answer = join('|',$single_choice_answer);
        $true_or_false_answer = join('|',$true_or_false_answer);
        $student_answer = $single_choice_answer.'-'.$true_or_false_answer;
        if(!$student_model->insertStudentTestResult(session('num'),session('username'),$paper['class_num'],$paper['class_name'],$paper['teacher_num'],$paper['teacher_name'],$paper['paper_num'],$paper['paper_name'],$sum_score,$score,$student_answer,$paper['single_choice'],$paper['true_or_false'])){
            return $this->error('上传失败！');
        }
        $this->assign('sum_score',$sum_score);
        $this->assign('score',$score);
        $this->assign('paper', $paper);
        $this->assign('single_choice',$single_choice);
        $this->assign('true_or_false',$true_or_false);
        $this->assign('title','Exam|考试结果');
        return $this->fetch('');
    }
}