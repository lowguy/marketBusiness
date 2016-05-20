<?php $this->piece('common/head.php', array('menu'=>$menu, 'selected_menu'=>'/admin/product/index','market'=>$markets['all'],'currentMarket'=>$markets['current'],'newOrder'=>$newOrder));?>
<div class="col-lg-10">
    <ol class="breadcrumb">
        <li class="active"><span class="active"><a href="javascript:history.back()">商户产品</a></span></li>
        <li class="active">
            <span class="active">
                修改
            </span>
        </li>
    </ol>
    <div class="searchbox">
        <form class="form-horizontal edit-form" method="post">
            <div class="row">
                <div class="col-lg-4 col-lg-offset-4">
                    <div class="col-lg-12">
                        <h2><?php echo $product['title'];?></h2>
                    </div>
                    <div class="col-lg-12">
                        <p class="form-control-static"><?php echo $product['slogan'];?></p>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-4 col-lg-offset-2">
                            <button type="submit" class="form-control btn-primary">保存</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php $this->piece('common/foot.php');?>
