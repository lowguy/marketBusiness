<?php $this->piece('common/head.php', array('menu'=>$menu, 'selected_menu'=>'/admin/user/index','market'=>$markets['all'],'currentMarket'=>$markets['current'],'newOrder'=>$newOrder));?>
<div class="col-lg-10">
    <ol class="breadcrumb">
        <li class="active"><span class="active">用户管理</span></li>
    </ol>
    <div>
        <div class="form-group pull-left">
            <a class="function-button" href="/admin/user/add">
                <i class="icon-plus-sign"></i>
                <span>添加</span>
            </a>
        </div>
        <form class="pull-right form-inline">
            <div class="form-group">
                <label for="status">状态:</label>
                <select class="form-control" id="role" name="status">
                    <?php foreach($status_array as $id=>$value):?>
                        <option
                            <?php if($id == $_GET['status']):?>selected="selected"<?php endif;?>
                            value="<?php echo $id;?>"><?php echo $value;?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="form-group">
                <label for="phone">手机:</label>
                <input value="<?php echo $_GET['phone'];?>" class="form-control" type="text" name="phone" id="phone" />
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">查询</button>
            </div>
        </form>
    </div>
    <table  class="table table-hover">
        <thead>
            <tr>
                <th>
                    手机
                </th>
                <th>
                    状态
                </th>
                <th>
                    操作
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($users as $user):?>
                <tr data-id="<?php echo $user['user_id'] ;?>">
                    <td><?php echo $user['phone'] ;?></td>
                    <td><?php echo $user['status'] == 0 ? '禁用' : '启用' ;?></td>
                    <td>
                        <button class="btn-operate change-status" >
                            <a><?php echo $user['status'] == 1 ? '禁用' : '启用' ;?></a>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>
    <?php $pagination->render();?>
</div>
<?php $this->piece('common/foot.php');?>
