<?php
/**
 * Created by PhpStorm.
 * User: ml
 * Date: 2017/6/9
 * Time: 19:33
 */
function editData($data, $res, $dataPrjId, $resPrjId, $num, $ids)
{
    $dataCount =  count($data);
    $resCount =  count($res);
    // 两个二维数组长度不同，则,获取不同的proid; 对$res添加project_id
    if ($dataCount != $resCount) {
        $nulls = $dataCount - $resCount;
        // 所有id获取
        foreach ($ids as $item) {
            $totalIds[] = $item[$dataPrjId];
        }

        // res中的id获取
        foreach ($res as $item) {
            $resIds[] = $item[$resPrjId];
        }
        // 比较两数组，找出resIds缺少的值
        $resultIds = array_diff($totalIds, $resIds);
        foreach ($resultIds as $item) {
            $resultId[] = $item;
        }


        for ($i = 1; $i <= $nulls; $i++) {
            $res[$resCount + $i - 1][$resPrjId] = $resultId[$i - 1];
            $res[$resCount + $i - 1][$num] = 0;
        }
    }

    foreach($data as $val) {
        foreach($res as $key2 => $val2){
            if ($val[$dataPrjId] == $val2[$resPrjId]) {
                $fin[] = array_merge_recursive($val,$val2);
            }
        }
    }
    return $fin;
}

function getPrjIds($ids, $key)
{

    // (2)二维数组转成字符串，以','连接
    foreach ($ids as $k => $val) {
        $proId .= $val[$key] . ",";
    }
    $proId = substr($proId, 0, strlen($proId) - 1);
    return $proId;
}

// 递归无限极分类
function getTree($list,$pid=0,$level=0,$key) {
    static $tree = array();
    foreach($list as &$row) {
        if($row[$key]==$pid) {
            $row['level'] = $level;
            $tree[] = $row;
            getTree($list, $row['id'], $level + 1,$key);
        }
    }
    return $tree;

}

// 查找一级分类
function getCate($list,$id) {
    static $cate = array();
    foreach($list as &$row) {
        if($row['id']==$id) {
            $cate = $row;
            getCate($list, $row['pid']);
        }
    }
    return $cate;
}

//获取所有业务，包含市场、销售、客服部门
function getSaleman($list,$pid,$key) {
    static $tree = array();
    foreach($list as &$row) {
        if($row[$key]==$pid) {
            $tree[] = $row;
            getSaleman($list, $row['role_id'], $key);
        }
    }
    return $tree;
}

//获取所有维修专员+研发
function getRepersonman($list,$pid,$key) {
    static $tree = array();
    foreach($list as &$row) {
        if($row[$key]==$pid) {
            $tree[] = $row;
            getRepersonman($list, $row['role_id'], $key);
        }
    }
    return $tree;
}

//获取含有客户的部门
function getSaledept($role_id,$list,$key) {
    if(is_string($role_id)){
        $array = explode(",", $role_id);
        $count = count($array);
        for ($i=0; $i < $count; $i++) {
            $message = getSaleman($list,$array['i'],$key);
        }
        return $message;
    }
}

function setValue($name,$posts)
{
    return $posts[$name] = isset($posts[$name]) ? $posts[$name] : 0;
}

/*
 * 安全过滤函数
 * 函数名：inject_filter
 * 对表单提交所有数据过滤危险字段*/
function inject_filter($data)
{
    $data = strtolower($data);
    $data = strip_tags(trim($data));
    $pattern = array(
        'select','insert','update','delete','and','or','where','join','*','=','union','into','load_file','outfile','/','\''
    );
    $data = str_replace($pattern, "", $data);
    return $data;
}

/*
 * 过滤get的id
 * 函数名：inject_id_filter*/
function inject_id_filter($id)
{
    if (!$id) {
        exit();
    } elseif (!is_numeric($id)) {
        exit();
    }
    $id = (int)$id;
    return $id;
}


/**
 * 导入excel文件
 * @param  string $file excel文件路径
 * @return array       excel文件内容数组
 */
