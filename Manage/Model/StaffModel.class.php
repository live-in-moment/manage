<?php
/**
 * Created by PhpStorm.
 * User: chendongdong
 * Date: 2019/3/10
 * Time: 2:12 PM
 */

namespace Manage\Model;


use Think\Model;

class StaffModel extends Model{
    const TYPE_INTERN = 1; // 实习期
    const TYPE_PERIOD = 2; // 试用期
    const TYPE_FORMAL = 3; // 正式员工
    const TYPE_QUIT = 4; // 离职

    /*用户账户状态正常*/
    const NORMAL_LOGIN_AUTH = 1;
    /*用户账户锁定*/
    const LOCKED_LOGIN_AUTH = 2;


    public static $staffType = [
        self::TYPE_INTERN => '实习期',
        self::TYPE_PERIOD => '试用期',
        self::TYPE_FORMAL => '正式员工',
        self::TYPE_QUIT => '离职',
    ];


    public function getOneStaffInfo($map = []){
        return $this->where($map)->find();
    }

    public function getOneStaffDetailedInfo($map = []){
        $data = $this->alias("s")
            ->field('s.*, d.name dept_name, p.name post_name')
            ->where($map)
            ->join('LEFT JOIN `crm_dept` d ON d.id = s.dept_id')
            ->join('LEFT JOIN `crm_post` p ON p.id = s.post_id')
            ->find();
        return $data;
    }
}