<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 17-5-11
 * Time: 下午4:02
 */
namespace Manage\Controller;

use Think\Controller;

class CommonController extends Controller
{
    /*系统相关记录查看时间限制*/
    protected $timeLimit;
    /*系统权限节点字符串*/
    protected $rules;
    /*用户职位*/
    protected $position;
    /*用户部门*/
    protected $dept;
    /*用户id*/
    protected $staffId;
    /*dataTables 数据表输出数组*/
    protected $output;
    /* 前端数据接收post数据*/
    protected $posts;
    /* 数据表查询sql条件中字段限制*/
    protected $field;
    /* dataTables 根据前端输入得到的sql查询条件*/
    protected $sqlCondition;
    /* 数据表where条件*/
    protected $whereCondition;
    protected $keyFilter;
    /**
     * 构造方法：执行权限判断以及一些属性的赋值操作
     * 本构造方法是所有其他子类都继承的
     * 功能1 ： 判断session中是否有用户id（PublicController中loginOk后，会存session
     * 功能2 ： 读取数据表中设置的timeLimit字段后赋值给 protected $timeLimit
     * 功能3 ： 判断权限 ：判断是否有审核权限： 有权限给用户增加对应权限；当前的ACTION_NAME 是否在数据表中auth_ids中
     * 功能4 ： sphinx中文分词类的加载
    */
    public function _initialize()
    {
        require_once('sphinxapi.php');
        // 判断session是否存在
        $this->staffId = empty($this->staffId) ? (int)session('staffId') : $this->staffId;
//        if (empty($this->staffId)) {
//            // 如果没有登录，则进行跳转
//            $url = U('Public/login');
//            // header("Location:$url");exit;
//            // 通过javascript代码实现
//            $script = "<script>window.top.location.href='$url';</script>";
//            echo $script;exit;
//        }


        $controllerName = strtolower(CONTROLLER_NAME);//控制器
        $actionName = strtolower(ACTION_NAME);//方法

//        if(!in_array($cname . '/*',$auth) && !in_array($cname . '/' . $aname,$auth)){
//            if (IS_AJAX) {
//                $this->returnAjaxMsg('无权使用该功能，如有问题请联系管理', 403);
//            } else {
//                $this->redirect('Public/403');exit;
//            }
//
//        }
    }


    protected function staffLog()
    {
        // $Ip = new \Org\Net\IpLocation('qqwry.dat'); // 实例化类 参数表示IP地址库文件
        // $area = $Ip->getlocation($_SERVER['REMOTE_ADDR']); // 获取某个IP地址所在的位置
        // RBAC权限判断
        $thisRule = strtolower(CONTROLLER_NAME) . "/" . strtolower(ACTION_NAME);
        $authFilter['rule_string'] = array('LIKE', "%". $thisRule . "%");
        $data = M('auth_rule')->where($authFilter)->field('rule_name auth_rule_name,log_level level')->order('log_level desc')->find();
        $data['staffid'] = $this->staffId;
        $data['remote_addr'] = $_SERVER['REMOTE_ADDR'];
        $data['request_uri'] = $thisRule;
        $data['request_time'] = time();
        //$data['ip_location']  = iconv('gbk','utf-8',$area['country'].$area['area']);
        $data['user_agent']  = $_SERVER['HTTP_USER_AGENT'];
        if (IS_POST) {
            $data['request_method'] = "POST";
            $data['request_info'] = json_encode(I('post.'));
        } elseif (IS_GET) {
            $data['request_method'] = "GET";
            $data['request_info'] = json_encode(I('get.'));
        } else {
            $data['request_method'] = "NONE";
        }
        return $data;
    }

    protected function returnAjaxMsg($msg, $status, $data =[])
    {
        $data = array(
            'msg'    => $msg,
            'status' => $status,
            'data'   => $data
        );
        $this->ajaxReturn($data);
    }

