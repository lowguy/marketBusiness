<?php
/**
 * Created by PhpStorm.
 * User: Monk
 * Date: 2016/1/25
 * Time: 13:31
 */
namespace model\logic;

class Menu{
    private $config = null;

    public function __construct(){

        $this->config =array(
            array(
                'name'=>'订单管理',
                'url'=>'/admin/order/index',
                'roles'=>array(100, 102),
            ),
            array(
                'name'=>'商品管理',
                'url'=>'/admin/product/index',
                'roles'=>array(100, 102),
            ),
            array(
                'name'=>'用户管理',
                'url'=>'/admin/user/index',
                'roles'=>array(100),
            )
        );
    }

    /**
     * @param $role integer
     * @return array
     */
    public function getMenus($role){
        $menu = array();
        foreach($this->config as $item){
            if(in_array($role, $item['roles'])){
                $menu[] = $item;
            }
        }

        return $menu;
    }
}