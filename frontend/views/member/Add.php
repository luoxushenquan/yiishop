<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>登录商城</title>
    <link rel="stylesheet" href="/style/base.css" type="text/css">
    <link rel="stylesheet" href="/style/global.css" type="text/css">
    <link rel="stylesheet" href="/style/header.css" type="text/css">
    <link rel="stylesheet" href="/style/login.css" type="text/css">
    <link rel="stylesheet" href="/style/footer.css" type="text/css">

    <script src="http://static.runoob.com/assets/jquery-validation-1.14.0/lib/jquery.js"></script>
    <script src="http://static.runoob.com/assets/jquery-validation-1.14.0/dist/jquery.validate.min.js"></script>
</head>
<body>

<!-- 顶部导航 start -->
<div class="topnav">
    <div class="topnav_bd w990 bc">
        <div class="topnav_left">

        </div>
        <div class="topnav_right fr">
            <ul>
                <li>您好，欢迎来到京西！[<a href="login.html">登录</a>] [<a href="register.html">免费注册</a>] </li>
                <li class="line">|</li>
                <li>我的订单</li>
                <li class="line">|</li>
                <li>客户服务</li>

            </ul>
        </div>
    </div>
</div>
<!-- 顶部导航 end -->

<div style="clear:both;"></div>

<!-- 页面头部 start -->
<div class="header w990 bc mt15">
    <div class="logo w990">
        <h2 class="fl"><a href="index.html"><img src="/images/logo.png" alt="京西商城"></a></h2>
    </div>
</div>
<!-- 页面头部 end -->

<!-- 登录主体部分start -->
<div class="login w990 bc mt10">
    <div class="login_hd">
        <h2>用户注册</h2>
        <b></b>
    </div>
    <div class="login_bd">
        <div class="login_form fl">
            <form action="<?=\yii\helpers\Url::to(['member/add'])?>" method="post" id="login_form">
                <ul>
                    <li>
                        <label for="">用户名：</label>
                        <input type="text" id="username" class="txt" name="username" />
                    </li>
                    <li>
                        <label for="">密码：</label>
                        <input type="password" id="password" class="txt" name="password_hash" />
                    </li>
                    <li>
                        <label for="">确认密码：</label>
                        <input type="password" id="confirm" class="txt" name="confirm" />
                    </li>
                    <li>
                        <label for="">邮箱：</label>
                        <input type="text" id="email" class="txt" name="email" />
                    </li>
                    <li>
                        <label for="">电话号码：</label>
                        <input type="text" id="tel" class="txt" name="tel" />
                    </li>
<!--                    <li>-->
<!--                        <label for="">短信验证码：</label>-->
<!---->
<!--                        <input type="text" class="txt" value="" placeholder="请输入短信验证码" name="sms" disabled="disabled" id="sms"/> <input type="button" onclick="bindPhoneNum(this)" id="get_captcha" value="获取验证码" style="height: 25px;padding:3px 8px"/>-->
<!---->
<!--                    </li>-->
                    <li class="checkcode">
                        <label for="">验证码：</label>
                        <input type="text"  name="checkcode" />
                        <img id="captcha" alt="" />
<!--                        <span>看不清？<a href="javascript:;" id="change_captcha">换一张</a></span>-->
                    </li>

                    <li>
                        <label for="">&nbsp;</label>
                        <input type="submit" value="注册" class="" />
                    </li>
                </ul>
            </form>

            <div class="coagent mt15">
                <dl>
                    <dt>使用合作网站登录商城：</dt>
                    <dd class="qq"><a href=""><span></span>QQ</a></dd>
                    <dd class="weibo"><a href=""><span></span>新浪微博</a></dd>
                    <dd class="yi"><a href=""><span></span>网易</a></dd>
                    <dd class="renren"><a href=""><span></span>人人</a></dd>
                    <dd class="qihu"><a href=""><span></span>奇虎360</a></dd>
                    <dd class=""><a href=""><span></span>百度</a></dd>
                    <dd class="douban"><a href=""><span></span>豆瓣</a></dd>
                </dl>
            </div>
        </div>


    </div>
