<?php $this->piece('common/head.php', array('menu'=>$menu, 'selected_menu'=>'/admin/user/index','market'=>$markets['all'],'currentMarket'=>$markets['current'],'newOrder'=>$newOrder));?>
<div class="col-lg-10">
    <ol class="breadcrumb">
        <li><a href="/admin/user/index">用户管理</a></li>
        <li class="active"><span class="active">添加</span></li>
    </ol>
    <form class="form-horizontal user-form col-lg-4 col-md-offset-4" method="post">
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="icon-user"></i></span>
                <input name="phone" type="text" class="form-control" placeholder="手机号码"  aria-describedby="basic-addon1">
            </div>
        </div>
        <div  class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="icon-lock"></i></span>
                <input name="password" id="password" type="password" class="form-control" placeholder="密码" aria-describedby="basic-addon1">
            </div>
        </div>
        <div  class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="icon-lock"></i></span>
                <input name="confirm_password" type="password" class="form-control" placeholder="重复密码" aria-describedby="basic-addon1">
            </div>
        </div>
        <div class="form-group">
            <div class="input-group col-lg-8" style="float: left">
                <span class="input-group-addon"><i class="icon-shield"></i></span>
                <input id="code" name="code" type="text" class="pull-left form-control col-lg-6" placeholder="验证码" aria-describedby="basic-addon1">
            </div>
            <div class="input-group col-lg-2" style="float: right;text-align: right;">
                <button type="button" class="btn btn-primary code">获取验证码</button>
            </div>
        </div>
        <div class="form-group">
            <div class="text-center">
                <button type="submit" class="btn btn-primary submit">提交</button>
            </div>
        </div>
    </form>
</div>
<?php $this->piece('common/foot.php');?>
