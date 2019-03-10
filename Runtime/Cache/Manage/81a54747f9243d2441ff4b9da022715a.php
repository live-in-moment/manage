<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM--联系记录详情</title>
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

</head>
<body class="gray-bg">
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>个人密码修改</h5>
                </div>
                <div class="ibox-content">
                    <form class="form-horizontal m-t" id="signupForm">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">原密码：</label>
                            <div class="col-sm-4">
                                <input id="oldPassword" name="oldPassword" class="form-control" type="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" id="newInput">新密码：</label>
                            <div class="col-sm-4">
                                <input id="newPassword" name="newPassword" class="form-control" type="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" id="reviewInput">再次输入：</label>
                            <div class="col-sm-4">
                                <input id="reviewPwd" name="reviewPwd" class="form-control" type="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-3">
                                <button class="btn btn-primary" type="button" id="eidtPwdSubmit">提交</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="/Public/html/js/jquery-1.11.3.min.js"></script>
<script src="/Public/html/js/bootstrap.min.js?v=3.3.6"></script>
<script src="/Public/html/js/manage/WdatePicker.js"></script>
<script src="/Public/html/js/plugins/layer/layer.js"></script>
<script>
	var reg1 = /\d/;
    var reg2 = /[a-z]/;
    var reg3 = /[A-Z]/;
    var newP = $("#newPassword").val();
    var revi = $("#reviewPwd").val();
    $('#newPassword').on("keyup", function () {
        var newP = $("#newPassword").val();
        var revi = $("#reviewPwd").val();
        if(newP.length<10 || newP.length>15)
        {
            var innerH = "";
            innerH = '<span style="color:red;font-size:10px;">密码长度在10-15之间</span>';

            $("#newInput").html("新密码：");
            $("#newInput").append(innerH);
            $('#eidtPwdSubmit').attr('disabled', true);
            return false;
        }
        if ((reg1.test(newP) && reg2.test(newP) && reg3.test(newP))  == false) {
            innerH = '<span style="color:red;font-size:10px;">密码必须为大小写字母和数字的组合</span>';
            $("#newInput").html("新密码：");
            $("#newInput").append(innerH);
            $('#eidtPwdSubmit').attr('disabled', true);
            return false;
        }
        $("#newInput").html("新密码：");
        $('#eidtPwdSubmit').attr('disabled', false);
    });
    $("#reviewPwd").on("keyup", function () {
        var newP = $("#newPassword").val();
        var revi = $("#reviewPwd").val();
        if (newP != revi) {
            innerH = '<span style="color:red;font-size:10px;">两次密码输入不一致</span>';
            $("#reviewInput").html("再次输入：");
            $("#reviewInput").append(innerH);
            $('#eidtPwdSubmit').attr('disabled', true);
            return false;
        }else{
            $("#reviewInput").html("再次输入：");
            $('#eidtPwdSubmit').attr('disabled', false);
        }
    });
    $("#eidtPwdSubmit").on('click', function () {
        var newP = $("#newPassword").val();
        var revi = $("#reviewPwd").val();
        $('#eidtPwdSubmit').attr('disabled', true);
        if ($("#oldPassword").val() == "") {
            layer.msg("原密码不能为空！",
                {
                    icon: 5,
                    time : 500
                },function () {
                    $('#eidtPwdSubmit').attr('disabled', false);
                });
                return false;
             }
        var oldPwd = $('#oldPassword').val();
        var newPwd = $('#newPassword').val();
        var reviPwd = $('#reviewPwd').val();
        if (newPwd != reviPwd) {
            layer.msg("两次密码输入不一致！",
                {
                    icon: 5,
                    time : 500
                },function () {
                    $('#eidtPwdSubmit').attr('disabled', false);
                   
                }); 
            return false;
        }
        if (newP.length<10 || newP.length>15) {
            layer.msg("密码长度不够！",
                {
                    icon: 5,
                    time : 500
                },function () {
                    $('#eidtPwdSubmit').attr('disabled', false);
                    
                });
            return false;
        }
        if ((reg1.test(newP) && reg2.test(newP) && reg3.test(newP))  == false) {
            layer.msg("密码必须为大小写字母和数字的组合！",
                {
                    icon: 5,
                    time : 500
                },function () {
                    $('#eidtPwdSubmit').attr('disabled', false);
                    
                });
            return false;
        }
        $.ajax({
            type : 'POST',
            url : '/Manage/Index/checkPwd',
            data : {
                oldpwd : oldPwd
            },
            success : function (res) {
                if (res.status == 400) {
                    layer.msg(res.msg,
                    {
                        icon: 5,
                        time : 500
                    },function () {
                        $('#eidtPwdSubmit').attr('disabled', false);
                        
                    });
                    return false;
                }
                if (res.status == 200) {
                    var indexLoad = layer.load(1,'修改中', {shade : [0.1, '#fff']});
                    $.ajax({
                        type : 'POST',
                        url : '/Manage/Index/changePwd',
                        data : {
                            newpwd : newPwd
                        },
                        success : function (result) {
                            layer.close(indexLoad);
                            if (result.status == 200) {
                                layer.msg(result.msg,
                                    {
                                        icon : 6,
                                        time : 500
                                    },
                                    function(){
                                    window.parent.location.href = "/Manage/Public/login";
                                });
                            } else {
                                layer.alert(result.msg);
                            }
                        },
                        error : function (error) {
                            layer.close(indexLoad);
                           layer.alert('正在抢修bug');
                        }
                    });
                }
            }
        });
    });
</script>
</body>
</html>