function import_excel($file){
    // 判断文件是什么格式
    $type = pathinfo($file);
    $type = strtolower($type["extension"]);
    $type=$type==='csv' ? $type : 'Excel5';
    ini_set('max_execution_time', '0');
    Vendor('PHPExcel.PHPExcel');
    // 判断使用哪种格式
    $objReader = PHPExcel_IOFactory::createReader($type);
    $objPHPExcel = $objReader->load($file);
    $sheet = $objPHPExcel->getSheet(0);
    // 取得总行数
    $highestRow = $sheet->getHighestRow();
    // 取得总列数
    $highestColumn = $sheet->getHighestColumn();
    //循环读取excel文件,读取一条,插入一条
    $data=array();
    //从第一行开始读取数据
    for($j = 1; $j <= $highestRow; $j++){
        //从A列读取数据
        for($k='A'; $k <= $highestColumn; $k++){
            // 读取单元格
            $data[$j][]=$objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
        }
    }
    return $data;
}

/**
 * 数组转xls格式的excel文件
 * @param  array  $data      需要生成excel文件的数组
 * @param  string $filename  生成的excel文件名
 *      示例数据：
$data = array(
array(NULL, 2010, 2011, 2012),
array('Q1',   12,   15,   21),
array('Q2',   56,   73,   86),
array('Q3',   52,   61,   69),
array('Q4',   30,   32,    0),
);
 */
function create_xls($data, $filename = 'simple.xls'){
    ini_set('max_execution_time', '0');
    Vendor('PHPExcel.PHPExcel');//引入类
    $filename = str_replace('.xls', '', $filename) . '.xls';
    $phpexcel = new PHPExcel();
    $phpexcel->getProperties()
        ->setCreator("Maxu Manage")
        ->setLastModifiedBy("Maarten Balliauw")
        ->setTitle("Office 2007 XLSX Document")
        ->setSubject("Office 2007 XLSX Document")
        ->setDescription("document for Office 2007 XLSX, generated using PHP classes.")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Test result file");
    $phpexcel->getActiveSheet()->fromArray($data);
    $phpexcel->getActiveSheet()->setTitle('Sheet1');
    $phpexcel->setActiveSheetIndex(0);
    /*header('Content-Type: application/vnd.ms-excel');
    header("Content-Disposition: attachment;filename=$filename");
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header ('Pragma: public'); // HTTP/1.0*/
    $objwriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel5');
    $rootPath = WORKING_PATH . UPLOAD_ROOT_PATH . "/excelUpload/";
    $rst['res'] = $objwriter->save($rootPath . "sdjf.xls");
    $rst['data'] = $objwriter;
    $rst['name'] = "sdjf";
    return $rst;
}

/**
 * 根据员工姓名获取员工id
 * @param $staffName    string  员工姓名
 * @return int  员工id
 */
function getStaffIdByStaffName($staffName){
    $map = ['name' => ['EQ', $staffName]];
    $res = M('staff') -> where ($map) -> getField('id');
    if ($res == null){
        $res = 0;
    }
    return $res;
}

/**
 * 根据职工id获得职工姓名
 * @param $staffID
 * @return string
 */
function getStaffNameByStaffID($staffID){
    $map = ['id' => ['EQ', $staffID]];
    $res = M('staff') -> where ($map) -> getField('name');
    if ($res == null){
        $res = '';
    }
    return $res;
}

/**
 * 根据产品型号获取仓库信息
 * @param $productName    int     产品型号
 * @return array
 */
function getWarehouseInfo($productName){
    $map = [
        'product_name' => ['EQ', $productName]
    ];
    $res = M('industrial_seral_screen') -> field('warehouse_name, warehouse_number') -> where($map) -> find();
    return $res;
}

/**
 * 根据产品名获得产品id
 * @param $productName
 * @return int
 */
function getProductIDByProductName($productName){
    $map = [
        'product_name' => ['EQ', $productName]
    ];
    $res = M('industrial_seral_screen') -> where($map) -> getField('product_id');
    if ($res == null){
        $res = 0;
    }
    return $res;
}


