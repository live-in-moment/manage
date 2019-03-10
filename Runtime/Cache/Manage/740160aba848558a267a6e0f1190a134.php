<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MANAGE CRM Login</title>
    <link rel="shortcut icon" href="/Public/favicon.ico">
    <link href="//lib.baomitu.com/twitter-bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<link href="//lib.baomitu.com/datatables/1.10.15/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="//lib.baomitu.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
<link href="//lib.baomitu.com/animate.css/3.2.6/animate.min.css" rel="stylesheet">
<link href="/Public/html/css/style.min862f.css?v=4.1.0" rel="stylesheet">
<link href="//lib.baomitu.com/chosen/1.8.3/chosen.min.css" rel="stylesheet">
<link href="/Public/html/css/plugins/iCheck/custom.css" rel="stylesheet">
<link href="/Public/html/css/plugins/iCheck/custom.css" rel="stylesheet">
<link href="/Public/html/plugins/laydate/theme/default/laydate.css" rel="stylesheet">
<script src="/Public/Admin/js/jsAddresss.js"></script>

<link href="/Public/html/css/plugins/select2/select2.min.css" rel="stylesheet">
<link href="/Public/html/plugins/dataTables-checkboxes/dataTables.checkboxes.css" rel="stylesheet">
<link href="//lib.baomitu.com/element-ui/2.3.6/theme-chalk/index.css" rel="stylesheet">
<link href="//lib.baomitu.com/layer/3.1.1/theme/default/layer.css" rel="stylesheet">
    <style>
        h1.logo-name{color:#00a0e9;font-size:130px;font-weight:300;letter-spacing:-10px;margin-bottom:0}
        .footer {
            position: absolute;
            bottom:0;
            left:0;
            padding-right: 0!important;
            margin-right: 0!important;
            text-align: center;
            width:100%;}
        .gohome{
            display:none!important;
        }
    </style>
</head>
<body class="gray-bg">
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>
                <h1 class="logo-name">MANAGE</h1>
            </div>
            <h3>欢迎使用 MANAGE ERP</h3>

            <form class="m-t" role="form" id="loginForm" name="forms">
                <div class="form-group">
                    <input id="firstname" name="username" class="form-control" type="text" placeholder="用户名">
                </div>
		        <div class="form-group">
                    <span id=box><input id="password" name="password" class="form-control" type="password" placeholder="密码" style="width: 75%;margin-bottom: 18px; float: left;"></span>
                    <span style="float: left;" id= 'click'><a href="javascript:showps()">显示密码</a></span>
                </div>
                <!--<div class="form-group">-->
                        <!--<input id="captcha" name="captcha" maxlength="4" class="form-control" style="width: 50%; height:34px;float: left;">-->
                        <!--<img style="float: left;margin-left: 10px;" src="/Manage/Public/captcha" onclick="this.src='/Manage/Public/captcha/t/'+Math.random()" />-->
                <!--</div>-->
                <button class="btn btn-primary block full-width m-b"  style="background-color: #00a0e9;" type="button" id="userLogin">登录</button>
            </form>
        </div>
    </div>
</body>
<footer>
    <div class="footer">
        <div class="pull-center">&emsp;ERP version2.1.2 &copy; 2018-2019 版权所有
            <a href="http://www.dwin.com.cn" target="_blank">北京迪文科技有限公司</a>
            <a href="http://www.miitbeian.gov.cn" target="_blank">京ICP备05033781号-4</a>
        </div>
    </div>
</footer>
<script src="//lib.baomitu.com/jquery/1.11.3/jquery.min.js"></script>
<script src="//lib.baomitu.com/vue/2.5.16/vue.js"></script>
<script src="//lib.baomitu.com/bluebird/3.5.1/bluebird.min.js"></script>
<script src="//lib.baomitu.com/vee-validate/2.0.6/vee-validate.min.js"></script>
<script src="//lib.baomitu.com/vee-validate/2.0.6/locale/zh_CN.js"></script>
<script src="//lib.baomitu.com/jquery.form/3.51/jquery.form.min.js"></script>
<script src="//lib.baomitu.com/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="//lib.baomitu.com/datatables/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="//lib.baomitu.com/datatables/1.10.15/js/dataTables.bootstrap.min.js"></script>
<script src="//lib.baomitu.com/layer/3.1.1/layer.js"></script>
<script src="/Public/html/js/plugins/laydate/laydate.js"></script>
<script src="//lib.baomitu.com/chosen/1.8.3/chosen.jquery.min.js"></script>
<script src="//lib.baomitu.com/element-ui/2.3.6/index.js"></script>
<script src="//lib.baomitu.com/element-ui/2.3.6/locale/zh-CN.min.js"></script>
<script src="/Public/html/js/content.min.js?v=1.0.0"></script>
<script src="//lib.baomitu.com/moment.js/2.22.1/moment-with-locales.min.js"></script>
<script src="//lib.baomitu.com/moment.js/2.22.1/moment.min.js"></script>
<script src="//lib.baomitu.com/peity/2.0.3/jquery.peity.min.js"></script>
<script src="/Public/html/js/demo/peity-demo.min.js"></script>
<script src="/Public/html/js/demo/form-advanced-demo.min.js"></script>
<script src="/Public/html/js/Manage/WdatePicker.js"></script>
<script src="/Public/html/js/area.js"></script>
<script src="/Public/html/js/plugins/prettyfile/bootstrap-prettyfile.js"></script>
<script src="/Public/html/js/plugins/validate/jquery.validate.min.js"></script>
<script src="/Public/html/js/plugins/validate/messages_zh.min.js"></script>
<script src="/Public/html/js/Manage/customer/common_func.js"></script>
<script src="/Public/html/js/plugins/jasny/jasny-bootstrap.min.js"></script>
<script src="/Public/html/js/dist/js/select2.min.js"></script>
<script>
    $.fn.dataTable.ext.errMode = 'throw';
</script>
<script type="text/javascript">
/*    $("body").jParticle({
        background: "#141414",
        color: "#E6E6E6"
    });*/
  function showps(){
        if (this.forms.password.type="password") {

            document.getElementById("box").innerHTML="<input id=\"password\" name=\"password\" class=\"form-control\" type=\"text\" placeholder=\"密码\" style=\"width: 75%;margin-bottom: 18px; float: left;\" value="+this.forms.password.value+">";
            document.getElementById("click").innerHTML="<a href=\"javascript:hideps()\">隐藏密码</a>"
        }
    }
    function hideps(){
        if (this.forms.password.type="text") {
            document.getElementById("box").innerHTML="<input id=\"password\" name=\"password\" class=\"form-control\" type=\"password\" placeholder=\"密码\" style=\"width: 75%;margin-bottom: 18px; float: left;\" value="+this.forms.password.value+">";
            document.getElementById("click").innerHTML="<a href=\"javascript:showps()\">显示密码</a>"
        }
    }

    $(document).keyup(function(event){
        if(event.keyCode == 13){
            $("#userLogin").trigger("click");
        }
    });
    function checkPost ()
    {
        if (!loginForm.username.value)
        {
             layer.alert("请填写用户名！",
                { icon : 5 }
            );
            return false;

        }
        if (!loginForm.password.value)
        {
            layer.alert("请输入密码",
                { icon : 5 }
            );
            return false;
        }
        // if (!loginForm.captcha.value)
        // {
        //     layer.alert("你的验证码呢",
        //         { icon : 5 }
        //     );
        //     return false;
        // }
        return true;
    }
    $("#userLogin").on('click', function () {
        $("#userLogin").attr("disabled","disabled");
        $("#loginForm").attr('disabled',"disabled");
        var rst = checkPost();
        if (rst == false) {
            $("#userLogin").attr("disabled",false);
            return false;
        }
        var indexLoad = layer.load(1, {shade : [0.1, '#fff']});
        $.ajax({
            type : 'POST',
            url  : '/Manage/Public/loginOk',
            data : $("#loginForm").serializeArray(),
            success : function (res) {
                layer.close(indexLoad);
                if (res.status == 200) {
                    window.location.href = "/Manage/crm";
                } else {
                    layer.msg(res.msg)
                }
            },
            error : function (error) {
                layer.close(indexLoad);
                $("#userLogin").attr("disabled", false);
            }
        });
    });
</script>
</html>