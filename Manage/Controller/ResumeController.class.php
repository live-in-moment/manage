<?php
/**
 * Created by PhpStorm.
 * User: chendongdong
 * Date: 2019/3/10
 * Time: 6:33 PM
 */

namespace Manage\Controller;

use Manage\Model\StaffModel;
use Think\Controller;
// 首页
class ResumeController extends CommonController{
    // 渲染简历查看页面
    public function resumeIndex(){
        // 获取当前登陆人的部门
        $deptId = session("deptId");

        if (empty($deptId)){
            die("当前登陆人无部门，请联系管理员查看");
        }

        if ($deptId == 2){
            // 人力资源部
            $this->display("hrSearchResume");
        }else {
            $this->display("deptSearchResume");
        }
    }

    public function getHrSearchResumeList(){

    }

    public function getDeptSearchResumeList(){

    }
}