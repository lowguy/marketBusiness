<?php $this->piece('common/head.php', array('menu'=>$menu, 'selected_menu'=>'/admin/product/index','market'=>$markets['all'],'currentMarket'=>$markets['current'],'newOrder'=>$newOrder));?>
    <style>
        tr>td:first-child{
            position: relative;
        }
        tr>td:first-child>img{
            transition: .8s transform;
            transform: translateZ(0);
        }
        tr>td:hover{
            z-index: 9999;
        }
        tr>td:hover> img{
            transform: scale(12, 15) translateX(25px);
            -webkit-transform:scale(12, 15) translateX(25px);
            -moz-transform:scale(12, 15) translateX(25px);
            -ms-transform: scale(12, 15) translateX(25px);
            -o-transform: scale(12, 15) translateX(25px);
            transition: .8s transform;
        }
    </style>
    <div class="col-lg-10">
        <ol class="breadcrumb">
            <li class="active"><span class="active">商品列表</span></li>
        </ol>
        <div class="searchbox">
            <form class="pull-right form-inline">
                <div class="form-group">
                    <label for="market_parent">一级类别:</label>
                    <select class="form-control" id="p" name="p">
                        <?php
                        echo "<option value='0'>全部</option>";
                        foreach($categories as $key => $item){
                            if($item['id'] == $_GET['p']){
                                echo "<option value='{$item['id']}' SELECTED>{$item['title']}</option>";
                            }else{
                                echo "<option value='{$item['id']}'>{$item['title']}</option>";
                            }
                        }?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">名称:</label>
                    <input type="text" class="form-control" value="<?php echo $_GET['t'];?>" placeholder="请输入商品名称" name="t">
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
                    <th>封面</th>
                    <th>名称</th>
                    <th>类别</th>
                    <th>价格/￥</th>
                    <th>库存</th>
                </tr>
                </thead>
                <tbody>
<?php
foreach($products as $key => $item){
    echo <<<EOT
                <tr data-id="{$item['id']}">
                    <td><img src="http://admin.xxj365.com/static/upload/product/{$item['id']}.JPG" width=25px height=25px></td>
                    <td>{$item['title']}</td>
                    <td>{$item['category_name']}</td>
                    <td>{$item['price']}</td>
                    <td class="stock">
                             <input type="text" class="form-control"  style="width:120px" value="{$item['stock']}" readonly>
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