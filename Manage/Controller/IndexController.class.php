<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 17-5-11
 * Time: 上午10:21
 */

namespace Manage\Controller;

use Manage\Model\StaffModel;
use Think\Controller;
// 首页
class IndexController extends CommonController
{


    public function _initialize()
    {
        parent::_initialize();
    }

    public function index()
    {
        $map['s.id'] = array('EQ', session('staffId'));
        $staffModel = new StaffModel();
        $data = $staffModel->getOneStaffDetailedInfo($map);
        $this->assign('data', $data);
        $this->display();
    }
    public function home(){
        $this -> display();
    }

    public function editPhone()
    {
        $staffModel = new StaffModel();
        if (IS_AJAX) {
            $posts = I('post.');
            $map['id'] = array('EQ', session('staffId'));
            $newPhone['mobilephone'] = $posts['newphone'];
            $rst = M('staff')->where($map)->setField($newPhone);
            if ($rst !== false) {
                $this->returnAjaxMsg("修改手机号成功",200);
            } else {
                $this->returnAjaxMsg("修改手机号失败",400);
            }
        } else {
            $map['id'] = array('EQ', session('staffId'));
            $data = $staffModel->where($map)->field('name, mobilephone')->find();
            $this->assign('data', $data);
            $this->display();
        }
    }

    /**
     * 判断密码是否一致
     */
    public function checkPwd()
    {
        $oldPwd = I('post.oldpwd');
        $map['id'] = array('EQ', session('staffId'));
        $rst = M('staff')->where($map)->find();
        $password = $rst['pwd'];
        $rst = password_verify($oldPwd, $password);
        if ($rst != false) {
            $this->returnAjaxMsg("密码一致",200);
        } else {
            $this->returnAjaxMsg("原密码输入错误，请重新输入",400);
        }
    }

    public function changePwd()
    {
        $password = I('post.newpwd');

        // 密码加密存储
//        $salt = base64_encode(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
        $salt = base64_encode(random_bytes(32)); //php7可用
        // php5.5以上支持的密码加密
        $options = [
            'salt' => $salt,
            'cost' => 12,
        ];
        $hash = password_hash($password, PASSWORD_DEFAULT, $options);
        $data['pwd']  = $hash;
        $data['salt'] = $salt;

        $map['id'] = array('EQ', session('staffId'));
        $rst = M('staff')->where($map)->save($data);
        if ($rst !== false) {
            session(null);
            $this->returnAjaxMsg("修改密码成功，请试用新密码重新登陆",200);
        } else {
            $this->returnAjaxMsg("修改密码失败",400);
        }
    }
}
