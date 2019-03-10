<?php

/**
 * @ Purpose:
 * 登录 退出操作类
 * @Package Name: Database
 * @Author: Maxu maxu@Manage.com.cn
 * @Tim e : 20180308
 * captcha 验证码生成
 * loginok 登录验证
 */
namespace Manage\Controller;

use Manage\Model\StaffModel;
use Think\Controller;
use Think\Verify;
// 登录及首页跳转功能实现
class PublicController extends Controller
{
    /* 验证码配置*/
    protected $config;
    /* 前端提交数据*/
    protected $post;

    /**
     * 登录验证验证码
     * @param int $fontsize 验证码字体大小(px)
     * @param boolean $curveFlag 验证码字体大小(px)
     * @param boolean $noiseFlag 是否添加杂点
     * @param int $height 高度
     * @param int $width 宽度
     * @param int $length 验证码位数
     * @param string $fontTtf 字体
     * @return array $config 验证码类的配置数组
    */
    protected function getCaptchaConfig($fontsize = 10, $curveFlag = false, $noiseFlag = false, $height = 38, $width = 80, $length = 4, $fontTtf = "4.ttf")
    {
        return $config =  array(

            'fontSize'  =>  $fontsize,              // 验证码字体大小(px)
            'useCurve'  =>  $curveFlag,            // 是否画混淆曲线
            'useNoise'  =>  $noiseFlag,            // 是否添加杂点
            'imageH'	=>	$height,
            'imageW'	=>	$width,
            'length'    =>  $length,               // 验证码位数
            'fontttf'   =>  $fontTtf,              // 验证码字体，不设置随机获取
        );

    }

    /**
     * 生成登录验证验证码方法
     * @return mixed 输出验证码图到前端
     */
    public function captcha()
    {
        #配置
        ob_end_clean();
        $this->config = $this->getCaptchaConfig();
        #实例化验证
        $verify = new Verify($this->config);
        #生成输出保存验证码
        $verify->entry();
    }

    /**登录验证
     * 存储session
     */
    public function loginOk()
    {
	// 实例化模型
        $staffModel = new StaffModel();
        $this->post  = I('post.');

        $returnData = [
            'status' => 200,
            'msg' => '登陆成功,欢迎您试用此管理系统',
        ];
        // 验证码的验证功能实现
//        $verify = new Verify();
//        $rst = $verify->check($this->post['captcha']);


        // 1 验证码检测逻
//        if ($rst !== false)
//        {
            // 2 用户名检测逻辑
            $userMap['username'] = ['EQ', $this->post['username']];

            $staffInfo = $staffModel->getOneStaffInfo($userMap);

            if (!empty($staffInfo)) {
                $filter['id'] = ['eq', $staffInfo['id']];
                switch ($staffInfo['login_status']) {
                    case StaffModel::LOCKED_LOGIN_AUTH :
                        $returnData = [
                            'status' => 402,
                            'msg' => '当前用户被锁定，请联系系统管理员修改密码',
                        ];
                    case StaffModel::NORMAL_LOGIN_AUTH :
                        $saveData = [];
                        $rst = password_verify($this->post['password'], $staffInfo['pwd']);
                        $saveData['login_addr'] = $_SERVER['REMOTE_ADDR'];
                        $saveData['last_login_time'] = $_SERVER['REQUEST_TIME'];
                        if ($rst == false) {
                            // 错误
                            $saveData['error_count'] = $staffInfo['error_count'] + 1;
                            if ($saveData['error_count'] >= 5) {
                                $saveData['login_status'] = StaffModel::LOCKED_LOGIN_AUTH;
                                $returnData = [
                                    'status' => 405,
                                    'msg' => '当前用户输入密码错误已达到五次，此用户已被锁定，请联系系统管理员修改密码！',
                                ];
                            }else{
                                $returnData = [
                                    'status' => 406,
                                    'msg' => '当前用户输入密码错误，请重新输入！',
                                ];
                            }
                        } else {
                            // 密码正确,错误次数置为0
                            $saveData['error_count'] = 0;

                            // session存权限
                            // 用户名密码正确，存重要信息于session
                            session(null);
                            $data = $staffModel->getOneStaffDetailedInfo(['s.id' => ['eq', $staffInfo['id']]]);
                            session('staffId', $data['id']);
                            session('nickname', $data['name']);
                            session('deptId', $data['dept_id']);
                            session('postId', $data['post_id']);
                        }
                        $staffModel->where($filter)->setField($saveData);
                        break;
                    default :
                        $returnData = [
                            'status' => 403,
                            'msg' => '当前用户信息错误，请联系管理员',
                        ];
                }
            } else {
                $returnData = [
                    'status' => 401,
                    'msg' => '此系统无当前用户名，请重新输入',
                ];
            }

//        } else {
//            // 验证码错误
           $msg = 1;
//            $returnData = [
//                'status' => 404,
//                'msg' => '验证码输入错误，请重新输入验证码！',
//            ];
//        }
        $this->ajaxReturn($returnData);
    }


    /**
     * 登录页面模板跳转
    */
    public function login()
    {
        $this->display('login');
    }

    public function logout()
    {
        // 删除全部的session
        session(null);
        // 跳转到登录页
        $this->redirect("Public/login");exit;
    }

    public function te()
    {
        for($t=0;$t<360;$t++)
        {
            $y=2*cos($t)-cos(2*$t); //笛卡尔心形曲线函数
            $x=2*sin($t)-sin(2*$t);
            $x+=3;
            $y+=3;
            $x*=70;
            $y*=70;
            $x=round($x);
            $y=round($y);
            $str[]=$x;
            $y=$y+2*(180-$y);//图像上下翻转
            $x=$y;
            $str[]=$x;
        }
        $im=imagecreate(400,400);//创建画布400*400
        $black=imagecolorallocate($im,0,0,0);
        $red=imagecolorallocate($im,255,0,0);//设置颜色
        imagepolygon($im,$str,180,$red);
        imagestring($im,5,190,190,"whoyaf",$red);//输出字符串
        header('Content-type:image/gif');//通知浏览器输出的是gif图片
        imagegif($im);//输出图片
        imagedestroy($im);//销毁
    }

}
