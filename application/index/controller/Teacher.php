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
            $this->assign('title', '教师中心-首页');
            return $this->fetch('');
        } else {
            return $this->error('身份认证错误，请重新登陆！');
        }
    }

    /*--------------------------------------题库管理--------------------------------------*/
    //教师添加单选题主页
    public function teacherAddSingleChoiceIndex()
    {
        $teacher_model = model('Teacher');
        $class_info = $teacher_model->teacherFindSelfClass(session('num'));
        $this->assign('class_info', $class_info);
        $this->assign('title', '教师中心-添加单选题');
        return $this->fetch('');
    }

    //教师添加单选题
    public function teacherAddSingleChoice()
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

    //教师添加判断题
    public function teacherAddTrueOrFalseIndex()
    {
        $teacher_model = model('Teacher');
        $class_info = $teacher_model->teacherFindSelfClass(session('num'));
        $this->assign('class_info', $class_info);
        $this->assign('title', '教师中心-添加判断题');
        return $this->fetch('');
    }

    //教师添加判断题
    public function teacherAddTrueOrFalse()
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

    //教师管理题
    public function teacherTestQuestionsManage()
    {
        $teacher_model = model('Teacher');
        $single_choice = $teacher_model->teacherSingleChoiceManage(session('num'));
        $this->assign('single_choice', $single_choice);     //当前教师单选题题目
        $true_or_false = $teacher_model->teacherTrueOrFalse(session('num'));
        $this->assign('true_or_false', $true_or_false);
        $this->assign('title', '教师中心-管理题目');
        return $this->fetch('');
    }

    //教师删除单选题题目
    public function teacherDeleteSingleChoice()
    {
        $single_choice_id = input('id');
        $teacher_model = model('Teacher');
        if($teacher_model->teacherDeleteSingleChoice($single_choice_id)) {
            return $this->success('删除试题成功！');
        } else {
            return $this->error('删除试题失败！');
        }
    }

    //教师编辑单选题主页
    public function teacherCompileSingleChoiceIndex()
    {
        $page = input('page');      //判断请求页，将请求页信息传给编辑主页，做返回按钮
        $this->assign('page', $page);
        $single_choice_id = input('id');
        $teacher_model = model('Teacher');
        $class_info = $teacher_model->teacherFindSelfClass(session('num'));
        $this->assign('class_info', $class_info);

        $single_choice_info = $teacher_model->teacherCompileSingleChoiceIndex($single_choice_id);
        $this->assign('single_choice_info', $single_choice_info);
        $this->assign('title', '教师中心-编辑单选题');
        return $this->fetch('');
    }

    //教师编辑单选题
    public function teacherCompileSingleChoice()
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
            return $this->success('修改试题成功！');
        } else {
            return $this->error('修改试题失败！');
        }
    }

    //教师删除判断题题目
    public function teacherDeleteTrueOrFalse()
    {
        $true_or_false_id = input('id');
        $teacher_model = model('Teacher');
        if($teacher_model->teacherDeleteTrueOrFalse($true_or_false_id)) {
            return $this->success('删除试题成功！');
        } else {
            return $this->error('删除试题失败！');
        }
    }

    //教师编辑判断题主页
    public function teacherCompileTrueOrFalseIndex()
    {
        $true_or_false_id = input('id');
        $teacher_model = model('Teacher');
        $class_info = $teacher_model->teacherFindSelfClass(session('num'));
        $this->assign('class_info', $class_info);

        $true_or_false_info = $teacher_model->teacherCompileTrueOrFalseIndex($true_or_false_id);
        $this->assign('true_or_false_info', $true_or_false_info);
        $this->assign('title', '教师中心-编辑判断题');
        return $this->fetch('');
    }

    //教师编辑判断题
    public function teacherCompileTrueOrFalse()
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
            return $this->success('修改试题成功！');
        } else {
            return $this->error('修改试题失败！');
        }
    }

    //教师查找自己的课堂
    public function teacherFindSelfClass()
    {
        $teacher_model = model('Teacher');
        if($teacher_model->teacherFindSelfClass(session('num'))) {
            $class_info = $teacher_model->teacherFindSelfClass(session('num'));
            $this->assign('class_info', $class_info);
        } else {
            return $this->error('没有课堂！');
        }
    }

    //教师查询试题主页
    public function teacherFindTestQuestionsIndex()
    {
        $this->teacherFindSelfClass();
        $this->assign('title', '教师中心-查询课堂题库');
        return $this->fetch('');
    }

    //教师查询试题
    public function teacherFindTestQuestions()
    {
        $class_num = input('class_num');
        $tool = new Tool();
        $single_choice = $tool->classNumFindAllTestQuestions($class_num)['single_choice'];
        $true_or_false = $tool->classNumFindAllTestQuestions($class_num)['true_or_false'];
        $class_name = $tool->classNumFindClass($class_num)['class_name'];
        $this->assign('class_name', $class_name);
        $this->assign('single_choice', $single_choice);
        $this->assign('true_or_false', $true_or_false);
        $this->assign('class_num', $class_num);
        $this->assign('title', '教师中心-试题');
        return $this->fetch('');
    }

    /*--------------------------------------试卷库管理--------------------------------------*/

    //教师添加试卷搜索课堂页面
    public function teacherAddPaperSearch()
    {
        $this->teacherFindSelfClass();      //查找自己的课堂
        $this->assign('title', '教师中心-添加试卷');
        return $this->fetch('');
    }

    //教师添加试卷页面
    public function teacherAddPaperIndex()
    {
        $this->teacherFindTestQuestions();
        return $this->fetch('');
    }

    //教师添加试卷
    public function teacherAddPaper()
    {
        if(input('paper_name') == null) {
            return $this->error('请输入试卷名称');
        }
        if(input('single_choice_score') == null || input('true_or_false_score') == null) {
            return $this->error('请输入分数');
        }
        $paper_name = input('paper_name');
        $class_num = input('class_num');
        $single_choice_score = input('single_choice_score');
        $true_or_false_score = input('true_or_false_score');
        if(isset(input()['single_choice'])) {
            $single_choice = input()['single_choice'];
            $single_choice_str = join('|', $single_choice);
        } else {
            return $this->error('不能没有选择题');
        }
        if(isset(input()['true_or_false'])) {
            $true_or_false = input()['true_or_false'];
            $true_or_false_str = join('|', $true_or_false);
        } else {
            return $this->error('不能没有判断题');
        }
        $tool = new Tool();
        $class = $tool->classNumFindClass($class_num);
        $teacher = model('Teacher');
        if($teacher->teacherAddPaper($paper_name, $class['teacher'], $class['teacher_num'], $class['class_name'], $class_num, $single_choice_str, $true_or_false_str, $single_choice_score, $true_or_false_score)) {
            return $this->success('添加试题成功！');
        } else {
            return $this->error('试题添加失败！');
        }
    }

    //教师查找试卷主页
    public function teacherFindPaperIndex()
    {
        $teacher_model = model('Teacher');
        $paper = $teacher_model->teacherFindSelfPaper(session('num'));
        $this->assign('paper', $paper);
        $this->assign('title', '教师中心-查找试卷');
        return $this->fetch('');
    }

    //教师查找试卷信息
    public function teacherFindPaper()
    {
        $paper_num = input('paper_num');
        $tool = new Tool();
        $paper = $tool->paperNumFindPaper($paper_num);
        $single_choice = $tool->singleChoiceStrToArr($paper['single_choice']);
        $true_or_false = $tool->trueOrFalseStrToArr($paper['true_or_false']);
        $this->assign('paper', $paper);
        $this->assign('single_choice', $single_choice);
        $this->assign('true_or_false', $true_or_false);

        //查找当前试卷没有的选择题
        $single_choice_in_class = $tool->classNumFindSingleChoice($paper['class_num']);
        foreach($single_choice_in_class as $num => $i) {
            foreach($single_choice as $j) {
                if($i['single_choice_id'] == $j['single_choice_id']) {
                    unset($single_choice_in_class[$num]);
                }
            }
        }
        $single_choice_not_exist_in_paper = array_values($single_choice_in_class);
        $this->assign('single_choice_option', $single_choice_not_exist_in_paper);

        //查找当前试卷没有的判断题
        $true_or_false_in_class = $tool->classNumFindTrueOrFalse($paper['class_num']);
        foreach($true_or_false_in_class as $num => $i) {
            foreach($true_or_false as $j) {
                if($i['true_or_false_id'] == $j['true_or_false_id']) {
                    unset($true_or_false_in_class[$num]);
                }
            }
        }
        $true_or_false_not_exist_in_paper = array_values($true_or_false_in_class);
        $this->assign('true_or_false_option', $true_or_false_not_exist_in_paper);

        $this->assign('title', '教师中心-查找试卷');
        return $this->fetch('');
    }

    //教师删除试卷
    public function teacherDeletePaper()
    {
        $paper_num = input('paper_num');
        $teacher_model = model('Teacher');
        if($teacher_model->teacherDeletePaper($paper_num)) {
            return $this->success('删除试题成功！', 'teacherFindPaperIndex');
        } else {
            return $this->error('删除试题失败！');
        }
    }

    //教师管理已删除的试卷主页
    public function teacherDeletedManageIndex()
    {
        $teacher_model = model('Teacher');
        $this->assign('paper', $teacher_model->teacherFindDeletedPaper(session('num')));
        $this->assign('title', '教师中心-已删除试卷');
        return $this->fetch('');
    }

    //教师管理已删除的试卷
    public function teacherDeletedManage()
    {
        $paper_num = input('paper_num');
        $teacher_model = model('Teacher');
        if($teacher_model->teacherRecoverPaper($paper_num)) {
            return $this->success('恢复试卷成功！');
        } else {
            return $this->error('恢复试卷失败！');
        }
    }

    //教师删除试卷中的选择题
    public function teacherDeleteSingleChoiceInPaper()
    {
        $paper_num = input('paper_num');
        $single_choice_id = input('single_choice_id');
        $tool = new Tool();
        $paper = $tool->paperNumFindPaper($paper_num);
        $single_choice = str_replace('|' . $single_choice_id, '', $paper['single_choice']);
        $teacher_model = model('Teacher');
        if($teacher_model->teacherUpdatePaperSingleChoice($paper_num, $single_choice)) {
            return $this->success('删除试题成功！');
        } else {
            return $this->error('删除试题失败！');
        }
    }

    //教师删除试卷中的判断题
    public function teacherDeleteTrueOrFalseInPaper()
    {
        $paper_num = input('paper_num');
        $true_or_false_id = input('true_or_false_id');
        $tool = new Tool();
        $paper = $tool->paperNumFindPaper($paper_num);
        $true_or_false = str_replace('|' . $true_or_false_id, '', $paper['true_or_false']);
        $teacher_model = model('Teacher');
        if($teacher_model->teacherUpdatePaperTrueOrFalse($paper_num, $true_or_false)) {
            return $this->success('删除试题成功！');
        } else {
            return $this->error('删除试题失败！');
        }
    }

    //教师给试卷添加单选题
    public function teacherAddSingleChoiceInPaper()
    {
        $paper_num = input('paper_num');
        $single_choice_str = '|';
        if(isset(input()['single_choice'])) {
            $single_choice = input()['single_choice'];
            $single_choice_str = $single_choice_str . join('|', $single_choice);
        } else {
            return $this->error('请选择要添加的题');
        }
        $teacher_model = model('Teacher');
        $tool = new Tool();
        $paper = $tool->paperNumFindPaper($paper_num);
        $single_choice_str = $paper['single_choice'] . $single_choice_str;
        if($teacher_model->teacherUpdatePaperSingleChoice($paper_num, $single_choice_str)) {
            return $this->success('添加试题成功！');
        } else {
            return $this->error('添加试题失败！');
        }
    }

    //教师给试卷添加判断题
    public function teacherAddTrueOrFalseInPaper()
    {
        $paper_num = input('paper_num');
        $true_or_false_str = '|';
        if(isset(input()['true_or_false'])) {
            $true_or_false = input()['true_or_false'];
            $true_or_false_str = $true_or_false_str . join('|', $true_or_false);
        } else {
            return $this->error('请选择要添加的题');
        }
        $teacher_model = model('Teacher');
        $tool = new Tool();
        $paper = $tool->paperNumFindPaper($paper_num);
        $true_or_false_str = $paper['true_or_false'] . $true_or_false_str;
        if($teacher_model->teacherUpdatePaperTrueOrFalse($paper_num, $true_or_false_str)) {
            return $this->success('添加试题成功！');
        } else {
            return $this->error('添加试题失败！');
        }
    }

    //教师修改单选题分数
    public function teacherChangeSingleChoiceScore()
    {
        $paper_num = input('paper_num');
        $single_choice_score = input('single_choice_score');
        $teacher_model = model('Teacher');
        if($teacher_model->teacherChangeSingleChoiceScore($paper_num, $single_choice_score)) {
            return $this->success('修改成功！');
        } else {
            return $this->error('修改失败！');
        }
    }

    //教师修改判断题分数
    public function teacherChangeTrueOrFalseScore()
    {
        $paper_num = input('paper_num');
        $true_or_false_score = input('true_or_false_score');
        $teacher_model = model('Teacher');
        if($teacher_model->teacherChangeTrueOrFalseScore($paper_num, $true_or_false_score)) {
            return $this->success('修改成功！');
        } else {
            return $this->error('修改失败！');
        }
    }

    //教师阅卷选择试卷主页
    public function teacherCheckStudentPaperSelectPaper()
    {
        $this->teacherFindPaperIndex();
        return $this->fetch('');
    }

    //教师阅卷选择学生试卷主页
    public function teacherCheckStudentPaperSelectStudentPaper()
    {
        $paper_num = input('paper_num');
        $teacher_model = model('Teacher');
        $student_paper = $teacher_model->teacherCheckStudentPaperSelectStudentPaper($paper_num);
        $tool = new Tool();
        $paper = $tool->paperNumFindPaper($paper_num);
        $this->assign('paper', $paper);
        $this->assign('student_paper', $student_paper);
        $this->assign('title', '选择答卷');
        return $this->fetch('');
    }

    public function teacherCheckStudentPaper()
    {
        $student_answer_paper_id = input('student_answer_paper_id');
        $tool = new Tool();
        $answer_paper = $tool->studentAnswerPaperIdFindPaper($student_answer_paper_id);
        $paper = $tool->paperNumFindPaper($answer_paper['paper_num']);
        $single_choice = $tool->singleChoiceStrToArr($answer_paper['single_choice']);
        $true_or_false = $tool->trueOrFalseStrToArr($answer_paper['true_or_false']);
        $single_choice_answer = explode('-', $answer_paper['student_answer'])[0];
        $single_choice_answer = explode('|', $single_choice_answer);
        $true_or_false_answer = explode('-', $answer_paper['student_answer'])[1];
        $true_or_false_answer = explode('|', $true_or_false_answer);

        foreach($single_choice as $num => $i) {
            if($single_choice_answer[$num] == $i['answer']) {
                $single_choice[$num]['judge'] = 'true';
                $single_choice[$num]['student_answer'] = $single_choice_answer[$num];
            } else {
                $single_choice[$num]['judge'] = 'false';
                $single_choice[$num]['student_answer'] = $single_choice_answer[$num];
            }
        }
        foreach($true_or_false as $num => $i) {
            if($true_or_false_answer[$num] == $i['answer']) {
                $true_or_false[$num]['judge'] = 'true';
                $true_or_false[$num]['student_answer'] = $true_or_false_answer[$num];
            } else {
                $true_or_false[$num]['judge'] = 'false';
                $true_or_false[$num]['student_answer'] = $true_or_false_answer[$num];
            }
        }
        $this->assign('sum_score',$answer_paper['sum_score']);
        $this->assign('score',$answer_paper['score']);
        $this->assign('paper', $paper);
        $this->assign('single_choice',$single_choice);
        $this->assign('true_or_false',$true_or_false);
        $this->assign('title','教师阅卷');
        return $this->fetch('');
    }
}