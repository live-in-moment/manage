<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM--个人信息修改</title>
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
                    <h5><?php echo ($data["name"]); ?>联系方式修改</h5>
                </div>
                <div class="ibox-content">
                    <form class="form-horizontal m-t" id="signupForm">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" id="oldInput">原手机号码：</label>
                            <div class="col-sm-4">
                                <input id="oldPhone" name="oldPhone" class="form-control" type="text" readonly value="<?php echo ($data["mobilephone"]); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" id="newInput">新手机号码：</label>
                            <div class="col-sm-4">
                                <input id="newPhone" name="newPhone" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-3">
                                <button class="btn btn-primary" type="button" id="editPhoneSubmit">提交</button>
                            </div>
                        </div>
                    </form>
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
    $("#editPhoneSubmit").on('click', function () {
        $('#editPhoneSubmit').attr('disabled', 'disabled');
        var newphone = $("#newPhone").val();
        if (newphone == "") {
            $('#editPhoneSubmit').attr('disabled', false);
            layer.alert('新的电话不能为空');
            return false;
        }
        $.ajax({
            type : 'POST',
            url : '/Manage/Index/editPhone',
            data : {
                newphone : newphone
            },
            success : function (res) {
                if (res.status == 200) {
                    layer.msg(res.msg,
                        {
                            icon : 6,
                            time : 500
                        },
                        function () {
                            window.location.reload();
                        }
                    );
                } else {
                    layer.alert(res.msg);
                    $('#editPhoneSubmit').attr('disabled', false);
                }
            }
        });
    });
</script>
</body>
</html>