    /**
     * @name getSqlCondition
     * @abstract 利用dataTables通过post得到的数据$data返回sql查询条件
     * @param array $data 包含$data['order']排序 $data['columns']查询的字段名 $data['start']|$data['length']查询limit字段 $data['search']查询的搜索条件
     * @return array $sqlCondition 输入多为表格列索引 进行处理后返回实际字段名。
    */
    protected function getSqlCondition($data)
    {
        $sqlCondition = array();
        $order_dir    = $data['order']['0']['dir'];//ase desc 升序或者降序
        $order_column = (int)$data['order']['0']['column'];
        $sqlCondition['order'] = $data['columns'][$order_column]['data'] . " " . $order_dir;
        $limitFlag  = isset($data['start']) && $data['length'] != -1 ;
        if ($limitFlag) {
            $sqlCondition['start']  = (int)$data['start'];
            $sqlCondition['length'] = (int)$data['length'];
        } else {
            $sqlCondition['start']  = 0;
            $sqlCondition['length'] = 10;
        }
        //搜索
        $sqlCondition['search'] = $data['search']['value'];//获取前台传过来的过滤条件
        return $sqlCondition;
    }

    /**
     * @name getDataTableOut
     * @abstract 返回DataTables 需要的数据
     * @param int $draw 表格加载的次数
     * @param int $count 筛选前的总数
     * @param int $recordsFiltered 关键词筛选后的数量
     * @param array $content 要返回给前端并加载的数据
     * @return array $out 返回的数据
    */
    protected function getDataTableOut($draw,$count,$recordsFiltered,$contents)
    {
        return $out = array(
            "draw"            => intval($draw),
            "recordsTotal"    => $count,
            "recordsFiltered" => $recordsFiltered,
            "data"            => $contents
        );
    }

    /**
     * @name get_amount
     * @abstract 数字金额转换成中文大写金额的函数
     * @param mixed  $num  要转换的小写数字或小写字符串
     * @return string 大写的金额
     * 小数位为两位
     * @todo 此方法需要封装在function中而不是在Controller里
     **/
    protected function get_amount($num)
    {
        $c1 = "零壹贰叁肆伍陆柒捌玖";
        $c2 = "分角圆拾佰仟万拾佰仟亿";
        $num = round($num, 2);
        $num = $num * 100;
        if (strlen($num) > 10) {
            return "数据太长，没有这么大的钱吧，检查下";
        }
        $i = 0;
        $c = "";
        while (1) {
            if ($i == 0) {
                $n = substr($num, strlen($num)-1, 1);
            } else {
                $n = $num % 10;
            }
            $p1 = substr($c1, 3 * $n, 3);
            $p2 = substr($c2, 3 * $i, 3);
            if ($n != '0' || ($n == '0' && ($p2 == '亿' || $p2 == '万' || $p2 == '圆'))) {
                $c = $p1 . $p2 . $c;
            } else {
                $c = $p1 . $c;
            }
            $i = $i + 1;
            $num = $num / 10;
            $num = (int)$num;
            if ($num == 0) {
                break;
            }
        }
        $j = 0;
        $slen = strlen($c);
        while ($j < $slen) {
            $m = substr($c, $j, 6);
            if ($m == '零圆' || $m == '零万' || $m == '零亿' || $m == '零零') {
                $left = substr($c, 0, $j);
                $right = substr($c, $j + 3);
                $c = $left . $right;
                $j = $j-3;
                $slen = $slen-3;
            }
            $j = $j + 3;
        }

        if (substr($c, strlen($c)-3, 3) == '零') {
            $c = substr($c, 0, strlen($c)-3);
        }
        if (empty($c)) {
            return "零圆整";
        }else{
            return $c . "整";
        }
    }

    protected function initDingSDK()
    {
        ini_set('memory_limit', '500M'); //内存限制
        set_time_limit(0); //执行超时，0代表无限等待
        require_once C('DING_SDK_LOAD');
    }

    protected function getToken()
    {
        $key = C('DING_ID');
        $pwd = C('DING_KEY');
        $curl = curl_init("https://oapi.dingtalk.com/gettoken?appkey=$key&appsecret=$pwd");
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //设置post方式提交
        //执行命令
        $html  = curl_exec($curl);
        $error = curl_error($curl);
        //关闭URL请求
        curl_close($curl);
        $tokenObj = json_decode($html);
        if ($tokenObj->errcode) {
            return false;
        }
        return $tokenObj->access_token;
    }



}