//创建TOKEN
function createToken() {
    session('TOKEN', NULL);
    $code = chr(mt_rand(0xB0, 0xF7)) . chr(mt_rand(0xA1, 0xFE)) . chr(mt_rand(0xB0, 0xF7)) . chr(mt_rand(0xA1, 0xFE)) . chr(mt_rand(0xB0, 0xF7)) . chr(mt_rand(0xA1, 0xFE));
    session('TOKEN', authCode($code));
}

//判断TOKEN
function checkToken($token) {
    if ($token == session('TOKEN')) {
        session('TOKEN', NULL);
        return TRUE;
    } else {
        return FALSE;
    }
}

/* 加密TOKEN */
function authCode($str) {
    $key = "MANAGEERP";
    $str = substr(md5($str), 8, 10);
    return md5($key . $str);
}

function checkAdvancedSearch($map){
    $map = strtolower($map);
    $mapArr = ['eq', 'neq', 'gt', 'egt', 'lt', 'elt', 'like', 'between', 'in', 'not in', 'not between'];
    return in_array($map, $mapArr) ? true : false;
}
function getAdvancedCondition($data, $filterMap = [])
{
    $whereOption = trim($data['option']);
    $map = [];
    $dataCount = count($data['condition']);
    for ($i = 0; $i < $dataCount; $i++) {

        if (empty($data['condition'][$i]['value'])) {
            continue;
        } else {
            if (checkAdvancedSearch($data['condition'][$i]['map'])) {
                if ($filterMap && (!empty($filterMap[$data['condition'][$i]['key']]))) {
                    $data['condition'][$i]['key'] = $filterMap[$data['condition'][$i]['key']];
                }
                $map[$data['condition'][$i]['key']] = $data['condition'][$i]['$map'] == 'LIKE'
                    ? [$data['condition'][$i]['map'], '%' . trim($data['condition'][$i]['value']) . '%']
                    : [$data['condition'][$i]['map'], trim($data['condition'][$i]['value'])];
            } else {
                continue;
            }
        }
    }

    if (count($map)) {
        $map['_logic'] = $whereOption;
    }
    return $returnData = (count($map) == 0)
        ? ['status' => 400, 'data' => $map]
        : ['status' => 200, 'data' => $map];
}

function checkChange($oldData, $postData,$changeArray)
{
        $flag       = [];
        $msg        = "";
        foreach( $changeArray as $key => $item) {
            $flag[$key] = $oldData[$item] == $postData[$item] ? false : true;
            if ($flag[$key]) {
                $msg  .= "修改数据：" . $item . "(" . $oldData[$item] . "改为" . $postData[$item] . ")" . "修改人" . session('nickname')."修改时间：" . date('Y-m-d H:i:s') . ";";
            }
        }
        return $data = [
            'flag' => $flag,
            'msg'  => $msg
        ];

}

function getCusStatisticsConfig($start,$end)
{

    $config = [];
    $flag = empty($start) && empty($end);
    if ($flag) {
        $config['endDay'] = strtotime(date('Y-m'));
        $config['startDay']   = (date('m') - 3 <= 0)
                                    ? strtotime((date('Y') - 1) . "-" . (date('m') - 3 + 12))
                                    : strtotime((date('Y')) . "-" . (date('m') - 3));

    } else {
        $config['startDay'] = strtotime($start);
        $config['endDay']   = strtotime($end);
    }

    $config['startM'] = date('m', $config['startDay']);
    $config['endM']   = date('m', $config['endDay']);
    $config['startYear'] = date('Y', $config['startDay']);
    $config['endYear']   = date('Y', $config['endDay']);
    return $config;
}

function getYearMonth($startYear, $i)
{
    for ($n = 100; $n >= 1; $n--) {
        if ($i > (12 * $n)) {
            $i -= 12 * $n;
            $startYear += $n;

            return $startYear . '-' . $i;

        }
    }
    return $startYear . '-' . $i;
}


