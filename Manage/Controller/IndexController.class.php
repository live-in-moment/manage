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
        $data = $staffModel->getOneStaffDetailedInfo();
        $this->assign('data', $data);
        $this->display();
    }
    public function home(){
        $this -> display();
    }
}
