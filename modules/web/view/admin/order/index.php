<?php $newOrder = (0 == $_GET['s']) ? 0 : $newOrder;$this->piece('common/head.php', array('menu'=>$menu, 'selected_menu'=>'/admin/order/index','market'=>$markets['all'],'currentMarket'=>$markets['current'],'newOrder'=>$newOrder));?>
<div class="col-lg-10">
    <ol class="breadcrumb">
        <li class="active"><span class="active">订单管理</span></li>
    </ol>
    <div class="form-group pull-left">
        <ul class="nav nav-tabs">
            <li <?php if(0 == $_GET['s']){?>class="active"<?php } ?>  data-status="0"><a href="javascript:void(0);">待处理</a></li>
            <li <?php if(1 == $_GET['s']){?>class="active"<?php } ?> data-status="1"><a href="javascript:void(0);">已处理</a></li>
        </ul>
    </div>

    <div class="searchbox <?php if(0 == $_GET['s']){echo "hide";}?>" >
        <form class="pull-right form-inline">
            <div class="form-group">
                <label for="order_no">订单号:</label>
                <input type="hidden" class="form-control" value="1" name="s" id="status">
                <input type="text" class="form-control" value="<?php echo $_GET['n'];?>" placeholder="请输入订单号" name="n">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">查询</button>
            </div>
        </form>
    </div>
    <div>
        <table id="categories" class="table table-hover">
            <thead>
                <tr>
                    <th>订单号</th>
                    <th>总价</th>
                    <th>商品</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach($orders as $key => $item){
echo <<<EOT
                <tr>
                    <td>{$item['order_no']}</td>
                    <td>￥{$item['amount']}</td>
                    <td>
EOT;
                        foreach($item['goods'] as $k => $v){
echo <<<EOT
    <p>{$v['title']} X {$v['number']}  ￥{$v['amount']}</p>
EOT;
                        }
echo <<<EOT
                </td>
                    <td>
                        <button class="btn-operate print">
                            <a href="javascript:void(0);"  data-id="{$item['order_id']}">打印小票</a>
                        </button>
EOT;
                if(1 !=$_GET['s']){
echo <<<EOT
                        <button class="btn-operate deal">
                            <a href="javascript:void(0);"  data-id="{$item['order_id']}">标记处理</a>
                        </button>
EOT;
                }
echo <<<EOT
                    </td>
                </tr>
EOT;
            }
            ?>
            </tbody>
        </table>
        <?php $pagination->render();?>
    </div>
</div>

<?php $this->piece('common/foot.php');?>