function arr_sort($array,$key,$order="asc"){//asc是升序 desc是降序
    $arrNum = $arr = array();
    foreach($array as $k => $v){
        $arrNum[$k] = $v[$key];
    }
    if($order=='asc'){
        asort($arrNum);
    } else {
        arsort($arrNum);
    }
    foreach($arrNum as $k=>$v){
        $arr[]=$array[$k];
    }
    return $arr;
}

function getFilterDataWithPid($array, $compareValue, $compareKey, $sortKey, $order)
{
    $returnPreArray = [];
    foreach ($array as $k => $v) {
        if ($v[$compareKey] == $compareValue) {
            $returnPreArray[] = $array[$k];
        }
    }
    return arr_sort($returnPreArray, $sortKey, $order);
}

/**
 * @param int $length
 * @return int 生成指定长度的随机数
 */
function get_random($length = 20)
{
    $min = pow(10, ($length - 1));
    $max = pow(10, $length) - 1;
    return mt_rand($min, $max);
}


/**
 *  重构数组，将指定当前数组一列的值当作key，这一列当作value
 * @param $arr
 * @param $k
 * @return array
 */
function reformArray($arr, $k)
{
    $data = [];
    foreach ($arr as $key => $item){
        $data[$item[$k]] = $item;
    }
    return $data;
}

function file_list($path)
{
    static $data = array();
    if ($handle = opendir($path))//打开路径成功
    {
        while (false !== ($file = readdir($handle)))//循环读取目录中的文件名并赋值给$file
        {
            if ($file != "." && $file != "..")//排除当前路径和前一路径
            {
                if (is_dir($path."/".$file))
                {
//                    echo $path.": ".$file."<br>";//去掉此行显示的是所有的非目录文件
                    file_list($path."/".$file);
                }
                else
                {
                    $data[] = $path."/".$file;
                }
            }
        }
        return $data;
    } else {
        dump(2);
    }
}

function returnDieHtml($string)
{
    $html = "<h3 style='text-align: center;margin-top: 25%;'>";
    $html .= $string;
    $html .="</h3>";
    return $html;
}

function arrayIntersect($arrayA, $arrayB) {
    if(!isset($arrayA) || !isset($arrayB) || !is_array($arrayA) || !is_array($arrayB) ||empty($arrayA) || empty($arrayB))
        return false;
    $intersect= array_intersect($arrayA,$arrayB);
    if (count($intersect) === 0)
        return false;
    return true;
}


// 验证身份证号码
function is_idcard($idCard)
{
    $idCard = strtoupper($idCard);
    $arr_split = [];
    $regx = "/^(\d{6})+(\d{4})+(\d{2})+(\d{2})+(\d{3})([0-9]|X)$/";
    if (!preg_match($regx, $idCard)) {
        return [FALSE, '', ''];
    }
    @preg_match($regx, $idCard, $arr_split);
    $dtm_birth = $arr_split[2] . '-' . $arr_split[3] . '-' . $arr_split[4];
    if (!strtotime($dtm_birth)) //检查生日日期是否正确
    {
        return [FALSE, '', ''];
    }

    // 判断性别
    $sexFlag = (int)substr($idCard,16,1);
    if($sexFlag % 2 == 0){
        $sex = '女';
    }else {
        $sex = '男';
    }

    return [true, strtotime($dtm_birth), $sex];
}


/**
 * utf8字符转换成Unicode字符
 * @param  [type] $utf8_str Utf-8字符
 * @return [type]           Unicode字符
 */
function utf8_str_to_unicode($utf8_str) {
    $unicode = 0;
    $unicode = (ord($utf8_str[0]) & 0x1F) << 12;
    $unicode |= (ord($utf8_str[1]) & 0x3F) << 6;
    $unicode |= (ord($utf8_str[2]) & 0x3F);
    return dechex($unicode);
}

/**
 * Unicode字符转换成utf8字符
 * @param  [type] $unicode_str Unicode字符
 * @return [type]              Utf-8字符
 */