</div>
<!-- 登录主体部分end -->

<div style="clear:both;"></div>
<!-- 底部版权 start -->
<div class="footer w1210 bc mt15">
    <p class="links">
        <a href="">关于我们</a> |
        <a href="">联系我们</a> |
        <a href="">人才招聘</a> |
        <a href="">商家入驻</a> |
        <a href="">千寻网</a> |
        <a href="">奢侈品网</a> |
        <a href="">广告服务</a> |
        <a href="">移动终端</a> |
        <a href="">友情链接</a> |
        <a href="">销售联盟</a> |
        <a href="">京西论坛</a>
    </p>
    <p class="copyright">
        © 2017-2020 卖拖鞋网上商城 版权所有，并保留所有权利。  ICP备案证书号:京ICP证070359号
    </p>

</div>
<!-- 底部版权 end -->
<script type="text/javascript">
    $().ready(function() {
// 在键盘按下并释放及提交后验证提交表单
        $("#login_form").validate({
            rules: {
                username: {
                    required: true,
                    minlength:3
               },
                password: {
                    required: true,
                    minlength:6
                },
                confirm:{
                    equalTo:"#password"
                },
                email:{
                    email:true
                },
                tel:{
                    digits:true
//                    range:[11,11]
                },
                checkcode:{
                    check_captcha:true
                },
                cms:{
                    remote: {
                        url: "<?=\yii\helpers\Url::to(['member/check-sms'])?>",     //后台处理程序
                        type: "post",               //数据发送方式
                        dataType: "json",           //接受数据格式
                        data: {                     //要传递的数据
                                sms: $("#sms").val(),
                                tel: $("#tel").val()
                        }
                    }
                }


            },
            messages: {
                username: {
                    required: "请输入用户名",
                    minlength:'用户名最少3位'

                },
                password: {
                    required: "请输入密码",
                    minlength: "密码长度不能小于 6 个字母",
                    equalTo: "两次输入的密码不一致"
                },
                email: "请输入有效的电子邮件地址",
                tel:{
                    digits:"请输入正确手机号"
//                    range:"请输入正确手机号"
                }

            },

            //设置错误信息的标签
            errorElement:'span'
        })
    });

    //验证验证码
    $("#captcha").click(function(){
        flush_captcha();
    });
    var flush_captcha = function(){
        $.getJSON('<?=\yii\helpers\Url::to(['site/captcha',\yii\captcha\CaptchaAction::REFRESH_GET_VAR=>1])?>',
            function(data){
                $("#captcha").attr('src',data.url);
                //获取验证码的hash值
                $("#captcha").attr('data-hash',data.hash1);

            });
    };
    flush_captcha();
    //这个玩意是在不好理解啊
    jQuery.validator.addMethod("check_captcha", function(value, element) {
        var hash = $("#captcha").attr('data-hash');
        var v =  value.toLowerCase();
        var h = 0;
        for (var i = v.length - 1; i >= 0; --i) {
            h += v.charCodeAt(i);
        }
        return h == hash;
    }, "你是机器人不能注册");



    ////短信验证
    function bindPhoneNum(){
        //1点击发送短信验证码按钮,获取手机号码,通过AJAX请求发送短信
        var phone = $("#tel").val();
//        console.debug(phone);
        //上面判断了手机号这里不判断
        $.get("<?=\yii\helpers\Url::to(['member/ajax-sms'])?>",{phone:phone},function(data){
            if(data == 'success'){
                alert('短信发送成功');
            }else{
                //发送失败
                alert('短信发送失败,请稍后再试.');
            }
        });


        //启用输入框
        $('#sms').prop('disabled',false);

        var time=60;
        var interval = setInterval(function(){
            time--;
            if(time<=0){
                clearInterval(interval);
                var html = '获取验证码';
                $('#get_captcha').prop('disabled',false);
            } else{
                var html = time + ' 秒后再次获取';
                $('#get_captcha').prop('disabled',true);
            }

            $('#get_captcha').val(html);
        },1000);
    }
</script>

</body>
</html>