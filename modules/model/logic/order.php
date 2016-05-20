<?php
/**
 * Created by PhpStorm.
 * User: LegendFox
 * Date: 2016/5/10 0010
 * Time: 上午 11:50
 */

namespace model\logic;


use model\database\Table;

class Order
{
    public function search($shop,$status,$order_no,$page,$size){
        $res    = $this->orderProducts($shop);
        $orderIDs = array_unique(array_column($res,'order_id'));
        $ids    = implode(',',$orderIDs);
        $table  = new Table('`order`');
        $params = array();
        $filter = " LEFT JOIN order_merchant ON (order_merchant.order_id = order.order_id AND order_merchant.shop_id = $shop) WHERE order.order_id IN ( {$ids} )";
        if(in_array($status,array(0,1))){
            $filter .= (0 == $status) ? " AND order_merchant.status IS NULL" : " AND order_merchant.status = $status";
        }
        if($order_no){
            $filter .= ' AND order.order_no like CONCAT("%", ? , "%")';
            $params = array_merge($params,array($order_no));
        }
        $filter .= " ORDER BY order.created_at DESC";
        $result['total'] = $table->count($filter,$params,'order.order_id');
        $start  = $size * ($page - 1);
        $filter .= " LIMIT $start,$size";

        $fields = array(
            'order.order_id',
            'order.order_no'
        );
        $result['data']  = $table->lists($filter,$params,$fields);
        return $result;
    }

    public function newOrder($shop){
        $res    = $this->orderProducts($shop);
        if(empty($res)){
            return 0;
        }
        $orderIDs = array_unique(array_column($res,'order_id'));
        $ids    = implode(',',$orderIDs);
        $table  = new Table('`order`');
        $params = array();
        $filter = " LEFT JOIN order_merchant ON (order_merchant.order_id = order.order_id AND order_merchant.shop_id = $shop) WHERE order.order_id IN ( $ids ) AND order_merchant.status IS NULL";
        $filter .= " ORDER BY order.created_at DESC";
        return $table->count($filter,$params,'order.order_id');
    }

    public function orderProducts($shop,$order_id=NULL){
        $table  = new Table('order_product');
        $filter = " WHERE user_id = ?";
        $params = array($shop);
        if($order_id){
            $filter .= " AND order_id = ?";
            $params = array_merge($params,array($order_id));
        }
        return $table->lists($filter,$params);
    }

    public function printTicket($order_id,$shop){
        $table = new Table('order_merchant');
        $pdo   = $table->getConnection();
        $code = 0;
        try{
            $sql = "INSERT INTO order_merchant (shop_id,order_id,status) VALUES ($shop,$order_id,1) ON DUPLICATE KEY UPDATE shop_id = $shop, order_id = $order_id, status = 1";
            $statement = $pdo->prepare($sql);
            $statement->execute();
        }catch (\Exception $e){
            $code = $e->getCode();
        }
        return $code;
    }
}