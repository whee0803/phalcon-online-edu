<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>修改菜单</title>
    <link href="/static/admin/css/frame.css" rel="stylesheet">
</head>
<body>
<div id="frame-top">
    当前位置&nbsp;<i class="iconfont" style="color:#666;font-size: 12px;">&#xe60e;</i>&nbsp;&nbsp;设置&nbsp;&nbsp;<i class="iconfont" style="color:#666;font-size: 12px;">&#xe60f;</i>&nbsp;&nbsp;站长设置&nbsp;&nbsp;<i class="iconfont" style="color:#666;font-size: 12px;">&#xe60f;</i>&nbsp;&nbsp;修改菜单
</div>
<div id="frame-toolbar">
    <ul>
        <li><a href="/admin/Site/menu"><i class="iconfont" style="color:white;font-size: 16px;">&#xe611;</i>&nbsp;&nbsp;菜单设置</a></li>
        <li><a href="/admin/Site/addEditMenu"><i class="iconfont" style="color:white;font-size: 16px;">&#xe610;</i>&nbsp;&nbsp;添加菜单</a></li>
    </ul>
</div>
<div id="frame-content">
    <form name="editMenu" method="post" class="ajax-form" action="/admin/Site/addEditMenu" novalidate="novalidate">
        <input type="hidden" name="addEditMenu" value="addEditMenu">
        <input type="hidden" name="id" value="<?php echo $thismenu['id']; ?>">
        <div class="frame-table-list">
            <div class="input-title">菜单信息</div>
            <table cellpadding="0" cellspacing="0" class="table_form" width="100%">
                <tbody>
                <tr>
                    <td width="140">上级菜单:</td>
                    <td>
                        <select name="pid" class="length_4">
                            <option value="0" <?php if ($thismenu['pid'] == 0) { ?>selected<?php } ?>>顶级菜单</option>
                            <?php foreach ($adminSelect as $menu) { ?>
                            <option value="<?php echo $menu['id']; ?>" <?php if ($menu['id'] == $thismenu['pid']) { ?>selected<?php } ?>><?php echo str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',$menu['level']); ?><if condition='$vo["level"] gt 0'>├─</if><?php echo $menu['html']; ?><?php echo $menu['name']; ?></option>
                            <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>菜单名称:</td>
                    <td><input type="text" class="input length_5" name="name" value="<?php echo $thismenu['name']; ?>" id="name"></td>
                </tr>
                <tr>
                    <td>控制器:</td>
                    <td><input type="text" class="input length_5" name="controller" id="controller" value="<?php echo $thismenu['controller']; ?>"></td>
                </tr>
                <tr>
                    <td>方法:</td>
                    <td><input type="text" class="input length_5" name="action" id="action" value="<?php echo $thismenu['action']; ?>"></td>
                </tr>
                <tr>
                    <td>菜单排序:</td>
                    <td><input type="text" class="input length_5" name="sort" id="sort" value="<?php echo $thismenu['sort']; ?>"></td>
                </tr>
                <tr>
                    <td>菜单图标：</td>
                    <td>
                        <input id="System_Menu_icons_input" name="icon" type="hidden" value="<?php echo $thismenu['icon']; ?>">
                        <strong id="System_Menu_icons" style="margin-right: 10px;"><i style='color: #666;font-size: 16px;' class='iconfont'><?php echo $thismenu['icon']; ?></i></span></strong>
                        <a class="btn" onclick="Show_System_Menu_icons()">选择图标</a>
                    </td>
                </tr>
                <tr>
                    <td>是否显示:</td>
                    <td><select name="isshow">
                        <option value="1" <?php if ($thismenu['isshow'] == 1) { ?>selected<?php } ?>>显示</option>
                        <option value="0" <?php if ($thismenu['isshow'] == 0) { ?>selected<?php } ?>>不显示</option>
                    </select>&nbsp;&nbsp;&nbsp;是否显示菜单在后台管理页面上</td>
                </tr>

                </tbody>
            </table>
        </div>
        <div class="frame-table-btn">
            <button class="btn ajax-add" type="submit">修改</button>
        </div>
    </form>
</div>

</body>
<script>
    var menumanage = '/admin/Site/menu';
    var iconPach = '/admin/SiteCom/iconsCls';
    var checkEditMname = '/admin/SiteCom/checkEditMname/?id='+<?php echo $thismenu['id']; ?>;
</script>
<script src="/static/common/js/jquery/jquery-1.12.3.min.js"></script>
<script src="/static/common/js/jquery.validate.min.js"></script>
<script src="/static/common/js/layer/layer.js"></script>
<script src="/static/admin/js/admin.common.js"></script>

<script>
    function Select_System_Menu_icons(icon){
        $("#System_Menu_icons").html('<i class="iconfont">'+icon+'</i>');
        $("#System_Menu_icons_input").val(icon);
        layer.closeAll();
    }
    function Show_System_Menu_icons(){
        layer.open({
            type: 1,
            title: '请选择菜单图标',
            shadeClose: true,
            shade: 0.8,
            offset: '100px',
            area: ['480px', '500px'],
            content: '正在加载图标中...' //iframe的url
        });
        $.post(iconPach,"",function(data){
            if(typeof data == 'object'){
                var content = [];
                for(x in data){
                    content[x] = "<a style='color: #666;font-size: 16px;cursor: pointer' class='iconfont' onclick=\"Select_System_Menu_icons('"+data[x]+"')\" style='cursor:pointer;'>"+data[x]+"</a>";
                }
                var ss = '<div style="padding:10px">';
                ss += content;
                ss += '</div>';
                $('.layui-layer-content').html("<div style='padding:10px;'>"+content.join(" ")+"</div>");
            } else {
                $('.layui-layer-content').html("<div style='padding:10px;color: #FFD700;'>图标加载失败，请联系管理员！</div>");
            }
        },'json').error(function(){
            $('.layui-layer-content').html("<div style='padding:10px;color: #FFD700;'>图标加载失败，请联系管理员！3秒后自动关闭...</div>");
        });

    }
    $(function(){
        jQuery.validator.addMethod("chinaese", function(value, element) {
            var chinaese = /^[\u4e00-\u9fa5]+$/;
            return this.optional(element) || (chinaese.test(value));
        }, "请输入中文");
        jQuery.validator.addMethod("english", function(value, element) {
            var english = /^[A-Za-z]+$/;
            return this.optional(element) || (english.test(value));
        }, "请输入英文字符串");
        $('form[name=editMenu]').validate({
            errorElement : 'span',
            validClass: "success",	//非常重要
            success : function (label) {
                label.addClass('success');
            },
            rules : {
                name : {
                    required : true,
                    chinaese : true,
                    remote : {
                        url : checkEditMname,
                        type : 'post',
                        dataType : 'json',
                        data : {
                            name : function(){
                                return $('#name').val();
                            }
                        }
                    }
                },
                controller : {
                    required : true,
                    english : true
                },
                action : {
                    required : true,
                    english : true
                },
                pid : {
                    required : true,
                    digits : true
                },
                sort : {
                    required : true,
                    digits : true
                }
            },
            messages : {
                name : {
                    required : "请输入菜单名称",
                    remote : '菜单名称已存在'
                },
                controller : {
                    required : "请输入控制器名称"
                },
                action : {
                    required : "请输入方法名称"
                },
                pid : {
                    required : "请输入父ID",
                    digits : '请输入整数'
                },
                sort : {
                    required : "请输入排序号",
                    digits : '请输入整数'
                }
            },
            submitHandler: function(form)
            {
                if($('button.btn').attr("disabledSubmit")){
                    $('button.btn').text('请勿重复提交...').prop('disabled', true).addClass('disabled');
                    return false;
                }
                $('button.btn').attr("disabledSubmit",true);
                var param = $('form[name=editMenu]').serialize();
                $.ajax({
                    url: $('form[name=editMenu]').attr('action'),
                    dataType:'json',
                    type:'POST',
                    data:param,
                    beforeSend: function(){
                        myload = layer.load(0,{time:3*1000});
                    },
                    success: function(data) {
                        if (!data.status) {
                            admin.alert('操作提示',''+data.info,2,'8000');
                            $('button.btn').text('修改').removeProp('disabled').removeClass('disabled');
                            $('button.btn').attr("disabledSubmit",'');
                        }else{
                            admin.countdown(3);
                            admin.alert('操作提示', '修改菜单成功!'+'<div>程序将在<b style="color:red;" id="second_show">03秒</b>后为你跳转！</div>', 1, '3000');
                            setTimeout(function () {
                                window.location.href = menumanage;
                            }, 3000);
                        }
                    },
                    error: function(data){
                        layer.close(layer.load(1));
                        admin.alert('提示信息',data.responseText,1,'3000');
                    }
                });
            }
        });
    });

</script>
</html>