<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="Bookmark" href="/Public/favicon.ico">
    <link rel="Shortcut Icon" href="/Public/favicon.ico"/>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="/Public/hui/lib/html5shiv.js"></script>
    <script type="text/javascript" src="/Public/hui/lib/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="/Public/hui/static/h-ui/css/H-ui.min.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/hui/static/h-ui.admin/css/H-ui.admin.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/hui/lib/Hui-iconfont/1.0.8/iconfont.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/hui/static/h-ui.admin/skin/default/skin.css" id="skin"/>
    <link rel="stylesheet" type="text/css" href="/Public/hui/static/h-ui.admin/css/style.css"/>
    <link rel="stylesheet" href="/Public/html/css/manage/index/base.css" />
    <link rel="stylesheet" href="/Public/html/css/manage/index/index.css" />
    <!--[if IE 6]>
    <script type="text/javascript" src="/Public/hui/lib/DD_belatedPNG_0.0.8a-min.js"></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <title>MANAGE_ERP</title>
    <style>
        .logo img {
            vertical-align: top;
            height: 100%;
        }
        .crm-name {
            font-style: italic;
            color: #b4d9ff;
            font-family :"DejaVu Sans Mono";
            font-weight: 600;
            font-size: large;
            /*padding-top:10px;*/
            display: flex;
            align-items: center;
        }
        .msg-txt{
            color:white;
            font-weight: 400;
        }
        .msg-txt a:hover {
            color:red!important;
        }
        .navheader {
            display: flex;
            justify-content: space-between;
        }
        .msg-txt {
            margin-left: 100px;
        }
        .msg-txt:hover{
            color: red;
            text-decoration: none;
        }
        .Hui-aside .menu_dropdown li span{cursor:pointer; padding-left:15px; display:block;font-weight: bold; margin:0}
        .Hui-aside .menu_dropdown li span i{ font-weight: normal}
        .Hui-aside .menu_dropdown dd ul{padding:3px 8px}
        .Hui-aside .menu_dropdown dd li{line-height:32px}
        .Hui-aside .menu_dropdown dd li span{line-height:32px;padding-left:26px; border-bottom:none; font-weight:normal}
        .Hui-aside .menu_dropdown li span:hover{text-decoration:none}
        .Hui-aside .menu_dropdown li.current span,.menu_dropdown li.current span:hover{background-color:rgba(255,255,255,0.2)}

        .Hui-aside .menu_dropdown dt{color:#333}/*左侧二级导航菜单*/
        .Hui-aside .menu_dropdown dt:hover{color:#148cf1}
        .Hui-aside .menu_dropdown dt:hover [class^="icon-"]{ color:#7e8795}
        .Hui-aside .menu_dropdown li span{color:#666;border-bottom: 1px solid #e5e5e5}
        .Hui-aside .menu_dropdown li span:hover{color:#148cf1;background-color:#fafafa}
        .Hui-aside .menu_dropdown li.current span,.menu_dropdown li.current span:hover{color:#148cf1}
        .Hui-aside .menu_dropdown dt .Hui-iconfont{ color:#a0a7b1}
        .Hui-aside .menu_dropdown dt .menu_dropdown-arrow{ color:#b6b7b8}

    </style>
</head>
<body>
<header class="navbar-wrapper">
    <div class="navbar navbar-fixed-top" style="background: #2a83cf;">
        <div class="container-fluid navheader">
            <div class="crm-name">
                <!--<a class="logo navbar-logo f-l mr-10 hidden-xs" href="javascript:;"><img src="/Public/Admin/images/dwinlogo.png" alt=""></a>-->
                <a class="logo navbar-logo-m f-l mr-10 visible-xs" href="/"></a>
                <a aria-hidden="false" class="nav-toggle Hui-iconfont visible-xs" href="javascript:;">&#xe667;</a>管理系统</div>
            <nav id="" class="nav navbar-nav navbar-userbar hidden-xs">
                <ul class="cl">
                    <li>
                        <div class="msg-num1"></div>
                    </li>
                    <li style="margin-left: 100px;">(<?php echo ($data["post_name"]); ?>-<?php echo ($data["dept_name"]); ?>)</li>
                    <li class="dropDown dropDown_hover">
                        <a href="#" class="dropDown_A"><?php echo ($data["name"]); ?> <i class="Hui-iconfont">&#xe6d5;</i></a>
                        <ul class="dropDown-menu menu radius box-shadow">
                            <li><a href="javascript: ;" class="edit" data-href="/Manage/Index/editPhone"  data-title="修改电话">修改电话</a></li>
                            <li><a href="javascript: ;" class="edit" data-href="/Manage/Index/editPwd" data-title="修改密码">修改密码</a></li>
                            <li><a href="#" class="exit">退出</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>
<aside class="Hui-aside">
    <div class="menu_dropdown bk_2">
        <dl id="resume-module">
            <dt><i class="Hui-iconfont">&#xe616;</i> 简历管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li>
                        <a href="javascript:;" data-href="/Manage/resume/showBusinessList" data-title="简历管理">未处理简历管理</a>
                    </li>
                    <li>
                        <span class="myToggle" data-title="销货管理" href="javascript:;">销货管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></span>
                        <ul style="display: none;">
                            <li><a data-href="/Manage/Customer/showContract" href="javascript:;" data-title="销售合同">销售合同</a></li>
                        </ul>
                    </li>
                </ul>
            </dd>
        </dl>
    </div>
</aside>
<div class="dislpayArrow hidden-xs"><a class="pngfix" href="javascript:;;" onClick="displaynavbar(this)"></a>
</div>
<section class="Hui-article-box">
    <div id="Hui-tabNav" class="Hui-tabNav hidden-xs">
        <div class="Hui-tabNav-wp">
            <ul id="min_title_list" class="acrossTab cl">
                <li class="active">
                    <span title="我的桌面" data-href="welcome.html">我的桌面</span>
                    <em></em></li>
            </ul>
        </div>
        <div class="Hui-tabNav-more btn-group">
            <a id="js-tabNav-prev" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d4;</i></a>
            <a id="js-tabNav-next" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d7;</i></a>
        </div>
    </div>
    <div id="iframe_box" class="Hui-article">
        <div class="show_iframe">
            <div style="display:none" class="loading"></div>
            <iframe scrolling="yes" frameborder="0" src="/manage/index/home"></iframe>
        </div>
    </div>
</section>

<div class="contextMenu" id="Huiadminmenu">
    <ul>
        <li id="closethis">关闭当前</li>
        <li id="closeall">关闭全部</li>
    </ul>
</div>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/Public/html/js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="/Public/hui/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/Public/hui/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/Public/hui/static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/Public/hui/lib/jquery.contextmenu/jquery.contextmenu.r2.js"></script>
<script type="text/javascript">
    var moduleSys    =  $("#sys-module");
    var moduleResume  =  $("#resume-module");

    $('.myToggle').on('click', function () {
        $(this).next('ul').slideToggle()
        $(this).next('ul').parent().siblings().children('ul').hide(500)
    });
    $('.Hui-aside dt').on('click',function () {
        $('.Hui-aside ul li').children('ul').hide();
    })

    // 查询当前人需要处理的简历数量
    function getMsgCount() {
        //ajax
        //当前控制器是Index
        $.get("<?php echo U('Index/getMsgCount');?>", function (data) {
            //修改未读数量的显示
            if (data != "") {
                var innerHtml = '';
                if (data['resumeCount']) {
                    innerHtml += '<a class="msg-txt  deptAuthCount" href="javascript:;" date_src="/Manage/Customer/onlineRelationAuthList">结对客服审核：' + data['staffOnlineAuthCount'] + '</a>';
                }
            }
            $('.msg-num1').html("");
            $(".msg-num1").append(innerHtml);
        });

        $(".msg-num1").off('click').on('click', 'a', function () {
            layer.open({
                type: 2,
                area: ['90%', '90%'],
                shadeClose: true,
                title: "待办事项",
                content: $(this).attr('date_src')
            });
        });
    }
    $(function () {
//        声明反复性定时器
//            setInterval('getMsgCount()',5000);
    });

    // 退出登录
    $('.exit').click(function(){
        layer.confirm('确定退出系统?',
            {
                icon : 6
            },
            function(){
                window.location.href = "/Manage/Public/logout";
            });
    });
    $('.edit').on('click', function () {
        layer.open({
            type: 2,
            area: ['50%', '70%'],
            title: $(this).attr('data-title'),
            content: $(this).attr('data-href')
        });
    });

    // 判断权限
    $(document).ready(function() {
        // $.ajax({
        //     type: 'POST',
        //     url: '/Manage/Index/checkPostInfo',
        //     data: {flag: 1},
        //     success: function (ajaxData) {
        //         if (ajaxData['sys'] === 1) { moduleSys.html('');}
        //         if (ajaxData['saleservice'] === 1) { moduleSale.html('');}
        //         if (ajaxData['online'] === 1) { moduleOnline.html('');}
        //         if (ajaxData['finance'] === 1) { moduleFin.html('');}
        //         if (ajaxData['project'] === 1) { modulePrj.html('');}
        //         if (ajaxData['customer'] === 1) { moduleCus.html('');}
        //         if (ajaxData['production'] === 1) { moduleMRP.html('');}
        //         if (ajaxData['admin'] === 1) { moduleAdmin.html('');}
        //         if (ajaxData['purchase'] === 1) { modulePur.html('');}
        //         if (ajaxData['stock'] === 1) { moduleStock.html('');}
        //     }
        // });
    });
</script>
</body>
</html>