function unicode_to_utf8($unicode_str) {
    $utf8_str = '';
    $code = intval(hexdec($unicode_str));
    //这里注意转换出来的code一定得是整形，这样才会正确的按位操作
    $ord_1 = decbin(0xe0 | ($code >> 12));
    $ord_2 = decbin(0x80 | (($code >> 6) & 0x3f));
    $ord_3 = decbin(0x80 | ($code & 0x3f));
    $utf8_str = chr(bindec($ord_1)) . chr(bindec($ord_2)) . chr(bindec($ord_3));
    return $utf8_str;
}

/**
 * 根据字段名处于的type类型进行数据的增减
 * @param array $datum sql查到的二维数组遍历得到的一行数据，根据此一行数据结合type进行data['fieldName']的增减；
 * @param array $typeArray fileName所处的可能的类型数组，sumType求和  minusType求差
 * @param string $fieldName $datum中要处理的字段
 * @return $tmp 统计得到的数字
*/
function returnPerformanceNum($datum, $typeArray, $fieldName) {
    $tmp = 0;
    foreach ($datum as $key => $item) {
        if (in_array($key, array_column($typeArray['sum'], $fieldName))) {
            $tmp += $item;
        }
        if (in_array($key, array_column($typeArray['minus'], $fieldName)))
            $tmp -= $item;
    }
    return $tmp;
}

function getAmountChina($num)
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
function showImg($img)
{
    $info = getimagesize($img);
    $imgExt = image_type_to_extension($info[2], false);  //获取文件后缀
    $fun = "imagecreatefrom{$imgExt}";
    $imgInfo = $fun($img);                    //1.由文件或 URL 创建一个新图象。如:imagecreatefrompng ( string $filename )
    $mime = image_type_to_mime_type(exif_imagetype($img)); //获取图片的 MIME 类型
    if (!$imgInfo) {
        $im  = imagecreatetruecolor(150, 30);
        $bg = imagecolorallocate($im, 255, 255, 255);
        $text_color  = imagecolorallocate($im, 0, 0, 255);
        //填充背景色
        imagefilledrectangle($im, 0, 0, 150, 30, $bg);
        //以图像方式输出错误信息
        imagestring($im, 3, 5, 5, "Error loading image", $text_color);
    } else {
        header('Content-Type:' . $mime);
        $quality = 70;
        if ($imgExt == 'png') $quality = 9;        //输出质量,JPEG格式(0-100),PNG格式(0-9)
        $getImgInfo = "image{$imgExt}";
        $getImgInfo($imgInfo, null, $quality);    //2.将图像输出到浏览器或文件。如: imagepng ( resource $image )
        imagedestroy($imgInfo);
    }

}

function showImgEx($file){
    header("Content-type: image/jpeg");

    // 缩略图比例
    $percent = 0.5;
    // 缩略图尺寸
    list($width, $height) = getimagesize($file);
    $newwidth = $width * $percent;
    $newheight = $height * $percent;

    // 加载图像
    $src_im = @imagecreatefromjpeg($file);
    $dst_im = imagecreatetruecolor($newwidth, $newheight);
    // 调整大小
    imagecopyresized($dst_im, $src_im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    //输出缩小后的图像
    imagejpeg($dst_im);
    imagedestroy($dst_im);
    imagedestroy($src_im);
}

function curlSSLConnection($url, $port, $version, $crtPath, $pwd, $clientKeyPath)
{
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_PORT, $port);
    curl_setopt($curl, CURLOPT_SSLVERSION, $version);

    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //信任任何证书
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 检查证书中是否设置域名,0不验证
    curl_setopt($curl, CURLOPT_VERBOSE, 1); //debug模式
    curl_setopt($curl, CURLOPT_SSLCERT, $crtPath); //client.crt文件路径
    curl_setopt($curl, CURLOPT_SSLCERTPASSWD, $pwd); //client证书密码
    curl_setopt($curl, CURLOPT_SSLKEY, $clientKeyPath);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
    //设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    //设置post方式提交
    //执行命令
    $html  = curl_exec($curl);
    $error = curl_error($curl);

    //关闭URL请求
    curl_close($curl);
    if ($html != false) {
        return $html;
    } else {
        return $error;
    }
}
