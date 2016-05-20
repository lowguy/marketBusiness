/**
 * Created by Administrator on 2016/5/9 0009.
 */
var limitTime = 60,intervalID;
$(function(){
    $(document).on('click','button.code',function(){
        if(!$(this).hasClass('countdown')){
            getCode();
        }
    });
    $('.user-form').validate({
        errorElement:'div',
        errorClass:'help-block',
        focusInvalid:false,
        highlight : function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        success : function(label) {
            label.closest('.form-group').removeClass('has-error');
            label.remove();
        },
        errorPlacement : function(error, element) {
            element.parents('div.form-group').append(error);
        },
        rules:{
            phone:{
                required:true,
                mobile:true,
                remote:{
                    url:'/admin/user/phoneUsed',
                    type:'POST'
                }
            },
            password:{
                required:true,
                minlength:6,
                maxlength:32
            },
            confirm_password: {
                required: true,
                minlength: 6,
                equalTo: "#password"
            },
            code:{
                required:true,
                minlength:4
            }
        },

        messages:{
            phone:{
                required:'请输入手机号码',
                mobile:'请输入手机号码',
                remote:'该手机号码已被注册'
            },
            password: {
                required: "请输入密码",
                minlength: "密码长度不能小于 6 个字母",
                maxlength: "密码长度不能大于 32 个字母"
            },
            confirm_password: {
                required: "请输入密码",
                minlength: "密码长度不能小于 6 个字母",
                equalTo: "两次密码输入不一致"
            },
            code:{
                required:'验证码错误',
                minlength:'验证码错误'
            }
        },

        submitHandler:function(form){
            var phone = $('input[name="phone"]').val();
            var password = $('input[name="password"]').val();
            var code  = $('input[name="code"]').val();
            add(phone, password, code);
        }
    });
});

function countdown(limitTime,selector){
    intervalID = setInterval(function(){
        (limitTime > 0) ? $(selector).addClass('countdown').html(limitTime-- + 's后重新获取') : $(selector).removeClass('countdown').html('重新获取');
    },1000);
}

function getCode(){
    var phone = $('input[name="phone"]').val();
    if(!phone){
        return;
    }

    $.ajax({
        url:'/sms/index/sendRegister',
        type:'POST',
        dataType:'JSON',
        data:{
            phone:phone
        },
        success:function(data,err){
            if(data.code == 0){
                clearInterval(intervalID);
                countdown(limitTime,'button.code');
            }
        },
        error:function(err){
            form_error()
        }
    });
}

function add(phone, password, code){
    $.ajax({
        url:'/admin/user/add',
        type:'POST',
        dataType:'JSON',
        data:{
            phone:phone,
            password:password,
            code:code
        },
        success:function(data,err){
            if(data.code == 0){
                location.href = "/admin/user/index";
            }
        },
        error:function(err){
            form_error()
        }
    });
}